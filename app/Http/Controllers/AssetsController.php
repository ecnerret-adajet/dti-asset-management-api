<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use App\Models\Location;
use App\Models\AssetType;
use App\Models\Status;
use App\Models\Asset;
use Carbon\Carbon;
use Inertia\Inertia;

class AssetsController extends Controller
{

    public function index()
    {
        return Inertia::render('Assets/Index');
    }

    public function create()
    {
        $locations = Location::all();
        $asset_types = AssetType::all();
        $status = Status::all();

        return Inertia::render('Assets/Create',[
            'locations' => $locations,
            'asset_types' => $asset_types,
            'statuses' => $status
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

        $asset->save();

        return Redirect::route('inventory')->with('success','Asset successfully created.');
    }
}
