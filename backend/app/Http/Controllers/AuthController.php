<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(protected AuthService $authService)
    {
    }

    public function login(Request $request): JsonResponse
    {
        $userAuth = $this->authService->login($request->all());

        if (!$userAuth) {
            return response()->json(['message' => 'The Provided credentials are not correct'], 401);
        }

        return response()->json($userAuth);
    }

    public function logout(): JsonResponse
    {
        $this->authService->logout();

        return response()->json(['message' => 'Logout successful.']);
    }
}
