<?php

namespace App\Repository;

use Doctrine\DBAL\DriverManager;

class UserRepository
{
    public static function createUser($userData): array
    {
//        try {
//            $connectionParams = [
//                'dbname' => 'money-project-database',
//                'user' => 'root',
//                'password' => 'root',
//                'host' => 'mysql',
//                'driver' => 'pdo_mysql',
//            ];
//
//            $conn = DriverManager::getConnection($connectionParams);
//        } catch (\PDOException $e) {
//            throw new \PDOException($e->getMessage(), $e->getCode());
//        }

       return $userData;
    }

}