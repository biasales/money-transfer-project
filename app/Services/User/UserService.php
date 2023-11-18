<?php

namespace App\Services\User;

use App\Enums\UserType;
use App\Repository\User\UserRepositoryResolver;

class UserService
{
    public static function userExistsById(int $userId): bool
    {
        $user = UserRepositoryResolver::resolve()->getUser($userId);

        if (!$user) {
            return false;
        }

        return true;
    }
    public static function deleteUserById(int $userId) : bool {
        $user = self::getUserById($userId);

        if ($user) {
            return UserRepositoryResolver::resolve()->deleteUser($userId);
        }
        return false;
    }

    public static function isUserOfType(int $userId, UserType $userType): bool
    {
        $user = UserRepositoryResolver::resolve()->getUser($userId);

        return $user['type'] == $userType->value;
    }

    public static function getUserById(int $userId): ?array
    {
        return UserRepositoryResolver::resolve()->getUser($userId);
    }
}
