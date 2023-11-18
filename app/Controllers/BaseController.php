<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;

abstract class BaseController
{
    public function sendResponse(Response $response, int $statusCode, string $message, array $data = []): Response
    {
        $responseJson = json_encode([
            'message' => $message,
            'data' => $data,
        ]);

        $response->getBody()->write($responseJson);

        return $response
            ->withStatus($statusCode)
            ->withHeader('Content-Type', 'application/json');
    }
}
