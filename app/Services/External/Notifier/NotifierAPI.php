<?php

namespace App\Services\External\Notifier;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\ResponseInterface;

class NotifierAPI
{
    public static function notify(NotificationMethod $notificationMethod): ResponseInterface
    {
        $uri = NotifierRouteResolver::resolve("notify");
        $body = self::makeBody($notificationMethod->name, "", "");

        return self::makeRequest($uri, $body);
    }

    private static function makeBody(string $notificationMethod, string $to, string $content): array
    {
        return [
            'method' => strtolower($notificationMethod),
            'to' => $to,
            'content' => $content,
        ];
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
