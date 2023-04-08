<?php 
header("Content-Type: application/json");

use Slim\Factory\AppFactory;

require_once __DIR__ . '/../vendor/autoload.php';

Dotenv\Dotenv::createUnsafeImmutable(__DIR__.'/../')->load();

$app = AppFactory::create();
// Register middleware
(require __DIR__ . '/middleware.php')($app);

// Register routes
(require __DIR__ . '/routes.php')($app);



return $app;