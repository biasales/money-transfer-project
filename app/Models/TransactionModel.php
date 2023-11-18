<?php

namespace App\Models;

use App\Enums\Status;

class TransactionModel
{
    public function __construct(
        public readonly ?int       $id,
        public readonly int        $payeeId,
        public readonly int        $payerId,
        public readonly int        $amount,
        public readonly Status     $status,
        public readonly ?\DateTime $createdAt,
        public readonly ?\DateTime $updatedAt,
    ) {}

    public static function fromArray(array $transactionData): TransactionModel
    {
        return  new TransactionModel(
            $transactionData['id'] ?? null,
            $transactionData['payee_id'],
            $transactionData['payer_id'],
            $transactionData['amount'],
            isset($transactionData['status']) ? Status::from($transactionData['status']) : Status::PENDING,
            $userData['created_at'] ?? null,
            $userData['password'] ?? null,
        );
    }

    public static function asArray(TransactionModel $transaction): array
    {
        return [
            'id' => $transaction->id,
            'payee_id' => $transaction->payeeId,
            'payer_id' => $transaction->payerId,
            'amount' => $transaction->amount,
            'status' => $transaction->status->value,
            'created_at' => $transaction->createdAt->format(\DateTimeInterface::ATOM),
            'updated_at' => $transaction->updatedAt->format(\DateTimeInterface::ATOM),
        ];
    }
}