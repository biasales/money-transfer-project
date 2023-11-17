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

       if (UserRepositoryResolver::resolve()->createUser($user)) {
           return $this->sendResponse($response, 200, 'User created Successfully');
       }

        return $this->sendResponse($response, 200, 'Failed to create user');
    }

    public function sendResponse(ResponseInterface $response, int $status_code, string $message): Response {
        $response->getBody()->write($message);

        return $response
            ->withStatus($status_code)
            ->withHeader('Content-Type', 'application/json');
    }
}