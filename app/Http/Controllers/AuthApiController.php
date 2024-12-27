<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\UserResource;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;

class AuthApiController extends Controller
{
    // Handle User Registration
    public function register(Request $request)
    {
        // Validate the input
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => 'User Already Created.',
            ], 201);
        }

        // Create the user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Return a response with the new user's data and an API token
        return response()->json([
            'message' => 'User created successfully.',
            'user' => new UserResource($user),
            'token' => $user->createToken('YourAppName')->plainTextToken,
        ], 201);
    }

    // Handle User Login
    public function login(Request $request)
    {
        // Validate the input
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Check if the user exists and the password is correct
        if (Auth::attempt(['email' => $validated['email'], 'password' => $validated['password']])) {
            $user = Auth::user();

            // Create a new API token for the authenticated user
            $token = $user->createToken('YourAppName')->plainTextToken;

            return response()->json([
                'message' => 'Login successful.',
                'user' => new UserResource($user),
                'token' => $token,
            ]);
        }else {
            return response()->json([
                'message' => 'The provided credentials are incorrect.',
            ]);
        }

    }

    // Handle User Logout
    public function logout(Request $request)
    {
        // Revoke the user's current API token
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Successfully logged out.',
        ]);
    }
    // Get the authenticated user's dashboard data
    public function dashboard(Request $request)
    {
            return response()->json([
                'message' => 'Welcome to your dashboard.',
                'user' => new UserResource($request->user()), // Return user data
            ]);
        
    }
}
// {
//     "name": "John Doe",
//     "email": "johndoe@example.com",
//     "password": "password123",
//     "password_confirmation": "password123"
// }