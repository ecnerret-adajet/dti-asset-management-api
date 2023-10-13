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

    public function updateOrderStatus(Request $request, $id)
    {
        $this->validate($request,[
            'order_status_id' => 'required'
        ]);

        $order = Order::where('id',$id)->first();
        $order->order_status_id = $request->order_status_id;
        $order->save();

        return Redirect::route('orders')->with('success','Status updated successfully');
    }
}
