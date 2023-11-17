<?php

namespace App\Repository\Transaction\Internal;

use App\Enums\Status;
use App\Models\TransactionModel;
use App\Services\Database\DatabaseResolver;
use DateTime;
use DateTimeInterface;

class InsertTransaction
{
    private const INSERT_SQL = <<<SQL
INSERT INTO transactions 
    (payee_id, payer_id, amount, status, created_at, finished_at) 
VALUES
    (:payee_id, :payer_id, :amount, :status, :created_at, :finished_at)
SQL;

    public static function insert(TransactionModel $transactionData): ?int
    {
        $connection = DatabaseResolver::resolve();
        $connection->beginTransaction();

        $dateTime = new DateTime();

        $dataToInsert = [
            'payee_id' => $transactionData->payee_id,
            'payer_id' => $transactionData->payer_id,
            'amount' => $transactionData->amount,
            'status' => Status::PENDING->value,
            'password' => $transactionData->status,
            'created_at' => $dateTime->format(DateTimeInterface::ATOM),
            'finished_at' => null,
        ];

        try {
            $result = $connection->executeStatement(self::INSERT_SQL, $dataToInsert);
            $insertedId = $connection->lastInsertId();

            if (!$result) {
                return null;
            }

            $connection->commit();
            return $insertedId;
        } catch (\Exception $exception) {
            $connection->rollBack();
            return null;
        }
    }

}