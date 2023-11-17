<?php

namespace App\Repository\User\Internal;

use App\Services\Database\DatabaseResolver;

class UpdateUser
{
    public static function updateAmount(string $amount, int $userId): bool {
        $connection = DatabaseResolver::resolve();

        return $connection->executeStatement('UPDATE users SET amount = :amount where id = :id', ['id' => $userId, 'amount' => $amount,]);
    }

}