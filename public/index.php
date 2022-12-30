<?php
// Importing
use app\controllers\{SiteController, AuthController};
use app\core\Application;

// Include autoload
require_once __DIR__ . "/../vendor/autoload.php";

// Import phpdotenv Package
$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

// Configuration for the databas
$config = [
    "db" => [
        "dsn" => $_ENV["DB_DSN"],
        "user" => $_ENV["DB_USER"],
        "password" => $_ENV["DB_PASSWORD"],
    ]
];

// App instance
$app = new Application(dirname(__DIR__), $config);

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