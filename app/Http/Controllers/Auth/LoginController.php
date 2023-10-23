<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LoginController extends Controller
{
    //
    public function login()
    {
        return Inertia::render('Auth/Login');
    }

    public function auth(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->intended('/'); // Redirect to the dashboard or any desired route
        }

        // Authentication failed, handle it here
        return back()->withErrors(['email' => 'Invalid credentials']);
    }
}
