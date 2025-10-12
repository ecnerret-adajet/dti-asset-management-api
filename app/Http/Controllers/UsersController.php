<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Inertia\Inertia;
use Illuminate\Validation\Rules\Password;

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
    
    /**
     * Show the user profile page
     */
    public function profile()
    {
        $user = Auth::user();
        
        return Inertia::render('Profile/Edit', [
            'user' => $user
        ]);
    }
    
    /**
     * Update the authenticated user's profile
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        $this->validate($request, [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
            'contact_number' => 'nullable|string|max:20',
            'image_path' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);
        
        $user->update([
            'name' => $request->first_name.' '.$request->last_name,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'contact_number' => $request->contact_number,
        ]);
        
        if ($request->hasFile('image_path')) {
            $user->update([
                'image_path' => $request->file('image_path')->store('images'),
            ]);
        }
        
        return back()->with('success', 'Profile updated successfully.');
    }
    
    /**
     * Update the authenticated user's password
     */
    public function updatePassword(Request $request)
    {
        $user = Auth::user();
        
        $this->validate($request, [
            'current_password' => ['required', function ($attribute, $value, $fail) use ($user) {
                if (!Hash::check($value, $user->password)) {
                    $fail('The current password is incorrect.');
                }
            }],
            'password' => ['required', 'confirmed', Password::min(8)
                ->letters()
                ->mixedCase()
                ->numbers()
                ->symbols()],
        ]);
        
        $user->update([
            'password' => Hash::make($request->password),
        ]);
        
        return back()->with('success', 'Password updated successfully.');
    }
}
