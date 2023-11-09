<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderStatus;
use Carbon\Carbon;

class OrdersApiController extends Controller
{

    public function orderStatus(Request $request)
    {
        $start_date = $request->start_date;
        $end_date = $request->end_date ? $request->end_date : Carbon::today();

        return OrderStatus::when($start_date, function ($q) use ($start_date, $end_date) {
                        $q->whereHas('orders', function ($x) use ($start_date, $end_date) {
                            $x->whereBetween('created_at', [Carbon::parse($start_date), Carbon::parse($end_date)]);
                        });
                    })
                    ->withCount('orders')
                    ->get();
    }

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
