<?php

namespace Test\App\Controllers;

use App\Services\Database\DatabaseResolver;
use DateTime;
use PHPUnit\Framework\TestCase;
class UserRepositoryTest extends TestCase
{
    public function testCreateUser() {

    }

    public function testDeleteUser() {
        $insertedId = $this->insertTestUser();
        $execute = (new \App\Repository\User\UserRepository())->deleteUser($insertedId);

        $findId = (new \App\Repository\User\UserRepository())->getUser($insertedId);

        $this->assertTrue($execute);
        $this->assertNull($findId);
    }

    public function insertTestUser(): int
    {
        $userData = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'amount' => '10.00',
            'password' => '123456',
            'created_at' => new DateTime(),
            'updated_at' => null,
        ];

        $connection = DatabaseResolver::resolve();
        $connection->insert('users',$userData);
        return $connection->lastInsertId();
    }


}