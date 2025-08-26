<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(RegisterRequest $registerRequest): JsonResponse
    {
        $validated = $registerRequest->validated();
        $validated['password'] = Hash::make($validated['password']);
        $user = User::create($validated);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'access_token' => $token,
            'token_type' => 'Bearer',
        ], 201);
    }

    public function login(LoginRequest $loginRequest): JsonResponse
    {
        $user = User::where('email', $loginRequest->email)->first();

        if (!$user || !Hash::check($loginRequest->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Неверные учетные данные'],
            ]);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user,
        ]);
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Успешный выход из системы'
        ]);
    }

    public function user(Request $request): JsonResponse
    {
        return response()->json([
            'user' => $request->user()->only(['id','name','last_name','second_name','email'])
        ]);
    }
}
