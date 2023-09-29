<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Status;
use Inertia\Inertia;

class StatusesController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render('Status/Index',[
            'statuses' => Status::orderBy('created_at','desc')
                    ->filter($request->only('name'))
                    ->paginate(10)
                    ->withQueryString()
                    ->through(fn ($status) => $status),
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required'
        ]);

        Status::create($request->all());

        return Redirect::route('statuses')->with('success','Successfully created.');
    }

    public function update(Request $request, Status $status)
    {
        $this->validate($request,[
            'name' => 'required'
        ]);

        $status->update($request->all());

        return Redirect::route('statuses')->with('success','Successfully updated.');
    }

    public function delete(Status $status)
    {
        $status->destroy();

        return Redirect::route('statuses')->with('success','Successfully deleted.');
    }
}
