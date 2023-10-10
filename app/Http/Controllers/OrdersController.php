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
    public function index()
    {
        return Inertia::render('Orders/Index');
    }

    public function create()
    {
        $order_status = OrderStatus::all();

        return Inertia::render('Orders/Create',[
            'order_statuses' => $order_status,
        ]);
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
        $order->customer_id = $selected_customer['id'];
        $order->order_status_id = 1; // default as pending;
        $order->total_cost = $request->grand_total;
        $order->total_orders = 0; // temporarily
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
}
