<?php

namespace App\Repository\Transaction;

use App\Models\TransactionModel;
use App\Services\Database\DatabaseResolver;

class InsertTransaction
{
    public static function execute(TransactionModel $transaction): bool
    {
        $connection = DatabaseResolver::resolve();
        $connection->beginTransaction();

        try {
            $result = $connection->createQueryBuilder()->insert($transaction->toArray());

            if (!$result) {
                return false;
            }
            $connection->commit();
        } catch (\Exception $exception) {
            $connection->rollBack();
            throw new \Exception('erro ao tentar persistir no banco de dados');
            return false;
        }
        return true;
    }

}