<?php

use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

$app->add(\App\Middleware\JsonBodyParserMiddleware::class);

// Routes
$app->post('/api/users', '\App\Controllers\UserController:createUser');
$app->get('/api/users', '\App\Controllers\UserController:getUser');
$app->delete('/api/users', '\App\Controllers\UserController:deleteUser');

$app->post('/api/transaction', '\App\Controllers\TransactionController:createTransaction');
$app->get('/api/transaction', '\App\Controllers\TransactionController:getTransaction');
$app->post('/api/transaction/execute', '\App\Controllers\TransactionController:executeTransaction');

$app->run();


