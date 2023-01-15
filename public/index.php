<?php
// Importing
use app\controllers\{SiteController, AuthController};

// Include autoload
require_once __DIR__ . "/../vendor/autoload.php";

// Import phpdotenv Package
$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

// Configuration for the databas
$config = [
    "userClass" => app\models\User::class,
    "db" => [
        "dsn" => $_ENV["DB_DSN"],
        "user" => $_ENV["DB_USER"],
        "password" => $_ENV["DB_PASSWORD"],
    ]
];

// App instance
$app = new alfianchii\phpmvc\Application(dirname(__DIR__), $config);

// Routes
$app->router->get('/', [SiteController::class, "home"]);
$app->router->get('/contact', [SiteController::class, "contact"]);
$app->router->post('/contact', [SiteController::class, "contact"]);

$app->router->get('/login', [AuthController::class, "login"]);
$app->router->post('/login', [AuthController::class, "login"]);
$app->router->get('/register', [AuthController::class, "register"]);
$app->router->post('/register', [AuthController::class, "register"]);
$app->router->get('/logout', [AuthController::class, "logout"]);
$app->router->get('/profile', [AuthController::class, "profile"]);

// Run application
$app->run();