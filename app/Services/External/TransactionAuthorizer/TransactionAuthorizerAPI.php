<?php

namespace App\Services\External\TransactionAuthorizer;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\ResponseInterface;

class TransactionAuthorizerAPI
{
    public static function authorize(): ResponseInterface
    {
        $uri = TransactionAuthorizerRouteResolver::resolve("authorize");
        $body = self::makeBody();

        return self::makeRequest($uri, $body);
    }

    private static function makeBody(): array
    {
        return [];
    }

    private static function makeRequest(string $uri, array $body): ResponseInterface
    {
        $client = new Client();
        $request = new Request(
            method: 'POST',
            uri: $uri,
            body: json_encode($body),
        );

        return $client->send($request, ['timeout' => 30, 'http_errors' => false]);
    }
}
