<?php

namespace App\Services\External\TransactionAuthorizer;

class TransactionAuthorizerService
{
    private const AUTHORIZED_MESSAGE = "Autorizado";

    public static function authorize(): bool
    {
        $response = TransactionAuthorizerAPI::authorize();
        $responseBody = $response->getBody()->getContents();

        $decodedResponseBody = json_decode($responseBody);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return false;
        }

        if ($response->getStatusCode() != 200) {
            return false;
        } elseif ($decodedResponseBody->message != self::AUTHORIZED_MESSAGE) {
            return false;
        }

        return true;
    }
}
