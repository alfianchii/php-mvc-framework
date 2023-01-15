<?php

namespace app\models;

use alfianchii\phpmvc\Application;
use alfianchii\phpmvc\Model;

/*
Just to Model, not DbModel. Because it
doesn't map anything to the database.
*/

class LoginForm extends Model
{
    // Properties of login form
    public string $email = "";
    public string $password = "";

    // The rules of LoginForm's model
    public function rules(): array
    {
        return [
            "email" => [self::RULE_REQUIRED, self::RULE_EMAIL],
            "password" => [self::RULE_REQUIRED],
        ];
    }

    // UI friendly of LoginForm's model
    public function labels(): array
    {
        return [
            "email" => "Your Email",
            "password" => "Password",
        ];
    }

    // User's login
    public function login()
    {
        // Search user based on input form login email
        $user = User::findOne(["email" => $this->email]);

        // If no user, throw an error
        if (!$user) {
            $this->addError("email", "User doesn't exist with this email.");
            return false;
        }

        // If user's input password doesn't same with, throw an error
        if (!password_verify($this->password, $user->password)) {
            $this->addError("password", "Password is incorrect.");
            return false;
        }

        // If user was exists and password was correct, pass the user to the login
        return Application::$app->login($user);
    }
}
