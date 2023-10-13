<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use App\Models\Receiving;
use App\Models\ReceivingStatus;
use Carbon\Carbon;
use App\Model\Asset;

class ReceivingsApiController extends Controller
{
    public function index()
    {
        return Receiving::all();
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'asset_id' => 'required',
            'receiving_status_id' => 'required',
            'qty' => 'required'
        ]);

        $receving = new Receiving;
        $receving->qty = $request->qty;
        $receving->user_id = Auth::user()->id;
        $receving->remarks = $request->remarks;
        $receving->asset()->associate($request->asset_id);
        $receving->receivingStatus()->associate($request->receiving_status_id);
        $receving->save();

        return Redirect::route('inventory')->with('success','Asset successfully created.');
    }
}
