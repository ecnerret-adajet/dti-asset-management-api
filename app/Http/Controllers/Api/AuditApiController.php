<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Asset;
use App\Models\Order;
use App\Models\Receiving;
use App\Models\Customer;
use App\Models\Supplier;

class AuditApiController extends Controller
{
    public function assets()
    {
        return Asset::with('audits')->paginate(10);
    }
}
