<?php

namespace App\Services\Database;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;

class DatabaseResolver
{
    private static Connection $databaseConnection;

    public static function resolve(): Connection
    {
        return self::$databaseConnection ?? self::$databaseConnection = self::getDatabaseConnection();
    }

    private static function getDatabaseConnection(): Connection
    {
        $connectionParams = [
            'dbname'   => 'money-project-database',
            'user'     => 'root',
            'password' => 'root',
            'host'     => 'mysql',
            'driver'   => 'pdo_mysql',
        ];

        return DriverManager::getConnection($connectionParams);
    }
}