<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Asset;
use App\Models\Order;
use App\Models\Receiving;
use Carbon\Carbon;

class ReportsApiController extends Controller
{
    public function totalAssets()
    {
        return Asset::count();
    }

    public function totalSpending()
    {
        return Asset::sum('unit_price');
    }

    public function totalQuantitySold()
    {
        return Order::whereMonth('created_at', '=', now()->month)->count();
    }

    public function totalQuantityRequest()
    {
        return Receiving::whereMonth('created_at', '=', now()->month)->count();
    }
}
