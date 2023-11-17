<?php

use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

$app->add(\App\Middleware\JsonBodyParserMiddleware::class);

// Routes
$app->post('/users', '\App\Controllers\UserController:createUser');
$app->get('/users', '\App\Controllers\UserController:getUser');
$app->delete('/users', '\App\Controllers\UserController:deleteUser');

$app->post('/transaction', '\App\Controllers\TransactionController:createTransaction');
$app->get('/executeTransaction', '\App\Controllers\TransactionController:executeTransaction');

$app->run();


