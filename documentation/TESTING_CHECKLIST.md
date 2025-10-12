# Dashboard Testing Checklist

**Date:** October 12, 2025  
**Feature:** Enhanced Dashboard with Charts

---

## Pre-Testing Setup

### 1. Ensure Database Has Sample Data
```sql
-- Check if you have data
SELECT COUNT(*) as total_assets FROM assets;
SELECT COUNT(*) as total_orders FROM orders;
SELECT COUNT(*) as total_receivings FROM receivings;
SELECT COUNT(*) as order_statuses FROM order_statuses;
SELECT COUNT(*) as receiving_statuses FROM receiving_statuses;
```

**Minimum Requirements:**
- At least 5-10 assets
- At least 3-5 orders
- At least 2-3 receivings
- Order statuses configured
- Receiving statuses configured

### 2. Clear All Caches
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
npm run dev
```

### 3. Verify Server is Running
```bash
# Check if Laravel server is running
php artisan serve --port=8585

# Or if using different server
# Check your .env file for APP_URL
```

---

## Testing Steps

### ✅ Step 1: Test Web Route (Inertia)

**URL:** `http://127.0.0.1:8585/dashboard`

**Expected Results:**
- [ ] Page loads without errors
- [ ] No "Class 'Inertia' not found" error
- [ ] Dashboard layout displays correctly
- [ ] Header shows "Inventory Dashboard"

**If Failed:**
- Check `routes/web.php` has `use Inertia\Inertia;`
- Verify route is inside `auth` middleware group
- Check if you're logged in

---

### ✅ Step 2: Test API Endpoint

**Method:** GET  
**URL:** `http://127.0.0.1:8585/api/dashboard/all`

**Using Browser:**
1. Open browser DevTools (F12)
2. Go to Network tab
3. Navigate to `/dashboard`
4. Look for `/api/dashboard/all` request
5. Check response status and data

**Using cURL:**
```bash
curl -X GET http://127.0.0.1:8585/api/dashboard/all \
  -H "Accept: application/json" \
  -H "Content-Type: application/json"
```

**Expected Response Structure:**
```json
{
  "success": true,
  "data": {
    "summary": {
      "total_assets": 8,
      "total_inventory_value": 16400.00,
      "total_inventory_value_formatted": "₱16,400.00",
      "low_stock_items": 3,
      "out_of_stock_items": 2,
      "orders_today": 0,
      "pending_receivings": 1
    },
    "stock_distribution": {
      "labels": ["In Stock", "Low Stock", "Out of Stock", "Overstock"],
      "values": [3, 3, 2, 0],
      "colors": ["#1BC5BD", "#FFA800", "#F64E60", "#3699FF"]
    },
    "inventory_trend": {
      "labels": ["Oct 13", "Oct 14", ...],
      "datasets": [...]
    },
    "daily_orders": {
      "labels": ["Sun, Oct 6", ...],
      "datasets": [...]
    },
    "daily_receivings": {
      "labels": ["Sun, Oct 6", ...],
      "datasets": [...]
    },
    "low_stock_alerts": [...],
    "recent_orders": [...],
    "recent_receivings": [...],
    "order_status_details": [...],
    "receiving_status_details": [...]
  },
  "timestamp": "2025-10-12T13:17:39.000000Z"
}
```

**If Failed:**
- Check if API route exists in `routes/api.php`
- Verify `ReportsApiController::getAllDashboardData()` method exists
- Check database connection
- Look for PHP errors in `storage/logs/laravel.log`

---

### ✅ Step 3: Test Summary Cards

**Visual Check:**
- [ ] **Card 1:** Total Assets - Shows correct count
- [ ] **Card 2:** Inventory Value - Shows formatted currency (₱)
- [ ] **Card 3:** Low Stock Items - Shows count with warning color
- [ ] **Card 4:** Out of Stock - Shows count with danger color
- [ ] **Card 5:** Orders Today - Shows today's order count
- [ ] **Card 6:** Pending Requests - Shows pending receivings count

