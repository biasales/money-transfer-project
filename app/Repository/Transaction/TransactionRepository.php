<?php

namespace App\Repository\Transaction;

use App\Enums\Status;
use App\Models\TransactionModel;
use App\Repository\Transaction\Internal\InsertTransaction;
use App\Repository\Transaction\Internal\SelectTransaction;
use App\Repository\Transaction\Internal\UpdateTransaction;

class TransactionRepository
{
    public function createTransaction(TransactionModel $userData): ?int
    {
       return InsertTransaction::insert($userData);
    }

    public function getTransaction(int $transactionId): array
    {
        return SelectTransaction::selectTransactionRow($transactionId);
    }

    public function finishTransaction(int $transactionId, Status $status): bool
    {
        return UpdateTransaction::finishTransaction($transactionId, $status);
    }

}