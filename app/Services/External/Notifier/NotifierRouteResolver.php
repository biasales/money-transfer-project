<?php

namespace App\Services\External\Notifier;

class NotifierRouteResolver
{
    private const NOTIFY = "notify";

    public static function resolve(string $action): string
    {
        return match ($action) {
            self::NOTIFY => 'https://run.mocky.io/v3/54dc2cf1-3add-45b5-b5a9-6bf7e7f1f4a6',
            default => throw new \LogicException("Action $action is not implemented"),
        };
    }
}
