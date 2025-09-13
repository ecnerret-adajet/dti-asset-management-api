<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use App\Models\Supplier;
use App\Models\Location;
use App\Models\AssetType;
use App\Models\Status;
use App\Models\Asset;
use Carbon\Carbon;
use Inertia\Inertia;
use App\Models\Currency;

class AssetsController extends Controller
{

    public function index()
    {
        return Inertia::render('Assets/Index');
    }

    public function create()
    {
        $locations = Location::activeLocations()->get();
        $asset_types = AssetType::all();
        $status = Status::all();
        $suppliers = Supplier::all();
        $currencies = Currency::all();

        return Inertia::render('Assets/Create',[
            'suppliers' => $suppliers,
            'locations' => $locations,
            'asset_types' => $asset_types,
            'statuses' => $status,
            'currencies' => $currencies
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required'
        ]);

        $asset = Auth::user()->assets()->create($request->all());

        if($request->file('image_path')) {
            $asset->image_path = $request->file('image_path')->store('images');
        }
        $asset->location()->associate($request->location_id);
        $asset->status()->associate($request->status_id);
        $asset->assetType()->associate($request->asset_type_id);
        $asset->supplier()->associate($request->supplier_id);

        $asset->save();

        return Redirect::route('inventory')->with('success','Asset successfully created.');
    }

    public function show($asset_id)
    {
        $asset = Asset::where('id', $asset_id)
                    ->with('location','assetType','status','supplier','audits')
                    ->first();

        $locations = Location::activeLocations()->get();
        $asset_types = AssetType::all();
        $status = Status::all();
        $audits = $asset->audits()->get();
        $currencies = Currency::all();

        return Inertia::render('Assets/Show',[
            'asset' => $asset,
            'audits' => $audits,
            'locations' => $locations,
            'asset_types' => $asset_types,
            'status' => $status,
            'currencies' => $currencies,
        ]);
    }

    public function edit($asset_id)
    {
        $asset = Asset::where('id', $asset_id)
                    ->with('location','assetType','status','supplier','audits')
                    ->first();

        $locations = Location::activeLocations()->get();
        $asset_types = AssetType::select('id', 'name')->get();
        $status = Status::select('id', 'name')->get();
        $audits = $asset->audits()->get();
        $suppliers = Supplier::select('id', 'name')->get();
        $currencies = Currency::all();

        return Inertia::render('Assets/Edit',[
            'asset' => $asset,
            'audits' => $audits,
            'locations' => $locations,
            'asset_types' => $asset_types,
            'status' => $status,
            'suppliers' => $suppliers,
            'currencies' => $currencies
        ]);
    }

    public function update(Request $request, Asset $asset)
    {
        $this->validate($request,[
            'name' => 'required'
        ]);

        $asset->update($request->all());

        if($request->file('image_path')) {
            $asset->image_path = $request->file('image_path')->store('images');
        }

        if($request->status_id) {
            $asset->status()->associate($request->status_id);
        }

        if($request->location_id) {
            $asset->location()->associate($request->location_id);
        }

        if($request->asset_type_id) {
            $asset->assetType()->associate($request->asset_type_id);
        }

        if($request->supplier_id) {
            $asset->supplier()->associate($request->supplier_id);
        }

        $asset->save();

        return Redirect::route('inventory')->with('success','Asset successfully created.');
    }

    public function changeLocation(Request $request, Asset $asset)
    {
        $this->validate($request,[
            'location_id' => 'required'
        ]);

        if($request->location_id) {
            $asset->location()->associate($request->location_id);
        }

        $asset->save();

        return Redirect::route('inventory')->with('success','Asset successfully created.');
    }

    public function destroy(Asset $asset)
    {
        try {
            // Check for related receivings that might be active
            // Using receiving_status_id instead of status
            // Assuming pending and in_progress status IDs are 1 and 2 respectively
            $activeReceivings = $asset->receivings()->whereIn('receiving_status_id', [1, 2])->count();
            
            if ($activeReceivings > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot delete this asset. It has active receivings associated with it.'
                ], 422);
            }
            
            // Check for related orders that might be active
            // Using order_status_id instead of status
            // Assuming pending and in_progress status IDs are 1 and 2 respectively
            $activeOrders = $asset->orders()->whereHas('orderStatus', function($query) {
                $query->whereIn('id', [1, 2]); // IDs for pending and in_progress statuses
            })->count();
            
            if ($activeOrders > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot delete this asset. It has active orders associated with it.'
                ], 422);
            }
            
            // Soft delete the asset (using SoftDeletes trait)
            $asset->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Asset successfully deleted.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while deleting the asset: ' . $e->getMessage()
            ], 500);
        }
    }
}
