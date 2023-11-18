<?php

namespace App\Services\External\TransactionAuthorizer;

class TransactionAuthorizerRouteResolver
{
    private const AUTHORIZE = "authorize";

    public static function resolve(string $action): string
    {
        return match ($action) {
            self::AUTHORIZE => 'https://run.mocky.io/v3/5794d450-d2e2-4412-8131-73d0293ac1cc',
            default => throw new \LogicException("Action $action is not implemented"),
        };
    }
}
