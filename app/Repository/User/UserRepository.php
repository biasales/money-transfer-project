<?php

namespace App\Repository\User;

use App\Models\UserModel;
use App\Repository\User\Internal\DeleteUser;
use App\Repository\User\Internal\InsertUser;
use App\Repository\User\Internal\SelectUser;
use App\Repository\User\Internal\UpdateUser;

class UserRepository
{
    public function createUser(UserModel $userData): ?int
    {
       return InsertUser::insert($userData);
    }

    public function getUser(int $userId): ?array
    {
        return SelectUser::getUser($userId);
    }

    public function updateAmount(int $userId, string $amount): bool {
        return UpdateUser::updateAmount($userId, $amount);
    }

    public function deleteUser(?int $userId): bool
    {
        return DeleteUser::deleteUser($userId);
    }

}