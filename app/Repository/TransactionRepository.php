<?php

namespace App\Repository;

use App\Models\TransactionModel;
use App\Repository\Transaction\InsertTransaction;

class TransactionRepository
{
    public function createTransaction(TransactionModel $userData): bool
    {
        return InsertTransaction::execute($userData);
    }

}