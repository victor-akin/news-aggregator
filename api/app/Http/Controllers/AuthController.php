<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use \Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;

class AuthController extends Controller
{
    public function login(Request $request): JsonResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {

            $request->session()->regenerate();

            return Response::json(['message' => 'Login successful']);
        }

        return Response::json(['message' => 'Wrong login credentials'], 403);
    }

    public function register(Request $request): JsonResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
            'username' => ['required'],
        ]);

        if(User::where('email', $request->email)->exists()) {

            return Response::json(['message' => 'Email already exists'], 400);
        }

        $user = User::create([
            'email' => $request->email,
            'name' => $request->username,
            'email_verified_at' => now(),
            'password' => Hash::make($request->password),
        ]);

        if($user) return Response::json(['message' => 'Registration successful. You can now login']);
    }

    public function logout(Request $request): JsonResponse
    {
        Auth::logout();

        return Response::json(['message' => 'Successfully logged out']);
    }
}
