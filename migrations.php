<?php
/*
SHOULD BE SIMILAR JUST LIKE WE WERE DOING IN
THE WEB. BUT NO NEEDS THE ROUTINGS AND RUN THEM.
INSTEAD, WHAT WE NEED AT HERE IS THAT RUN THE DB (MIGRATIONS).
*/

// Include autoload
require_once __DIR__ . "/vendor/autoload.php";

// Import phpdotenv Package
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Configuration for the databas
$config = [
    'userClass' => \app\models\User::class,
    "db" => [
        "dsn" => $_ENV["DB_DSN"],
        "user" => $_ENV["DB_USER"],
        "password" => $_ENV["DB_PASSWORD"],
    ]
];

// App instance
$app = new alfianchii\phpmvc\Application(__DIR__, $config);

// Run the database migrations
$app->db->applyMigrations();