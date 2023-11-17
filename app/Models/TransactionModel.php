<?php

namespace App\Models;

use App\Enums\Status;

class TransactionModel
{
    public function __construct(
        public readonly int $payee_id,
        public readonly int $payer_id,
        public readonly string $amount,
        public readonly Status $status,
    ){}

    public static function fromArray(array $userData): TransactionModel
    {
        return new TransactionModel(
            $userData['payee_id'],
            $userData['payer_id'],
            $userData['amount'],
            Status::PENDING,
        );
    }

    public static function makeTransaction(TransactionModel $transaction) {


    }

}