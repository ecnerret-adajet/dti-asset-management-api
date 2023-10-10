<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Asset;

class AssetsApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Asset::orderBy('id','desc')
                    ->with('assetType','status','location')
                    ->paginate(10);
    }

    /**
     * Asset APi for dropdown selection
     */
    public function list()
    {
        $assets = Asset::orderBy('id','desc')
                    ->select('id','name','image_path','description','unit_price','current_value')
                    ->get();

        return $assets->map(function ($item) {
            return [
                'id' => $item->id,
                'title' => $item->name,
                'desc' => $item->description,
                'img' => $item->image_path,
                'unit_price' => $item->unit_price,
                'unit_price_total' => 0,
                'current_value' => $item->current_value,
                'qty' => 1,
            ];
        });
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required',
            'model' => 'required',
            'serial_number' => 'required',
        ]);

        $asset = Auth::user()->assets()->create($request->all());
        $asset->location()->associate($request->location_id);
        $asset->assetType()->associate($request->asset_type_id);
        $asset->status()->associate($request->status_id);
        $asset->save();

        return $asset;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Asset::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'name' => 'required',
            'model' => 'required',
            'serial_number' => 'required',
        ]);

        $asset = Asset::find($id);
        $asset->update($request->all());

        return $asset;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Asset::destroy($id);
    }

    /**
     * Recently created
     */
    public function recentCreated()
    {
        return Asset::orderBy('id','desc')->take(2)->get();
    }
}
