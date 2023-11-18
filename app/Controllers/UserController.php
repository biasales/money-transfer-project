<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Repository\User\UserRepositoryResolver;
use App\Services\User\UserService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class UserController extends BaseController
{
    public function createUser(Request $request, Response $response): Response
    {
       $parsedBody = $request->getParsedBody();

       $user = UserModel::fromArray($parsedBody);

       $insertedId = UserRepositoryResolver::resolve()->createUser($user);

       if ($insertedId) {
           return $this->sendResponse($response, 201, 'User successfully created with id ' . $insertedId);
       }

        return $this->sendResponse($response, 400, 'Unable to create user');
    }

    public function getUser(Request $request, Response $response): Response
    {
        $parsedBody = $request->getParsedBody();

        $user = UserService::getUserById($parsedBody['id']);

        if ($user) {
            return $this->sendResponse($response, 200, 'User retrieved successfully', $user);
        }

        return $this->sendResponse($response, 400, 'Unable to find user');
    }

    public function deleteUser(Request $request, Response $response): Response
    {
        $parsedBody = $request->getParsedBody();
        $userId = $parsedBody['id'];

        $userWasDeleted = UserService::deleteUserById($userId);

        if ($userWasDeleted) {
            return $this->sendResponse($response, 200, 'Deleted user with id: ' . $userId);
        }

        return $this->sendResponse($response, 400, 'Unable to delete user');
    }
}