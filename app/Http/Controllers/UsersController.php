<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Inertia\Inertia;

class UsersController extends Controller
{
    public function index(Request $request)
    {
        return Inertia::render('Users/Index',[
            'roles' => Role::all(),
            'filters' => $request->all('name','role_name'),
            'users'=> User::orderBy('created_at','desc')
                    ->with('roles')
                    ->filter($request->only('name'))
                    ->paginate(10)
                    ->withQueryString()
                    ->through(fn ($user) => $user),
        ]);
    }

    public function create()
    {
        $roles = Role::all();

        return Inertia::render('Users/Create',[
            'roles' => $roles
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed'
        ]);

        $user = User::create([
            'name' => $request->first_name.' '.$request->last_name,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'image_path' => $request->file('image_path') ? $request->file('image_path')->store('images') : 'default.png',
            'contact_number' => $request->contact_number,
            'password' => bcrypt($request->password)
        ]);

        $user->roles()->attach($request->role_id);

        return Redirect::route('users')->with('success','User successfully created.');
    }

    public function edit($user)
    {
        $roles = Role::all();

        $find_user = User::where('id',$user)->with('roles')->first();

        return Inertia::render('Users/Edit',[
            'roles' => $roles,
            'user' => $find_user
        ]);
    }

    public function update(Request $request, $user)
    {
        $this->validate($request,[
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|string|unique:users,email,'.$user,
        ]);

        $find_user = User::where('id',$user)->with('roles')->first();

        $find_user->update([
            'name' => $request->first_name.' '.$request->last_name,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'image_path' => $request->file('image_path') ? $request->file('image_path')->store('images') : 'default.png',
            'contact_number' => $request->contact_number,
        ]);

        $find_user->roles()->sync($request->role_id);

        return Redirect::route('users')->with('success','User successfully updated.');
    }

    public function delete(User $user)
    {
        $user->destroy();
        return $user;
    }

    public function changePassword(Request $request, User $user)
    {
        $this->validate($request,[
            'password' => 'required|min:8|confirmed',
        ]);

        // Change Password Logic
        $user->password = bcrypt($request->password);
        $user->save();

        return Redirect::route('users')->with('success','User successfully updated.');
    }
}
