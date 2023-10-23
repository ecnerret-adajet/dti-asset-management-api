<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Asset;
use App\Models\Location;
use App\Models\AssetType;
use App\Models\Status;
use Inertia\Inertia;

class PagesController extends Controller
{
    public function home()
    {
        return Inertia::render('Home');
    }

    public function inventory(Request $request)
    {
        $locations = Location::activeLocations()->get();
        $asset_types = AssetType::all();
        $statuses = Status::all();

        return Inertia::render('Inventory',[
            'filters' => $request->all('name','model','driver','serial_number','location','status','asset_type'),
            'locations' => $locations,
            'asset_types' => $asset_types,
            'statuses' => $statuses,
            'assets' => Asset::orderBy('created_at','desc')
                        ->with('location','assetType','status')
                        ->filter($request->only(
                                'name',
                                'model',
                                'serial_number',
                                'location',
                                'status',
                                'asset_type'))
                        ->paginate(10)
                        ->withQueryString()
                        ->through(fn ($asset) => $asset),
        ]);
    }

    public function masterData()
    {
        return Inertia::render('MasterData');
    }

    public function accounts()
    {
        return Inertia::render('Accounts');
    }
}
