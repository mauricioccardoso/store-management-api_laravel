<?php

namespace App\Services;

use App\Models\User;

class UserService
{
    public function createUser($data): User
    {
        return User::create($data);
    }
}
