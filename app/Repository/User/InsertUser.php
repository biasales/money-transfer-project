<?php

namespace App\Repository\User;

use App\Models\UserModel;
use App\Services\Database\DatabaseResolver;
use DateTime;
use DateTimeInterface;

class InsertUser
{
    private const INSERT_SQL =
        "INSERT INTO users (name, type, document, amount, email, password, created_at, updated_at) VALUES(:name, :type, :document, :amount, :email, :password, :created_at, :updated_at)";

    public static function execute(UserModel $userData): bool
    {
        $connection = DatabaseResolver::resolve();
        $connection->beginTransaction();

        $dateTime = new DateTime();

        $dataToInsert = [
            'name' =>  $userData->name,
            'type' =>  $userData->type->value,
            'document' =>  $userData->document,
            'amount' => $userData->amount,
            'email' =>  $userData->email,
            'password' =>  $userData->password,
            'created_at' =>  $dateTime->format(DateTimeInterface::ATOM),
            'updated_at' =>  $dateTime->format(DateTimeInterface::ATOM),
        ];

        try {
            $result = $connection->executeStatement(self::INSERT_SQL, $dataToInsert);

            if (!$result) {
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
