<?php

namespace App\Http\Controllers;

use App\Helpers\Logger;
use App\Services\AuthService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(protected AuthService $authService)
    {
    }

    public function login(Request $request): JsonResponse
    {
        try {
            $userAuth = $this->authService->login($request->all());

            if (!$userAuth) {
                return response()->json(['message' => 'The Provided credentials are not correct'], 401);
            }

            return response()->json($userAuth);
        } catch (Exception $e) {
            $error = 'Unable to log in. Please try again.';
            Logger::log($e, $error);

            return response()->json(['errors' => $error], 500);
        }
    }

    public function logout(): JsonResponse
    {
        try {
            $this->authService->logout();

            return response()->json(['message' => 'Logout successful.']);
        } catch (Exception $e) {
            $error = 'Unable to log out. Please try again.';
            Logger::log($e, $error);

            return response()->json(['errors' => $error], 500);
        }
    }
}
