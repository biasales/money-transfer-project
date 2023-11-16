<?php

namespace App\Controllers;

use App\Repository\UserRepository;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Psr7\Stream;

class UserController
{
    public function createUser(Request $request, Response $response, $args): Response
    {
//        $userData = $request->getParsedBody();
        $name = $args['name'];

        $response->getBody()->write("Hello, $name");
        return $response;

//        $response->getBody()->write($test);
//        return $response
//            ->withStatus(201)
//            ->withHeader('Content-Type', 'application/json');
    }
}