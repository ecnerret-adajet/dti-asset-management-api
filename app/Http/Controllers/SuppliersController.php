<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use App\Models\Supplier;
use App\Models\Asset;
use Inertia\Inertia;

class SuppliersController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render('Suppliers/Index',[
            'filters' => $request->all('name'),
            'suppliers' => Supplier::orderBy('created_at','desc')
                        ->withCount('assets')
                        ->filter($request->only('name'))
                        ->paginate(10)
                        ->withQueryString()
                        ->through(fn ($supplier) => $supplier),
        ]);
    }

    public function create()
    {
        return Inertia::render('Suppliers/Create');
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required',
            'email' => 'required',
            'phone_number' => 'required',
        ]);

        Supplier::create($request->all());

        return Redirect::route('suppliers')->with('success','Successfully created.');
    }

    public function show(Request $request, Supplier $supplier)
    {
        return Inertia::render('Suppliers/Show',[
            'filters' => $request->all('name','model','driver','serial_number','location','status','asset_type'),
            'supplier' => $supplier,
            'assets' => Asset::orderBy('created_at','desc')
                        ->where('supplier_id',$supplier->id)
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

    public function update(Request $request, Supplier $supplier)
    {
        $this->validate($request,[
            'name' => 'required',
            'email' => 'required',
            'phone_number' => 'required',
        ]);

        $supplier->update($request->all());

        return Redirect::route('suppliers')->with('success','Successfully updated.');
    }

    public function delete(Supplier $supplier)
    {
        $supplier->destroy();

        return Redirect::route('suppliers')->with('success','Successfully deleted.');
    }
}
