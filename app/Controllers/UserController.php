<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Repository\UserRepositoryResolver;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class UserController
{
    public function createUser(Request $request, Response $response, $args): Response
    {
       $parsedBody = $request->getParsedBody();

       $user = UserModel::fromArray($parsedBody);

       $inserted_id = UserRepositoryResolver::resolve()->createUser($user);

       if ($inserted_id) {
           return $this->sendResponse($response, 200, 'User successfully created with id ' . $inserted_id);
       }

        return $this->sendResponse($response, 200, 'Unable to create user');
    }

    public function getUser(Request $request, Response $response, $args): Response
    {
        $parsedBody = $request->getParsedBody();

        $user = UserModel::getUser($parsedBody['id']);

        if ($user) {
            $user_as_array = UserModel::asArray($user);
            return $this->sendResponse($response, 200, 'User with id: ' . json_encode($user_as_array, true));
        }

        return $this->sendResponse($response, 200, 'Unable to find user');
    }

    public function deleteUser(Request $request, Response $response, $args): Response
    {
        $parsedBody = $request->getParsedBody();
        $userId = $parsedBody['id'];

        $user = UserModel::deleteUser($userId);

        if ($user) {
            return $this->sendResponse($response, 200, 'Deleted user with id: ' . $userId);
        }

        return $this->sendResponse($response, 200, 'Unable to delete user');
    }

    public function sendResponse(ResponseInterface $response, int $status_code, string $message): Response {
        $response->getBody()->write($message);

        return $response
            ->withStatus($status_code)
            ->withHeader('Content-Type', 'application/json');
    }
}