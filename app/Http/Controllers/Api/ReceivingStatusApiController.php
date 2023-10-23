<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ReceivingStatus;
use Illuminate\Http\Request;


class ReceivingStatusApiController extends Controller
{
    public function index()
    {
        return ReceivingStatus::where('is_active',1)->get();
    }
}
