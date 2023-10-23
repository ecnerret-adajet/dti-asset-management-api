<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Permission;
use App\Models\Role;
use Inertia\Inertia;

class RolesController extends Controller
{
    public function index(Request $request)
    {
        $permissions = Permission::all();

        return Inertia::render('Roles/Index',[
            'filters' => $request->all('name','permission_name'),
            'permissions' =>$permissions,
            'roles' => Role::orderBy('id','asc')
                        ->with('permissions')
                        ->filter($request->only(
                            'name',
                            'permission_name'
                        ))
                        ->paginate(10)
                        ->withQueryString()
                        ->through(fn ($role) => $role),
        ]);
    }

    public function create()
    {
        $permissions = Permission::all();

        return Inertia::render('Roles/Create',[
            'permissions' => $permissions
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required',
            'permissions' => 'required'
        ]);

        $role = Role::create([
            'name' => $request->name,
            'slug' => Str::lower($request->name),
            'level' => $request->level,
            'description' => $request->description
        ]);

        $role->permissions()->attach($request->permissions);

        return Redirect::route('roles')->with('success','Role successfully create');
    }

    public function edit($role)
    {
        $permissions = Permission::all();

        $find_role = Role::where('id',$role)->with('permissions')->first();

        return Inertia::render('Roles/Edit',[
            'role' => $find_role,
            'permissions' => $permissions
        ]);
    }

    public function update(Request $request, $role)
    {
        $this->validate($request,[
            'name' => 'required',
            'permissions' => 'required'
        ]);

        $find_role = Role::where('id',$role)->with('permissions')->first();

        $find_role->update([
            'name' => $request->name,
            'slug' => strtolower($find_role->name),
            'level' => $request->level,
            'description' => $request->description
        ]);

        $find_role->permissions()->sync($request->permissions);

        return Redirect::route('roles')->with('success','Role successfully updated');

    }
}
