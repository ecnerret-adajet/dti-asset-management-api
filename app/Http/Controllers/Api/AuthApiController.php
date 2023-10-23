<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Laravel\Sanctum\PersonalAccessToken;
use Laravel\Sanctum\Actions\CreateNewToken;
use App\Models\User;
use Inertia\Inertia;

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
     *
     * for api login
     */
    public function apilogin(Request $request)
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

         // Authenticate the user (you can use Laravel's Auth system)
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {

            // Create a new Sanctum token for the authenticated user
            $token = (new CreateNewToken)->handle(Auth::user());

            // Store the token in the session for web authentication
            session(['dti_asset_app' => $token->plainTextToken]);

            // Redirect to a protected web route
            // return redirect('/protected-route');
        }

        return response()->json([
            'user' => $user,
            'api_token' => $token
        ],201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

         // Authenticate the user (you can use Laravel's Auth system)
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {

            // Redirect to a protected web route
            // return redirect('/protected-route');
            return redirect()->intended('/');
        }

        // return response()->json(['message' => 'Login failed'], 401);
        return back()->withErrors(['email' => 'Invalid credentials']);
    }

    /**
     * Logout routes
     */
    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();

        // Clear the session
        session()->forget('dti_asset_app');

        return response()->json([
            'message' => 'Logged out'
        ],201);
    }

    /**
     * Verify token
     */
    public function verifyToken(Request $request)
    {
        $token = PersonalAccessToken::findToken($request->api_token);

        if(!$token) {
            return response()->json([
                'message' => 'Unauthenticated'
            ],401);
        }

        return response()->json([
            'name' => $token->tokenable->name,
            'surname' => $token->tokenable->name,
            'email' => $token->tokenable->email,
            'api_token' => $request->api_token
        ],200);

    }
}
