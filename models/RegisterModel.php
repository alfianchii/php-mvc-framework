<?php

namespace app\models;

use app\core\Model;

class RegisterModel extends Model
{
    // Create variables which later would contains the form's name attribute
    public string $firstname;
    public string $lastname;
    public string $email;
    public string $password;
    public string $confirmPassword;

    // The rule
    public function rules(): array
    {
        return [
            "firstname" => [self::RULE_REQUIRED],
            "lastname" => [self::RULE_REQUIRED],
            "email" => [self::RULE_REQUIRED, self::RULE_EMAIL],
            "password" => [
                // String
                self::RULE_REQUIRED,
                // Array
                [self::RULE_MIN, "min" => 8],
                [self::RULE_MAX, "max" => 24],
            ],
            "confirmPassword" => [
                self::RULE_REQUIRED,
                [self::RULE_MATCH, "match" => "password"]
            ],
        ];
    }

    // Register the inputs into database
    public function register()
    {
        echo "Creating new user . . .";
    }
}