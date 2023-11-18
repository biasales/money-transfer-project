<?php

namespace App\Services\User;

use App\Repository\User\UserRepositoryResolver;

class UserWalletService
{
    public static function validateWalletBalance(int $userId, int $amount): bool
    {
        $user = UserRepositoryResolver::resolve()->getUser($userId);

        if (!$user) {
            return false;
        } elseif ($user['amount'] < $amount) {
            return false;
        }

        return true;
    }

    public static function setWalletBalance(int $userId, int $newBalance): bool
    {
        return UserRepositoryResolver::resolve()->updateAmount($userId, $newBalance);
    }
}
