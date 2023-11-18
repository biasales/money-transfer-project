<?php

namespace App\Services\Transaction;

use App\Enums\Status;
use App\Enums\UserType;
use App\Exceptions\Transaction\UnauthorizedTransactionException;
use App\Models\TransactionModel;
use App\Repository\Transaction\TransactionRepositoryResolver;
use App\Repository\User\UserRepositoryResolver;
use App\Services\Database\DatabaseResolver;
use App\Services\External\TransactionAuthorizer\TransactionAuthorizerService;
use App\Services\User\UserService;
use App\Services\User\UserWalletService;
use PHPUnit\Logging\Exception;

class TransactionService
{
    public static function prepareTransaction(array $data): int|false
    {
        $transaction = TransactionModel::fromArray($data);
        $transactionId = TransactionRepositoryResolver::resolve()->createTransaction($transaction);

        return $transactionId ?: false;
    }

    public static function executeTransaction(TransactionModel $transaction): bool
    {
        if ($transaction->status != Status::PENDING) {
            return false;
        }

        $amount = $transaction->amount;
        $payer = UserRepositoryResolver::resolve()->getUser($transaction->payerId);
        $payee = UserRepositoryResolver::resolve()->getUser($transaction->payeeId);

        $connection = DatabaseResolver::resolve();
        $connection->beginTransaction();

        try {
            if (!UserWalletService::validateWalletBalance($payer['id'], $amount)) {
                throw new Exception("Wallet does not have enough balance");
            }

            if (!UserService::isUserOfType($payer['id'], UserType::COMMON)) {
                throw new Exception("Payer is not of type Common");
            }

            $isTransactionAuthorized = TransactionAuthorizerService::authorize();

            if (!$isTransactionAuthorized) {
                throw new UnauthorizedTransactionException("Transaction was not authorized by external service");
            }

            $newPayerAmount = $payer['amount'] - $amount;
            $newPayeeAmount = $payee['amount'] + $amount;

            $removePayerAmount = UserWalletService::setWalletBalance($payer['id'], $newPayerAmount);
            $addPayeeAmount = UserWalletService::setWalletBalance($payee['id'], $newPayeeAmount);

            if (!$removePayerAmount || !$addPayeeAmount) {
                $connection->rollBack();

                self::failTransaction($transaction);

                return false;
            }

            $connection->commit();

            self::approveTransaction($transaction);

            return true;
        } catch (\Exception $exception) {
            $connection->rollBack();

            self::failTransaction($transaction);

            return false;
        }
    }

    public static function getTransaction(int $transactionId): ?TransactionModel
    {
        $transaction = TransactionRepositoryResolver::resolve()->getTransaction($transactionId);

        if (isset($transaction)) {
            return TransactionModel::fromArray($transaction);
        }

        return null;
    }

    private static function approveTransaction(TransactionModel $transaction): void
    {
        TransactionRepositoryResolver::resolve()->finishTransaction($transaction->id, Status::APPROVED);
    }

    private static function failTransaction(TransactionModel $transaction): void
    {
        TransactionRepositoryResolver::resolve()->finishTransaction($transaction->id, Status::CANCELLED);
    }
}
