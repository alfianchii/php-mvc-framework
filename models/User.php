<?php

namespace app\models;

use alfianchii\phpmvc\UserModel;

class User extends UserModel
{
    // Const "status" field
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_DELETED = 2;

    // Create variables which later would contains the form's name attribute
    public string $firstname = "";
    public string $lastname = "";
    public string $email = "";
    public int $status = self::STATUS_INACTIVE;
    public string $password = "";
    public string $confirmPassword = "";

    // Define the table's name of User's model
    public static function tableName(): string
    {
        return "users";
    }

    // Implement primaryKey's method of User's model
    public static function primaryKey(): string
    {
        return "id";
    }

    // The rules of User's model
    public function rules(): array
    {
        return [
            "firstname" => [self::RULE_REQUIRED],
            "lastname" => [self::RULE_REQUIRED],
            "email" => [self::RULE_REQUIRED, self::RULE_EMAIL, [
                self::RULE_UNIQUE, "class" => self::class
            ]],
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

    // UI friendly of User's model
    public function labels(): array
    {
        return [
            "firstname" => "First name",
            "lastname" => "Last name",
            "email" => "Email",
            "password" => "Password",
            "confirmPassword" => "Confirm password",
        ];
    }

    // Set the attributes of User's model
    public function attributes(): array
    {
        return ["firstname", "lastname", "email", "password", "status"];
    }

    // Register the inputs into database
    public function save()
    {
        $this->status = self::STATUS_INACTIVE;
        // Password encryption
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        return parent::save();
    }

    // Get user's name
    public function getDisplayName(): string
    {
        return $this->firstname . " " . $this->lastname;
    }
}
