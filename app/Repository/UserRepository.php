<?php

namespace App\Repository;

use App\Models\UserModel;
use App\Repository\User\InsertUser;

class UserRepository
{
    public function createUser(UserModel $userData): bool
    {
        return InsertUser::execute($userData);
    }

}