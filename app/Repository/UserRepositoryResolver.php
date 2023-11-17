<?php

namespace App\Repository;

use App\Repository\User\UserRepository;

class UserRepositoryResolver
{
    public static function resolve(): UserRepository
    {
        return new UserRepository();
    }
}
