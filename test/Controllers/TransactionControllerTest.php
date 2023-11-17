<?php

namespace App\Controllers;

use App\Services\Database\DatabaseResolver;
use Psr\Http\Message\ServerRequestInterface as Request;
use PHPUnit\Framework\TestCase;

class TransactionControllerTest extends TestCase
{

    public function testCreateTransaction()
    {
        $this->createUsers();

        $execute = new TransactionController();
//        $execute->createTransaction($this->getMockRequest())

    }

    public function testExecuteTransaction()
    {

    }

    public function testSendResponse()
    {

    }

    public function createUsers() {
        DatabaseResolver::resolve()->insert(
            "INTO users (name, type, document, email, password, amount)
            VALUES
            ('John Doe', '1', '12345678901234', 'john.doe@example.com', 'hashed_password_1', '100.00'),
            ('Jane Smith', '2', '98765432109876', 'jane.smith@example.com', 'hashed_password_2', '150.50'),
            ('Bob Johnson', '1', '55555555555555', 'bob.johnson@example.com', 'hashed_password_3', '75.25'",
        [])
        ;
    }
}
