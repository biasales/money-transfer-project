<?php

namespace App\Repository\Transaction\Internal;

use App\Services\Database\DatabaseResolver;

class SelectTransaction
{
    public static function selectTransactionRow(int $transactionId): ?array {
        $result = DatabaseResolver::resolve()->executeQuery(
            'SELECT id, payee_id, payer_id, amount, status, created_at, finished_at FROM transactions where id = :id',
            [
                'id' => $transactionId
            ]
        )
            ->fetchAssociative();


        return !$result ? null : $result;
    }

}