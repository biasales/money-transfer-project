<?php

namespace App\Repository\User\Internal;

use App\Enums\UserType;
use App\Services\Database\DatabaseResolver;

class SelectUser
{
    public static function hasAmount(int $userId, string $amount): string
    {
        $result = self::getMoney($userId);

        return $result >= $amount;
    }

    public static function getMoney(int $userId): string
    {
        $connection = DatabaseResolver::resolve();
        return $connection->fetchOne('SELECT amount from users where id = :id', ['id' => $userId]);

    }

    public static function isCommonUserType(int $userId): bool
    {
        $connection = DatabaseResolver::resolve();
        $result = $connection->fetchOne('SELECT type from users where id = :id', ['id' => $userId]);

        return $result == UserType::COMMON->value;
    }

}