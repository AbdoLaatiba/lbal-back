<?php

namespace App\Http\Controllers;

use App\Http\Requests\auth\LoginRequest;
use App\Http\Requests\auth\RegisterRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (!auth()->attempt($credentials)) {
            return response()->json(['message' => 'The provided credentials are incorrect.'], 401);
        }

        $user = User::where('email', $request->email)->first();

        if ($user->status == 'pending') {
            return response()->json(['message' => 'Your account is pending approval'], 401);
        }

        return $this->respondWithToken($user);
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['status'] = 'active';
        $user = User::create($data);
        return $this->respondWithToken($user);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        // Revoke all tokens...
        $request->user()->tokens()->delete();

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

    protected function respondWithToken($user): JsonResponse
    {
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'token' => $token,
            'user' => $user,
        ]);
    }
}
