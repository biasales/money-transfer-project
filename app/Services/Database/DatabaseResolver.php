<?php

namespace App\Services\Database;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;

class DatabaseResolver
{
    private static Connection $database_connection;

    public static function resolve(): Connection
    {
        return self::$database_connection ?? self::$database_connection = self::getDatabaseConnection();
    }

    private static function getDatabaseConnection(): Connection
    {
        $connectionParams = [
            'dbname'   => 'money-project-database',
            'user'     => 'root', // TODO: Add this as Env
            'password' => 'root', // TODO: Add this as Env
            'host'     => 'mysql', // TODO: Add this as Env
            'driver'   => 'pdo_mysql',
        ];

        return DriverManager::getConnection($connectionParams);
    }
}