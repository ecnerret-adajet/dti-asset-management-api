<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\User;

class AuthApiController extends Controller
{
    /**
     * register a user
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        $token = $user->createToken('dti_asset_app')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token
        ],201);
    }

    /**
     * login routes
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // check email
        $user = User::where('email',$request->email)->first();

        // chekc password
        if(!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'The provided credentials are incorrect.'
            ],401);
        }

        $token = $user->createToken('dti_asset_app')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token
        ],201);
    }

    /**
     * Logout routes
     */
    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();

        return response()->json([
            'message' => 'Logged out'
        ],201);
    }
}
