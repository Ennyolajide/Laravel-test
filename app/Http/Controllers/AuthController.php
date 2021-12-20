<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ]);

        return response()->json([
            'token_type' => 'Bearer',
            'access_token' => $user->createToken('auth_token')->plainTextToken
        ]);
    }

    /**
     * This Generate Fake User using Factory and faker
     * This function is for testing purpose only
     * @return \Illuminate\Http\JsonResponse
     */
    public function registerFakeUser()
    {
        return response()->json([
            'token_type' => 'Bearer',
            'access_token' => User::factory()->create()->createToken('auth_token')->plainTextToken
        ]);
    }

    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Invalid login details'
            ], 401);
        }

        $user = User::where('email', $request['email'])->firstOrFail();

        return response()->json([
            'token_type' => 'Bearer',
            'access_token' => $user->createToken('auth_token')->plainTextToken
        ]);
    }

    public function user(Request $request)
    {
        return $request->user();
    }

}
