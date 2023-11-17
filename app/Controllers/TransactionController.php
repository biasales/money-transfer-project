<?php

namespace App\Controllers;

use App\Models\TransactionModel;
use App\Repository\TransactionRepositoryResolver;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class TransactionController
{
    public function createTransaction(Request $request, Response $response, $args): Response
    {
        echo(json_encode($request));
        $parsedBody = $request->getParsedBody();

        $transaction = TransactionModel::fromArray($parsedBody);

        if (TransactionRepositoryResolver::resolve()->createTransaction($transaction)) {
            return $this->sendResponse($response, 201, 'Transaction created Successfully');
        }

        return $this->sendResponse($response, 200, 'Failed to create transaction');
    }

    public function executeTransaction(Request $request, Response $response, $args): Response
    {
        $parsedBody = $request->getParsedBody();

        $transaction = TransactionModel::selectTransaction($parsedBody['id']);

        if (TransactionModel::makeTransaction($transaction)) {
            return $this->sendResponse($response, 200, 'Transaction execute with success');
        }

        return $this->sendResponse($response, 200, 'Failed to execute transaction');
    }

    public function sendResponse(ResponseInterface $response, int $status_code, string $message): Response {
        $response->getBody()->write($message);
        return $response
            ->withStatus($status_code)
            ->withHeader('Content-Type', 'application/json');
    }

}