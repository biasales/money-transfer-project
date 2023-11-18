<?php

namespace App\Repository\User\Internal;

use App\Services\Database\DatabaseResolver;

class UpdateUser
{
    private const UPDATE_SQL = "UPDATE users SET amount = :amount WHERE id = :id";

    public static function updateAmount(int $userId, int $amount): bool
    {
        $connection = DatabaseResolver::resolve();
        $connection->beginTransaction();

        try {
            $result = $connection->executeStatement(self::UPDATE_SQL, ['amount' => $amount, 'id' => $userId]);

            if ($result == 0) {
                return false;
            }

            $connection->commit();

            return true;
        } catch (\Exception $exception) {
            $connection->rollBack();
            return false;
        }
    }

}