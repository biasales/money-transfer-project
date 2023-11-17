<?php

namespace App\Repository\User;

use App\Repository\UserRepository;

class UserRepositoryResolver
{
    public static function resolve(): UserRepository
    {
        return new UserRepository();
    }
}
