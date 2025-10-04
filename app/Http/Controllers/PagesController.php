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
            'location', 'status', 'asset_type', 'serial_number'
        ];
        
        // Validate sort column
        if (!in_array($sort, $allowedSorts)) {
            $sort = 'created_at';
        }
        
        // Get locations, asset types and statuses
        $locations = Location::activeLocations()->get();
        $asset_types = AssetType::all();
        $statuses = Status::all();
        
        // Start building the query
        $query = Asset::with('location', 'assetType', 'status');
        
        // Handle special sorting cases for relationships
        if ($sort === 'location') {
            // Join with locations table to sort by location name
            $query->join('locations', 'assets.location_id', '=', 'locations.id')
                  ->orderBy('locations.name', $direction)
                  ->select('assets.*'); // Make sure we only select from assets table
        } 
        elseif ($sort === 'status') {
            // Join with statuses table to sort by status name
            $query->join('statuses', 'assets.status_id', '=', 'statuses.id')
                  ->orderBy('statuses.name', $direction)
                  ->select('assets.*');
        }
        elseif ($sort === 'asset_type') {
            // Join with asset_types table to sort by asset type name
            $query->join('asset_types', 'assets.asset_type_id', '=', 'asset_types.id')
                  ->orderBy('asset_types.name', $direction)
                  ->select('assets.*');
        }
        else {
            // For regular columns, sort directly
            $query->orderBy($sort, $direction);
        }
        
        return Inertia::render('Inventory',[
            'filters' => $request->all('name','model','driver','serial_number','location','status','asset_type','sort','direction'),
            'locations' => $locations,
            'asset_types' => $asset_types,
            'statuses' => $statuses,
            'assets' => $query->filter($request->only(
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
