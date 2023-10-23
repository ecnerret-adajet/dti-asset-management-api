<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\Models\Location;
use Inertia\Inertia;

class LocationsController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render('Locations/Index',[
            'filters' => $request->all('name'),
            'locations' => Location::orderBy('created_at','desc')
                    ->filter($request->only('name'))
                    ->paginate(10)
                    ->withQueryString()
                    ->through(fn ($location) => $location),
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required'
        ]);

        Location::create($request->all());

        return Redirect::route('locations')->with('success','Successfully created.');
    }

    public function update(Request $request, Location $location)
    {
        $this->validate($request,[
            'name' => 'required'
        ]);

        $location->update($request->all());

        return Redirect::route('locations')->with('success','Successfully updated.');
    }

    public function delete(Location $location)
    {
        $location->destroy();

        return Redirect::route('locations')->with('success','Successfully deleted.');
    }
}
