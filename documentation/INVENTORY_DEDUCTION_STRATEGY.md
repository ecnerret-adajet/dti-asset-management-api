# Inventory Deduction Strategy - Asset Model

## Current System Analysis

### Existing Behavior (Problems Identified)
The current implementation in `OrdersController.php` has critical flaws:

1. **Immediate Deduction on Order Creation** (Line 75-76)
   - Stock is deducted immediately when order is created with status "Pending"
   - No differentiation between reserved/pending and actually delivered items
   - `current_value` is reduced before order is confirmed/delivered

2. **Stock Restoration on Update** (Line 119-120)
   - Previous order quantities are restored to stock
   - Then new quantities are deducted again
   - This happens regardless of order status

3. **Stock Restoration on Failed Orders** (Line 166)
   - Only status ID 4 (assumed "Failed") restores stock
   - No handling for cancelled or other terminal states

### Database Schema
- **Asset Model**: `current_value` field stores available inventory
- **Order-Asset Pivot**: `asset_order` table with `qty`, `unit_price`, `total_amount`
- **Order Statuses**: Referenced by `order_status_id` (IDs: 1=Pending, 4=Failed based on code)

## Proposed Strategy

### Core Principles

1. **Dual Inventory Tracking**
   - `current_value` = Actual available inventory (what's physically in stock)
   - `reserved_quantity` = Quantity reserved for pending orders
   - `available_quantity` = current_value - reserved_quantity (calculated)

2. **Status-Based Inventory Management**
   - **Pending/Processing Orders**: Reserve inventory (don't deduct)
   - **Delivered Orders**: Complete deduction from inventory
   - **Failed/Cancelled Orders**: Release reserved inventory

3. **Audit Trail**
   - Track all inventory movements
   - Maintain history of reservations and deductions
   - Leverage existing Laravel Auditing package

### Implementation Plan

#### Phase 1: Database Schema Changes

**1.1 Add New Columns to Assets Table**
```sql
ALTER TABLE assets ADD COLUMN reserved_quantity INT DEFAULT 0;
ALTER TABLE assets ADD COLUMN available_quantity INT GENERATED ALWAYS AS (current_value - reserved_quantity) VIRTUAL;
```

**1.2 Create Inventory Transactions Table**
```sql
CREATE TABLE inventory_transactions (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    asset_id BIGINT UNSIGNED NOT NULL,
    order_id BIGINT UNSIGNED NULL,
    transaction_type ENUM('reservation', 'deduction', 'release', 'adjustment'),
    quantity INT NOT NULL,
    previous_current_value INT,
    new_current_value INT,
    previous_reserved_quantity INT,
    new_reserved_quantity INT,
    reference_type VARCHAR(255) NULL,
    reference_id BIGINT UNSIGNED NULL,
    notes TEXT NULL,
    created_by BIGINT UNSIGNED,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    FOREIGN KEY (asset_id) REFERENCES assets(id),
    FOREIGN KEY (order_id) REFERENCES orders(id),
    FOREIGN KEY (created_by) REFERENCES users(id)
);
```

**1.3 Order Status Definitions Table**
Ensure order statuses are clearly defined:
- 1: Pending
- 2: Processing
- 3: Delivered
- 4: Failed
- 5: Cancelled

#### Phase 2: Model Updates

**2.1 Asset Model Enhancements**
```php
// Add to fillable
protected $fillable = [..., 'reserved_quantity'];

// Add computed attribute
protected $appends = ['available_quantity'];

public function getAvailableQuantityAttribute()
{
    return $this->current_value - $this->reserved_quantity;
}

// Add relationship
public function inventoryTransactions()
{
    return $this->hasMany(InventoryTransaction::class);
}

// Add scope for available assets
public function scopeAvailable($query, $minimumQty = 1)
{
    return $query->whereRaw('(current_value - reserved_quantity) >= ?', [$minimumQty]);
}
```

**2.2 Create InventoryTransaction Model**
```php
namespace App\Models;

class InventoryTransaction extends Model
{
    protected $fillable = [
        'asset_id', 'order_id', 'transaction_type', 'quantity',
        'previous_current_value', 'new_current_value',
        'previous_reserved_quantity', 'new_reserved_quantity',
        'reference_type', 'reference_id', 'notes', 'created_by'
    ];

    public function asset() { return $this->belongsTo(Asset::class); }
    public function order() { return $this->belongsTo(Order::class); }
    public function creator() { return $this->belongsTo(User::class, 'created_by'); }
}
```

#### Phase 3: Service Layer Implementation

**3.1 Create InventoryService**
```php
namespace App\Services;

class InventoryService
{
    /**
     * Reserve inventory for pending order
     */
    public function reserveInventory(Order $order, array $items): bool
    {
        foreach ($items as $item) {
            $asset = Asset::find($item['id']);

            // Check availability
            if ($asset->available_quantity < $item['qty']) {
                throw new InsufficientInventoryException();
            }

            // Reserve quantity
            $asset->reserved_quantity += $item['qty'];
            $asset->save();

            // Log transaction
            InventoryTransaction::create([
                'asset_id' => $asset->id,
                'order_id' => $order->id,
                'transaction_type' => 'reservation',
                'quantity' => $item['qty'],
                'previous_reserved_quantity' => $asset->reserved_quantity - $item['qty'],
                'new_reserved_quantity' => $asset->reserved_quantity,
                'created_by' => auth()->id()
            ]);
        }

        return true;
    }

    /**
     * Complete deduction when order is delivered
     */
    public function completeDeduction(Order $order): bool
    {
        foreach ($order->assets as $orderAsset) {
            $asset = Asset::find($orderAsset->id);
            $qty = $orderAsset->pivot->qty;

            // Deduct from actual inventory
            $asset->current_value -= $qty;

            // Release reservation
            $asset->reserved_quantity -= $qty;
            $asset->save();

            // Log transaction
            InventoryTransaction::create([
                'asset_id' => $asset->id,
                'order_id' => $order->id,
                'transaction_type' => 'deduction',
                'quantity' => $qty,
                'previous_current_value' => $asset->current_value + $qty,
                'new_current_value' => $asset->current_value,
                'previous_reserved_quantity' => $asset->reserved_quantity + $qty,
                'new_reserved_quantity' => $asset->reserved_quantity,
                'created_by' => auth()->id()
            ]);
        }

        return true;
    }

    /**
     * Release reserved inventory (cancel/fail)
     */
    public function releaseReservation(Order $order): bool
    {
        foreach ($order->assets as $orderAsset) {
            $asset = Asset::find($orderAsset->id);
            $qty = $orderAsset->pivot->qty;

            // Release reservation only
            $asset->reserved_quantity -= $qty;
            $asset->save();

            // Log transaction
            InventoryTransaction::create([
                'asset_id' => $asset->id,
                'order_id' => $order->id,
                'transaction_type' => 'release',
                'quantity' => $qty,
                'previous_reserved_quantity' => $asset->reserved_quantity + $qty,
                'new_reserved_quantity' => $asset->reserved_quantity,
                'created_by' => auth()->id()
            ]);
        }

        return true;
    }
}
```

#### Phase 4: Controller Updates

**4.1 OrdersController::store() - Revised Logic**
```php
public function store(Request $request)
{
    DB::beginTransaction();
    try {
        // Create order
        $order = new Order;
        $order->user_id = Auth::user()->id;
        $order->order_reference = $this->generateOrderReference();
        $order->customer_id = $request->selected_customer['id'];
        $order->order_status_id = 1; // Pending
        $order->total_cost = $request->grand_total;
        $order->total_orders = $request->total_qty_orders;
        $order->save();

        // Attach assets
        foreach($request->selected_orders as $item) {
            $order->assets()->attach($item['id'], [
                'qty' => $item['qty'],
                'unit_price' => $item['unit_price'],
                'total_amount' => $item['unit_price_total']
            ]);
        }

        // RESERVE inventory (don't deduct)
        app(InventoryService::class)->reserveInventory($order, $request->selected_orders);

        DB::commit();
        return Redirect::route('orders')->with('success', 'Order created successfully.');
    } catch (\Exception $e) {
        DB::rollback();
        return Redirect::back()->withErrors(['error' => $e->getMessage()]);
    }
}
```

**4.2 OrdersController::updateOrderStatus() - Revised Logic**
```php
public function updateOrderStatus(Request $request, $id)
{
    $this->validate($request, ['order_status_id' => 'required']);

    DB::beginTransaction();
    try {
        $order = Order::with('assets')->findOrFail($id);
        $oldStatus = $order->order_status_id;
        $newStatus = $request->order_status_id;

        $order->order_status_id = $newStatus;
        $order->save();

        $inventoryService = app(InventoryService::class);

        // Handle status transitions
        if ($newStatus == 3) { // Delivered
            $inventoryService->completeDeduction($order);
        }
        elseif (in_array($newStatus, [4, 5])) { // Failed or Cancelled
            $inventoryService->releaseReservation($order);
        }

        DB::commit();
        return Redirect::route('orders')->with('success', 'Status updated successfully');
    } catch (\Exception $e) {
        DB::rollback();
        return Redirect::back()->withErrors(['error' => $e->getMessage()]);
    }
}
```

**4.3 OrdersController::update() - Revised Logic**
```php
public function update(Request $request, $id)
{
    DB::beginTransaction();
    try {
        $order = Order::with('assets')->findOrFail($id);

        // Only allow updates for Pending/Processing orders
        if (!in_array($order->order_status_id, [1, 2])) {
            throw new \Exception('Cannot update delivered/completed orders');
        }

        $inventoryService = app(InventoryService::class);

        // Release old reservations
        $inventoryService->releaseReservation($order);

        // Detach old assets
        $order->assets()->detach();

        // Update order
        $order->customer_id = $request->selected_customer['id'];
        $order->total_cost = $request->grand_total;
        $order->total_orders = $request->total_qty_orders;
        $order->save();

        // Attach new assets
        foreach($request->selected_orders as $item) {
            $order->assets()->attach($item['id'], [
                'qty' => $item['qty'],
                'unit_price' => $item['unit_price'],
                'total_amount' => $item['unit_price_total']
            ]);
        }

        // Create new reservations
        $inventoryService->reserveInventory($order, $request->selected_orders);

        DB::commit();
        return Redirect::route('orders')->with('success', 'Order updated successfully.');
    } catch (\Exception $e) {
        DB::rollback();
        return Redirect::back()->withErrors(['error' => $e->getMessage()]);
    }
}
```

#### Phase 5: Frontend Updates

**5.1 Asset Listing - Show Available Quantity**
- Display both `current_value` and `available_quantity`
- Visual indicator for reserved quantities
- Filter assets with available quantity > 0

**5.2 Order Creation - Validation**
- Check `available_quantity` instead of `current_value`
- Real-time availability checks
- Warning messages for low stock

**5.3 Inventory Dashboard**
- Show reserved quantities per asset
- List pending orders affecting each asset
- Stock status indicators (Available, Low Stock, Reserved, Out of Stock)

#### Phase 6: Migration & Data Cleanup

**6.1 Migration Strategy**
```php
// Migration to add reserved_quantity
public function up()
{
    Schema::table('assets', function (Blueprint $table) {
        $table->integer('reserved_quantity')->default(0)->after('current_value');
    });

    // Calculate reserved quantities for existing pending orders
    $pendingOrders = Order::whereIn('order_status_id', [1, 2])->with('assets')->get();

    foreach ($pendingOrders as $order) {
        foreach ($order->assets as $asset) {
            $assetModel = Asset::find($asset->id);
            $assetModel->reserved_quantity += $asset->pivot->qty;
            $assetModel->save();
        }
    }
}
```

**6.2 Data Validation**
- Audit current inventory values
- Identify negative stock issues
- Reconcile order quantities with actual deductions

### Testing Strategy

#### Unit Tests
- Asset reservation logic
- Deduction completion
- Reservation release
- Negative stock prevention

#### Integration Tests
- Order creation flow (Pending → Reserved)
- Status change flow (Pending → Delivered → Deducted)
- Cancellation flow (Pending → Cancelled → Released)
- Order update flow (Release → Reserve new quantities)

#### Edge Cases
- Concurrent order creation for same asset
- Order updates after partial delivery
- Negative inventory scenarios
- Database transaction rollbacks

### Rollout Plan

1. **Phase 1 (Week 1)**: Database changes + Migration
2. **Phase 2 (Week 1)**: Model updates + Service layer
3. **Phase 3 (Week 2)**: Controller refactoring
4. **Phase 4 (Week 2)**: Frontend updates
5. **Phase 5 (Week 3)**: Testing + QA
6. **Phase 6 (Week 3)**: Data migration + Production deployment

### Benefits

1. **Accurate Inventory Tracking**
   - Clear separation between reserved and available
   - Real-time visibility of pending commitments

2. **Better Business Logic**
   - Orders don't deduct until delivered
   - Automatic reservation management

3. **Audit Trail**
   - Complete transaction history
   - Easy reconciliation and debugging

4. **Flexibility**
   - Handle partial deliveries (future enhancement)
   - Support backorders and pre-orders
   - Enable inventory forecasting

### Future Enhancements

- Partial delivery support
- Low stock alerts and notifications
- Automatic reorder points
- Multi-location inventory tracking
- Batch/lot number tracking
