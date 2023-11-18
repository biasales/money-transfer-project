<?php

namespace App\Repository\Transaction\Internal;

use App\Enums\Status;
use App\Services\Database\DatabaseResolver;
use DateTime;

class UpdateTransaction
{
    public static function finishTransaction(int $transactionId, Status $status): bool
    {
        $now = new DateTime();
        $connection = DatabaseResolver::resolve();

        return $connection->executeStatement(
            'UPDATE transactions SET finished_at = :finished_at, status = :status WHERE id = :id',
            [
                'id' => $transactionId,
                'finished_at' => $now->format(\DateTimeInterface::ATOM),
                'status' => $status->value,
            ]
        );
    }


}