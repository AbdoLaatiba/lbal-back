<?php

namespace App\Http\Controllers;

use App\Http\Requests\auth\LoginRequest;
use App\Http\Requests\auth\RegisterRequest;
use App\Models\User;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (!auth()->attempt($credentials)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $user = User::where('email', $request->email)->first();

        return $this->respondWithToken($user);
    }

    public function register(RegisterRequest $request)
    {
        $user = User::create($request->validated());

        return $this->respondWithToken($user);
    }

    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function registerAdmin(RegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'admin',
            'status' => 'active',
        ]);

        return $this->respondWithToken($user);
    }

    protected function respondWithToken($user)
    {
        $token = $user->createToken('authToken')->plainTextToken;
        return response()->json([
            'token' => $token,
            'user' => $user,
        ]);
    }
}
