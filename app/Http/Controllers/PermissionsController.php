<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Permission;
use Inertia\Inertia;

class PermissionsController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render('Permissions/Index',[
            'filters' => $request->all('name'),
            'permissions' => Permission::orderBy('id','asc')
                        ->with('roles')
                        ->filter($request->only(
                            'name',
                        ))
                        ->paginate(10)
                        ->withQueryString()
                        ->through(fn ($permission) => $permission),
            ]);
    }

    public function create()
    {
        return Inertia::render('Permissions/Create');
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required'
        ]);

        Permission::create($request->all());

        return Redirect::route('permissions')->with('success','Permission created successfully');
    }

    public function update(Request $request, Permission $permission)
    {
        $this->validate($request,[
            'name' => 'required'
        ]);

        Permission::update($request->all());

        return Redirect::route('permissions')->with('success','Permission updated successfully');
    }
}
