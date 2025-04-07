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
        // Get sort column and direction
        $sort = $request->input('sort', 'created_at');
        $direction = $request->input('direction', 'desc');
        
        // Define allowed sort columns
        $allowedSorts = [
            'name', 'model', 'current_value', 'part_number', 'created_at',
            'location', 'status', 'asset_type'
        ];
        
        // Validate sort column
        if (!in_array($sort, $allowedSorts)) {
            $sort = 'created_at';
        }
        
        
        // Get locations, asset types and statuses
        $locations = Location::activeLocations()->get();
        $asset_types = AssetType::all();
        $statuses = Status::all();
        
        return Inertia::render('Inventory',[
            'filters' => $request->all('name','model','driver','serial_number','location','status','asset_type','sort','direction'),
            'locations' => $locations,
            'asset_types' => $asset_types,
            'statuses' => $statuses,
            'assets' => Asset::orderBy($sort, $direction)
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
