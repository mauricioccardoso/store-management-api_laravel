<?php

namespace App\Http\Controllers;

use App\Helpers\Logger;
use App\Http\Requests\StoreUserRequest;
use App\Services\UserService;
use Exception;
use Illuminate\Support\Facades\DB;


class UserController extends Controller
{
    public function __construct(protected UserService $userService)
    {
    }

    public function store(StoreUserRequest $request)
    {
        DB::beginTransaction();

        try {
            $user = $this->userService->createUser($request->all());
            DB::commit();

            return response()->json(["user" => $user], 201);
        } catch (Exception $e) {
            DB::rollBack();

            $error = 'Unable to create a new user.';
            Logger::log($e, $error);

            return response()->json(["error" => $error], 500);
        }
    }
}
