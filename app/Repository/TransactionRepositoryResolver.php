<?php

namespace App\Repository;

use App\Repository\Transaction\TransactionRepository;

class TransactionRepositoryResolver
{
    public static function resolve(): TransactionRepository
    {
        return new TransactionRepository();
    }

}