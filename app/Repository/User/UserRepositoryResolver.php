<?php

namespace App\Repository\User;

class UserRepositoryResolver
{
    public static function resolve(): UserRepository
    {
        return new UserRepository();
    }
}
