<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\OrderStatus;
use Carbon\Carbon;
use App\Models\Asset;
use Inertia\Inertia;

class OrdersController extends Controller
{
    public function index(Request $request)
    {
        $order_statuses = OrderStatus::all();

        return Inertia::render('Orders/Index',[
            'order_statuses' => $order_statuses,
            'filters' => $request->all('name','order_status_id','asset_name'),
            'orders' => Order::orderBy('created_at','desc')
                        ->with('user','customer','orderStatus','assets')
                        ->filter($request->only(
                            'order_status_id',
                            'asset_name',
                        ))
                        ->paginate(5)
                        ->withQueryString()
                        ->through(fn ($order) => $order),
        ]);
    }

    public function create()
    {
        $order_status = OrderStatus::all();

        return Inertia::render('Orders/Create',[
            'order_statuses' => $order_status,
        ]);
    }

    private function generateOrderReference()
    {
        $default = str_pad(1, 8, "0", STR_PAD_LEFT);
        $latestOrderReference = Order::withTrashed()->orderBy('created_at','DESC')->first();
        return  $latestOrderReference ? str_pad($latestOrderReference->id + 1, 8, "0", STR_PAD_LEFT) : $default;
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'selected_customer' => 'required',
            'selected_orders' => 'required',
        ]);

        $selected_customer = $request->selected_customer;
        $selected_orders = $request->selected_orders;

        $order = new Order;
        $order->user_id = Auth::user()->id;
        $order->order_reference = $this->generateOrderReference();
        $order->customer_id = $selected_customer['id'];
        $order->order_status_id = 1; // default as pending;
        $order->total_cost = $request->grand_total;
        $order->total_orders = $request->total_qty_orders; // temporarily
        $order->reference = $request->reference;
        $order->save();

        if(count($selected_orders) > 0) {
            foreach($selected_orders as $item) {

                $asset = Asset::where('id', $item['id'])->first();
                $asset->current_value = $asset->current_value - $item['qty'];
                $asset->save();

                $order->assets()->attach($item['id'],[
                   'qty' =>  $item['qty'],
                   'unit_price' => $item['unit_price'],
                   'total_amount' => $item['unit_price_total']
                ]);
            }
        }

        return Redirect::route('inventory')->with('success','Asset successfully created.');
        // return Redirect::back()->with('success','Order successfully created.');
    }

    public function edit($id)
    {
        $order = Order::where('id', $id)
            ->with('user', 'customer', 'orderStatus', 'assets')
            ->firstOrFail();

        $order_statuses = OrderStatus::all();

        return Inertia::render('Orders/Edit', [
            'order' => $order,
            'order_statuses' => $order_statuses,
        ]);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'selected_customer' => 'required',
            'selected_orders' => 'required',
        ]);

        $selected_customer = $request->selected_customer;
        $selected_orders = $request->selected_orders;

        $order = Order::where('id', $id)->firstOrFail();

        // First, restore the stock for previously ordered items
        foreach($order->assets as $previousAsset) {
            $asset = Asset::where('id', $previousAsset->id)->first();
            $asset->current_value = $asset->current_value + $previousAsset->pivot->qty;
            $asset->save();
        }

        // Detach all previous assets
        $order->assets()->detach();

        // Update order details
        $order->customer_id = $selected_customer['id'];
        $order->total_cost = $request->grand_total;
        $order->total_orders = $request->total_qty_orders;
        $order->reference = $request->reference;
        $order->save();

        // Attach new/updated assets and reduce stock
        if(count($selected_orders) > 0) {
            foreach($selected_orders as $item) {
                $asset = Asset::where('id', $item['id'])->first();
                $asset->current_value = $asset->current_value - $item['qty'];
                $asset->save();

                $order->assets()->attach($item['id'],[
                   'qty' =>  $item['qty'],
                   'unit_price' => $item['unit_price'],
                   'total_amount' => $item['unit_price_total']
                ]);
            }
        }

        return Redirect::route('orders')->with('success','Order successfully updated.');
    }

    public function uploadReferenceDocument(Request $request)
    {
        $request->validate([
            'upload_reference' => 'required|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:10240',
            'order_id' => 'required|exists:orders,id'
        ]);

        $order = Order::findOrFail($request->order_id);

        if ($request->hasFile('upload_reference')) {
            // Delete old file if exists
            if ($order->upload_reference && \Storage::exists($order->upload_reference)) {
                \Storage::delete($order->upload_reference);
            }
            
            // Store the new file
            $path = $request->file('upload_reference')->store('reference_documents', 'public');
            $order->upload_reference = $path;
            $order->save();

            return response()->json([
                'message' => 'Reference document uploaded successfully',
                'path' => $path
            ]);
        }

        return response()->json(['message' => 'No file was uploaded'], 400);
    }

    public function updateOrderStatus(Request $request, $id)
    {
        $this->validate($request,[
            'order_status_id' => 'required'
        ]);

        $order = Order::where('id',$id)->first();
        $order->order_status_id = $request->order_status_id;
        $order->save();

        // if failed
        if($request->order_status_id === 4)
        {
            foreach($order->assets as $orderAsset) {
                $asset = Asset::where('id', $orderAsset->id)->first();
                $asset->current_value = $asset->current_value + $orderAsset->pivot->qty;
                $asset->save();
            }
        }

        return Redirect::route('orders')->with('success','Status updated successfully');
    }
}
