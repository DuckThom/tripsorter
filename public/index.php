<?php

define('BASE_PATH', __DIR__ . "/../");

// Composer autoloader
require __DIR__ . "/../vendor/autoload.php";

// App bootstrapper
require __DIR__ . '/../bootstrap/app.php';

// Application
$app = new Application();
$app->run();