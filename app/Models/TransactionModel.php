<?php

namespace App\Models;

use App\Enums\Status;
use App\Repository\TransactionRepositoryResolver;
use App\Services\Database\DatabaseResolver;

class TransactionModel
{
    public function __construct(
        public readonly ?int $id,
        public readonly int $payee_id,
        public readonly int $payer_id,
        public readonly string $amount,
        public readonly Status $status,
        public readonly ?\DateTime $created_at,
        public readonly ?\DateTime $updated_at,
    ){}

    public static function fromArray(array $transactionData): TransactionModel
    {
        return  new TransactionModel(
            $transactionData['id'],
            $transactionData['payee_id'],
            $transactionData['payer_id'],
            $transactionData['amount'],
            Status::from((int) $transactionData['status']) ?? Status::PENDING,
            $userData['created_at'] ?? null,
            $userData['password'] ?? null,
        );
    }

    public static function makeTransaction(TransactionModel $transaction): bool {
        $amount = $transaction->amount;
        $payer = $transaction->payer_id;
        $payee = $transaction->payee_id;

        $is_has_money = UserModel::isHasMoney($payer, $amount);
        $is_common_user = UserModel::isCommonUser($payer);

        if ($transaction->status == Status::PENDING) {

            if ($is_common_user && $is_has_money) {
                $connection = DatabaseResolver::resolve();
                $connection->beginTransaction();

                try {
                    //TODO: call external service
                    $new_payer_amount = UserModel::updateAmount($payer, $amount, true);
                    $new_payee_amount = UserModel::updateAmount($payee, $amount, false);

                    if (!$new_payee_amount && !$new_payer_amount) {
                        $connection->rollBack();
                        self::failTransaction($transaction);
                    }
                    $connection->commit();
                    self::approveTransaction($transaction);
                } catch (\Exception $exception) {
                    $connection->rollBack();
                    return self::failTransaction($transaction);
                }
            }
        }
        return false;
    }

    private static function updateTransaction(int $transaction_id, Status $transaction_status): void
    {
        TransactionRepositoryResolver::resolve()->finishTransaction($transaction_id, $transaction_status);
    }

    public static function selectTransaction(int $transaction_id): TransactionModel
    {
        $transaction = TransactionRepositoryResolver::resolve()->getTransaction($transaction_id);
        return TransactionModel::fromArray($transaction);
    }

    public static function failTransaction(TransactionModel $transaction): false {
        self::updateTransaction($transaction->id, Status::CANCELLED);
        return false;
    }

    public static function approveTransaction(TransactionModel $transaction): true {
        self::updateTransaction($transaction->id, Status::APPROVED);
        return true;
    }

}