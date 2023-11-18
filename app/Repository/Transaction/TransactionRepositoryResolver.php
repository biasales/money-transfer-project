<?php

namespace App\Repository\Transaction;

class TransactionRepositoryResolver
{
    public static function resolve(): TransactionRepository
    {
        return new TransactionRepository();
    }

}