<?php

namespace App\Repository\User;

use App\Models\UserModel;
use App\Repository\User\Internal\InsertUser;
use App\Repository\User\Internal\SelectUser;
use App\Repository\User\Internal\UpdateUser;

class UserRepository
{
    public function createUser(UserModel $userData): bool
    {
       return InsertUser::insert($userData);
    }

    public function getAmount(int $userId): bool
    {
        return SelectUser::getMoney($userId);
    }

    public function isCommonUserType(int $userId): bool {
        return SelectUser::isCommonUserType($userId);
    }

    public function updateAmount(int $userId, string $amount): bool {
        return UpdateUser::updateAmount($userId, $amount);
    }

    public function hasAmount(int $userId, string $amount): bool {
        return SelectUser::hasAmount($userId, $amount);
    }

}