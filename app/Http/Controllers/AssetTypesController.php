<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AssetType;
use Inertia\Inertia;

class AssetTypesController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render('AssetType/Index',[
            'asset_types' => AssetType::orderBy('created_at','desc')
                    ->filter($request->only('name'))
                    ->paginate(10)
                    ->withQueryString()
                    ->through(fn ($asset_type) => $asset_type),
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required'
        ]);

        AssetType::create($request->all());

        return Redirect::route('asset-types')->with('success','Successfully created.');
    }

    public function update(Request $request, AssetType $assetType)
    {
        $this->validate($request,[
            'name' => 'required'
        ]);

        $assetType->update($request->all());

        return Redirect::route('asset-types')->with('success','Successfully updated.');
    }

    public function delete(AssetType $assetType)
    {
        $assetType->destroy();

        return Redirect::route('asset-types')->with('success','Successfully deleted.');
    }
}
