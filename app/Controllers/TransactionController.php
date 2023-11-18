<?php

namespace App\Controllers;

use App\Models\TransactionModel;
use App\Services\External\Notifier\NotificationMethod;
use App\Services\External\Notifier\NotifierService;
use App\Services\Transaction\TransactionService;
use App\Services\User\UserService;
use App\Services\User\UserWalletService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class TransactionController
{
    public function createTransaction(Request $request, Response $response): Response
    {
        $data = $request->getParsedBody();

        if (!UserService::userExistsById($data['payer_id'])) {
            return $this->sendResponse($response, 400, 'Failed creating transaction: Payer is unknown');
        }

        if (!UserService::userExistsById($data['payee_id'])) {
            return $this->sendResponse($response, 400, 'Failed creating transaction: Payee is unknown');
        }

        if (!UserWalletService::validateWalletBalance($data['payer_id'], $data['amount'])) {
            return $this->sendResponse($response, 400, 'Failed creating transaction: Unsufficient funds');
        }

        $insertedId = TransactionService::prepareTransaction($data);

        if (!$insertedId) {
            return $this->sendResponse($response, 200, 'Failed to create transaction');
        }

        return $this->sendResponse($response, 201, 'Transaction created successfully with id: '. $insertedId);
    }

    public function executeTransaction(Request $request, Response $response): Response
    {
        $data = $request->getParsedBody();

        $transaction = TransactionService::getTransaction($data['id']);
        $transactionWasExecuted = TransactionService::executeTransaction($transaction);

        if (!$transactionWasExecuted) {
            return $this->sendResponse($response, 400, 'Failed to execute transaction');
        }

        NotifierService::notify(NotificationMethod::EMAIL);

        return $this->sendResponse($response, 200, 'Transaction executed successfully');
    }

    public function getTransaction(Request $request, Response $response): Response
    {
        $parsedBody = $request->getParsedBody();

        $transaction = TransactionModel::getTransaction($parsedBody['id']);

        if ($transaction) {
            $transactionAsArray = TransactionModel::asArray($transaction);
            return $this->sendResponse($response, 200, 'Transaction with id:'. json_encode($transactionAsArray, true));
        }

        return $this->sendResponse($response, 200, 'Failed to find transaction');
    }
}