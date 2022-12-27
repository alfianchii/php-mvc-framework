<?php
// Include autoload
require_once __DIR__ . "/../vendor/autoload.php";

// Importing
use app\controllers\{SiteController, AuthController};
use app\core\Application;

// App instance
$app = new Application(dirname(__DIR__));

// Routes
$app->router->get('/', [SiteController::class, "home"]);
$app->router->get('/contact', [SiteController::class, "contact"]);
$app->router->post('/contact', [SiteController::class, "handleContact"]);

$app->router->get('/login', [AuthController::class, "login"]);
$app->router->post('/login', [AuthController::class, "login"]);
$app->router->get('/register', [AuthController::class, "register"]);
$app->router->post('/register', [AuthController::class, "register"]);

// Run application
$app->run();