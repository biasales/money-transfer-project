<?php

namespace App\Repository\User\Internal;

use App\Services\Database\DatabaseResolver;

class DeleteUser
{
    public static function deleteUser(string $userId): bool {
        $connection = DatabaseResolver::resolve();

        return $connection->executeStatement('DELETE FROM users where id = :id', ['id' => $userId]);
    }

}