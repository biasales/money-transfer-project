<?php

namespace App\Repository\Transaction;

use App\Enums\Status;
use App\Models\TransactionModel;
use App\Services\Database\DatabaseResolver;
use DateTimeInterface;
use DateTime;

class InsertTransaction
{
    private const INSERT_SQL =
        "INSERT INTO transactions (payee_id, payer_id, amount, status, created_at, finished_at) VALUES( :payee_id, :payer_id, :amount, :status, :created_at, :finished_at)";

    public static function execute(TransactionModel $transactionData): bool
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

//        try {
            $result = $connection->executeStatement(self::INSERT_SQL, $dataToInsert);

            if (!$result) {
                return false;
            }

            $connection->commit();

            return true;
//        } catch (\Exception $exception) {
//            $connection->rollBack();
//            return false;
//        }
    }

}