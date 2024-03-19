<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    public static function register($request)
    {
        $register = User::create($request);

        return $register;
    }
}