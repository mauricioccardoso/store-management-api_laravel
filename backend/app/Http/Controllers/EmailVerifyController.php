<?php

namespace App\Http\Controllers;

use App\Helpers\Logger;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmailVerifyController extends Controller
{
    public function verify($id, Request $request)
    {
        try {
            $user = User::find($id);

            if (!$request->hasValidSignature()) {
                return response()->json([
                    'message' => 'Invalid request.'
                ], 403);
            }

            if ($user->hasVerifiedEmail()) {
                return response()->json(['message' => 'Email already verified.']);
            }

            $user->markEmailAsVerified();

            return response()->json(['message' => 'Email successfully verified.']);
        } catch (Exception $e) {
            $error = 'Email validation failed';
            Logger::log($e, $error);

            return response()->json(['errors' => $error], 500);
        }
    }

    public function notice()
    {
        try {
            $user = User::find(Auth::id());
            if ($user->hasVerifiedEmail()) {
                return response()->json(['message' => 'Email already verified.']);
            }

            return response()->json(['message' => 'Email not verified.'], 401);
        } catch (Exception $e) {
            $error = 'Server error';
            Logger::log($e, $error);

            return response()->json(['errors' => $error], 500);
        }
    }

    public function resend()
    {
        try {
            $user = User::find(Auth::id());

            if ($user->hasVerifiedEmail()) {
                return response()->json(['message' => 'Email already verified.']);
            }

            $user->sendEmailVerificationNotification();
            return response()->json(['message' => 'Email resent.']);
        } catch (Exception $e) {
            $error = 'Unable to resend the email. Please try again.';
            Logger::log($e, $error);

            return response()->json(['errors' => $error], 500);
        }
    }
}
