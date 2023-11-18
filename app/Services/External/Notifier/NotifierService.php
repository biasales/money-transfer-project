<?php

namespace App\Services\External\Notifier;

class NotifierService
{
    private const SENT_MESSAGE = true;

    public static function notify(NotificationMethod $notificationMethod): bool
    {
        $response = NotifierAPI::notify($notificationMethod);
        $responseBody = $response->getBody()->getContents();

        $decodedResponseBody = json_decode($responseBody);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return false;
        }

        if ($response->getStatusCode() != 200) {
            return false;
        } elseif ($decodedResponseBody->message != self::SENT_MESSAGE) {
            return false;
        }

        return true;
    }
}
