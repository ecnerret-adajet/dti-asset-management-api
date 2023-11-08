<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class OrdersApiController extends Controller
{
    public function customerOders(Request $request, $customer_id)
    {
        return Order::orderBy('created_at','desc')
        ->where('customer_id',$customer_id)
        ->with('user','customer','orderStatus','assets')
        ->filter($request->only(
            'order_status_id',
            'asset_name',
        ))
        ->paginate(5)
        ->withQueryString()
        ->through(fn ($order) => $order);
    }

    public function customerTotalCost($customer_id)
    {
        return Order::where('customer_id',$customer_id)->sum('total_cost');
    }
}