**Console Check:**
```javascript
// Open browser console and check:
console.log('Summary:', summary.value);
```

---

### ✅ Step 4: Test Charts Display

#### A. Inventory Trend (Line Chart)
**Location:** Top row, left side

**Visual Check:**
- [ ] Chart displays with 30 days of data
- [ ] Two lines visible: Orders (red) and Receivings (teal)
- [ ] Legend shows at top
- [ ] X-axis shows dates
- [ ] Y-axis shows counts
- [ ] No console errors

**Console Check:**
```javascript
console.log('Inventory Trend:', inventoryTrend.value);
```

#### B. Stock Level Distribution (Doughnut Chart)
**Location:** Top row, right side

**Visual Check:**
- [ ] Doughnut chart displays
- [ ] Four segments visible with different colors
- [ ] Legend shows at bottom with labels
- [ ] Colors match: In Stock (teal), Low Stock (orange), Out of Stock (red), Overstock (blue)
- [ ] No console errors

**Console Check:**
```javascript
console.log('Stock Distribution:', stockDistribution.value);
console.log('Stock Distribution Data:', stockDistributionData.value);
```

**If Empty:**
- Check if `stockDistribution.value` has data
- Verify `stockDistributionData` computed property formats correctly
- Check API returns `labels`, `values`, and `colors` arrays

#### C. Daily Orders (Bar Chart)
**Location:** Middle row, left side

