<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|min:8',
        ]);
        $user = User::create($request->only(['name', 'email', 'password']));
        $token = $user->createToken('auth_token')->plainTextToken;
        return  response()->json([
            'user' => $user,
            'token' => $token,
        ],200);
    }

    public function login(Request $request)
    {
        // Validate the request data
        $request->validate([
            'email' => 'required|string|email|max:255|exists:users',
            'password' => 'required|min:8',
        ]);
        $user = User::where('email', $request->email)->first();

        // Check if the password is correct
        if (!password_verify($request->password, $user->password)) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        if ($user->tokens()->exists()) {
            return response()->json([
                'error' => 'User is already logged in on another device',
            ], 403);
        }

        return  response()->json([
            'user' => $user,
            'token' => $token,
        ],200);
    }

    public function logout()
    {
        Auth::user()->tokens()->delete();
        return response()->json([
            'message' => 'logout success'
        ], 200);
    }

    public function userUpdate(Request $request)
    {
        $user = Auth::user();
        $user->update($request->only(['name', 'email']));
        return response()->json([
            'message' => 'User updated successfully',
            'data' => $user
        ],200);
    }
}
