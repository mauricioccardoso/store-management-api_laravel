<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request): JsonResponse
    {
        $credentials = $request->all();

        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'The Provided credentials are not correct'], 401);
        }

        $user = Auth::user();
        $user->tokens()->delete();

        $token = $user->createToken('agilityToken')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token
        ]);
    }
}
