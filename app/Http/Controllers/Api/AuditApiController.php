<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Asset;
use App\Models\Order;
use App\Models\Receiving;
use App\Models\Customer;
use App\Models\Supplier;
use OwenIt\Auditing\Facades\Auditor;
use OwenIt\Auditing\Contracts\Audit;

class AuditApiController extends Controller
{
    public function assets()
    {
        return \OwenIt\Auditing\Models\Audit::with('user')
        ->take(15)
        ->orderBy('created_at', 'desc')->get();
    }
}
