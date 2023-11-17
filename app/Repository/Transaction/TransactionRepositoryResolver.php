<?php

namespace App\Repository\Transaction;

use App\Repository\TransactionRepository;

class TransactionRepositoryResolver
{
    public static function resolve(): TransactionRepository
    {
        return new TransactionRepository();
    }

}