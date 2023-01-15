<?php

use alfianchii\phpmvc\Application;

class m0002_add_password_column
{
    // Create the password field
    public function up()
    {
        $db = Application::$app->db;
        $db->pdo->exec("ALTER TABLE users ADD COLUMN password VARCHAR(512) NOT NULL");
    }

    // Drop the password field
    public function down()
    {
        $db = Application::$app->db;
        $db->pdo->exec("ALTER TABLE users ADD COLUMN password;");
    }
}