**Visual Check:**
- [ ] Bar chart displays
- [ ] Shows last 7 days of data
- [ ] Bars are blue (#3699FF)
- [ ] X-axis shows dates (e.g., "Sun, Oct 6")
- [ ] Y-axis shows order counts
- [ ] No console errors

**Console Check:**
```javascript
console.log('Daily Orders:', dailyOrders.value);
console.log('Daily Orders Data:', dailyOrdersData.value);
```

**If Empty:**
- Check if `dailyOrders.value` has data
- Verify `dailyOrdersData` computed property works
- Check API returns `labels` and `datasets` arrays

#### D. Daily Receivings (Bar Chart)
**Location:** Middle row, right side

**Visual Check:**
- [ ] Bar chart displays
- [ ] Shows last 7 days of data
- [ ] Bars are teal (#1BC5BD)
- [ ] X-axis shows dates
- [ ] Y-axis shows receiving counts
- [ ] No console errors

**Console Check:**
```javascript
console.log('Daily Receivings:', dailyReceivings.value);
console.log('Daily Receivings Data:', dailyReceivingsData.value);
```

---

### ✅ Step 5: Test Data Tables

#### A. Low Stock Alerts Table
**Location:** Bottom row, left column

**Check:**
- [ ] Table displays with headers: Asset, Qty, Status
- [ ] Shows assets with quantity < 10
- [ ] Quantity badges are colored (red for critical, orange for warning)
- [ ] Status dots match badge colors
- [ ] Shows "No low stock items" if empty

#### B. Recent Orders Table
**Location:** Bottom row, middle column

**Check:**
- [ ] Table displays recent orders
- [ ] Shows order reference and customer name
- [ ] Shows total amount formatted as currency
- [ ] Status badges display with correct colors
- [ ] Shows "No recent orders" if empty

#### C. Recent Receivings Table
**Location:** Bottom row, right column

**Check:**
- [ ] Table displays recent receivings
- [ ] Shows asset name and reference number
- [ ] Shows quantity
- [ ] Status badges display with correct colors
- [ ] Shows "No recent receivings" if empty

---

### ✅ Step 6: Test Status Summary Widgets

#### A. Order Status Summary
**Location:** Bottom section, left side

**Check:**
- [ ] Lists all order statuses
- [ ] Shows count for each status
- [ ] Shows total value formatted as currency
- [ ] Shows percentage
- [ ] Percentages add up to ~100%

#### B. Receiving Status Summary
**Location:** Bottom section, right side

**Check:**
- [ ] Lists all receiving statuses
- [ ] Shows count for each status
- [ ] Shows total quantity
- [ ] Shows percentage
- [ ] Percentages add up to ~100%

---

### ✅ Step 7: Test Error Handling

#### A. Test with No Data
1. Temporarily empty a table (backup first!)
2. Reload dashboard
3. Check charts show "No data available" message
4. Verify no console errors

#### B. Test API Failure
1. Stop Laravel server
2. Reload dashboard
3. Check error message displays
4. Verify "Retry" button appears
5. Restart server and click "Retry"
6. Verify data loads successfully

#### C. Test Loading States
1. Add network throttling in DevTools
2. Reload dashboard
3. Check loading spinners appear
4. Verify smooth transition to data display

---

### ✅ Step 8: Browser Console Checks

**Open DevTools (F12) → Console Tab**

**Expected Logs:**
```
Dashboard API Response: {success: true, data: {...}}
Stock Distribution: {labels: Array(4), values: Array(4), colors: Array(4)}
Daily Orders: {labels: Array(7), datasets: Array(1)}
Daily Receivings: {labels: Array(7), datasets: Array(1)}
```

**Should NOT See:**
- ❌ `Class 'Inertia' not found`
- ❌ `TypeError: Failed to execute 'observe' on 'MutationObserver'`
- ❌ `Uncaught SyntaxError: Unexpected end of input`
- ❌ `Failed to resolve component`
- ❌ Any red error messages

---

### ✅ Step 9: Test Auto-Refresh

**Check:**
- [ ] Dashboard auto-refreshes every 5 minutes
- [ ] "Updated [time]" timestamp updates in header
- [ ] No page reload, just data refresh
- [ ] No console errors during refresh

**To Test Quickly:**
1. Open browser console
2. Run: `fetchDashboardData()`
3. Verify data refreshes without page reload

---

### ✅ Step 10: Responsive Design Test

**Desktop (1920x1080):**
- [ ] All 6 summary cards in one row
- [ ] Charts display side-by-side
- [ ] Tables display in 3 columns

**Tablet (768px):**
- [ ] Summary cards stack to 2-3 per row
- [ ] Charts stack vertically
- [ ] Tables stack vertically

**Mobile (375px):**
- [ ] Summary cards stack vertically
- [ ] Charts display full width
- [ ] Tables display full width
- [ ] All content readable and accessible

---

## Common Issues and Solutions

### Issue 1: "Class 'Inertia' not found"
**Solution:** Add `use Inertia\Inertia;` to `routes/web.php`

### Issue 2: Charts are empty
**Solutions:**
- Check API response has data
- Verify computed properties format data correctly
- Check browser console for data structure
- Ensure database has sample data

### Issue 3: MutationObserver errors
**Solutions:**
- Verify chart components have data validation
- Check conditional rendering with `v-if`
- Ensure data structure matches Chart.js expectations

### Issue 4: API returns 401/403
**Solutions:**
- Verify you're logged in
- Check session is active
- Verify API middleware configuration

### Issue 5: API returns 500 error
**Solutions:**
- Check `storage/logs/laravel.log`
- Verify database connection
- Check all required models exist
- Verify relationships are defined

---

## Performance Benchmarks

**Expected Load Times:**
- Initial page load: < 2 seconds
- API response: < 500ms
- Chart rendering: < 300ms
- Total time to interactive: < 3 seconds

**To Measure:**
1. Open DevTools → Network tab
2. Check "Disable cache"
3. Reload page
4. Check timing for `/dashboard` and `/api/dashboard/all`

---

## Sign-Off Checklist

- [ ] All 6 summary cards display correctly
- [ ] All 4 charts render without errors
- [ ] All 3 data tables show information
- [ ] Status summaries display correctly
- [ ] No console errors
- [ ] Auto-refresh works
- [ ] Error handling works
- [ ] Loading states work
- [ ] Responsive design works
- [ ] Performance is acceptable

---

**Testing Completed By:** _______________  
**Date:** _______________  
**Status:** ⬜ PASS | ⬜ FAIL  
**Notes:** _______________

---

**Last Updated:** October 12, 2025
