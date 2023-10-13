<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use App\Models\ReceivingStatus;
use App\Models\Receiving;
use Carbon\Carbon;
use App\Model\Asset;
use Inertia\Inertia;

class ReceivingsController extends Controller
{
    public function index(Request $request)
    {
        $receiving_statuses = ReceivingStatus::all();

        return Inertia::render('Receivings/Index',[
            'filters' => $request->all('name','receiving_status_id','asset_name'),
            'receiving_statuses' => $receiving_statuses,
            'receivings' => Receiving::orderBy('created_at','desc')
                        ->with('user','receivingStatus','asset')
                        ->filter($request->only(
                            'receiving_status_id',
                            'asset_name'
                        ))
                        ->paginate(10)
                        ->withQueryString()
                        ->through(fn ($receive) => $receive),
        ]);
    }

    public function create()
    {
        $receiving_statuses = ReceivingStatus::all();

        return Inertia::render('Receivings/Create',[
            'receiving_statuses' => $receiving_statuses
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'asset_id' => 'required',
            'receiving_status_id' => 'required',
            'qty' => 'required'
        ]);

        $receving = Auth::user()->receivings()->create($request->all());
        $receving->asset()->associate($request->asset_id);
        $receving->receivingStatus()->associate($request->receiving_status_id);
        $receving->save();

        // if the tagging is "added"
        if($request->receiving_status_id === 4)
        {
            $asset = Asset::where('id', $request->asset_id)->first();
            $asset->current_value = $receving->qty;
            $asset->save();
        }

        return Redirect::route('inventory')->with('success','Asset successfully created.');
    }
}
