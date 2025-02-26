<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
{
    try {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|confirmed|min:8'
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password'])
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer'
        ], 201);
    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Registration failed',
            'error' => $e->getMessage()
        ], 500);
    }
}

public function login(Request $request)
{
    // Validate incoming request
    $request->validate([
        'email' => 'required|email',
        'password' => 'required'
    ]);



    // Check if user exists
    $user = User::where('email', $request->email)->first();




    if (!$user || !Hash::check($request->password, $user->password)) {
        dd($user->password, Hash::check($request->password, $user->password));
        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    // Create a new token for the user
    $token = $user->createToken('auth_token')->plainTextToken;

    // Return token and user data
    return response()->json([
        'message' => 'Login successful',
        'token' => $token,
        'user' => $user
    ], 200);
}


    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out']);
    }
}
