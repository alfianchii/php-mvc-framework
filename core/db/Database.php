<?php

namespace app\core\db;

use PDO;
use app\core\Application;

class Database
{
    // PDO
    public PDO $pdo;

    // Constructor (when the class was instaced, run this constructor)
    public function __construct(array $config)
    {
        // Database configuration
        $dsn = $config["dsn"] ?? "";
        $user = $config["user"] ?? "";
        $password = $config["password"] ?? "";

        // Define the database
        $this->pdo = new \PDO($dsn, $user, $password);
        // Trace the errors of databqase if occurs
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    // Run migrations
    public function applyMigrations()
    {
        // Create imigrations table
        $this->createMigrationsTable();
        // Get applied migrations
        $appliedMigrations = $this->getAppliedMigration();

        // Take the migration files
        $newMigrations = [];
        $files = scandir(Application::$ROOT_DIR . "/migrations");

        // Make a difference which migrations already applied
        $toApplyMigrations = array_diff($files, $appliedMigrations);

        foreach ($toApplyMigrations as $migration) {
            // Ignore the . and ..
            if ($migration === "." || $migration === "..") {
                continue;
            }

            // Import the migration files
            require_once Application::$ROOT_DIR . "/migrations/" . $migration;

            // Take the file name and alter it into an instance of class, then run the up() method
            $className = pathinfo($migration, PATHINFO_FILENAME);
            $instance = new $className();
            $this->log("Trying to apply the '$migration' migration!");
            $instance->up();
            $this->log("'$migration' was applied!\n");
            $newMigrations[] = $migration;
        }

        // Save the migrations if not empty
        if (!empty($newMigrations)) {
            $this->saveMigrations($newMigrations);
        } else {
            // Otherwise, log a message
            $this->log("All migrations were applied.");
        }
    }

    // Creating the imigrations table
    public function createMigrationsTable()
    {
        // If there were already migrations, then just leave it (not replace)
        $this->pdo->exec("CREATE TABLE IF NOT EXISTS migrations (
            id INT AUTO_INCREMENT PRIMARY KEY,
            migration VARCHAR(255),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=INNODB;");
    }

    // Get migrations from the table migrations
    public function getAppliedMigration()
    {
        // SQL and execute
        $statement = $this->pdo->prepare("SELECT migration FROM migrations");
        $statement->execute();

        // Return an array of selected migrations
        return $statement->fetchAll(\PDO::FETCH_COLUMN);
    }

    // Save migrations
    public function saveMigrations(array $newMigrations)
    {
        // Split the array into string
        $str = implode(',', array_map(fn ($m) => "('$m')", $newMigrations));

        // SQL and execute
        $statement = $this->pdo->prepare("INSERT INTO migrations (migration) VALUES 
            $str
        ");
        $statement->execute();
    }

    // PDO's prepare
    public function prepare($sql)
    {
        return $this->pdo->prepare($sql);
    }

    // Debugging
    protected function log($message)
    {
        echo "[" . date("Y-m-d H:i:s") . "] - " . $message . PHP_EOL;
    }
}