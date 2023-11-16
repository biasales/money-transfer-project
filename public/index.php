<?php

use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';


$app = AppFactory::create();

// Routes
//$app->get('/users', '\Controllers\UserController:getAllUsers');
//$app->get('/users/{id}', '\Controllers\UserController:getUser');
$app->get('/users/{name}', '\App\Controllers\UserController:createUser');
//$app->put('/users/{id}', '\Controllers\UserController:updateUser');
//$app->delete('/users/{id}', '\Controllers\UserController:deleteUser');

$app->run();


