<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;

class AuthService
{
    public function login($credentials): array | bool
    {
        if (!Auth::attempt($credentials)) {
            return false;
        }

        $user = Auth::user();
        $user->tokens()->delete();

        $token = $user->createToken('agilityToken')->plainTextToken;

        return [
            'user' => $user,
            'token' => $token
        ];
    }

    public function logout(): void
    {
        $user = Auth::user();
        $user->tokens()->delete();
    }
}
