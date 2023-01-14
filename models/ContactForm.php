<?php

namespace app\models;

use app\core\Model;

class ContactForm extends Model
{
    // Properties of form
    public string $subject = "";
    public string $email = "";
    public string $body = "";

    // The rules of ContactForm's model
    public function rules(): array
    {
        return [
            "subject" => [self::RULE_REQUIRED],
            "email" => [self::RULE_REQUIRED, self::RULE_EMAIL],
            "body" => [self::RULE_REQUIRED],
        ];
    }

    // UI friendly of ContactForm's model
    public function labels(): array
    {
        return [
            "subject" => "Enter Your Subject",
            "email" => "Your Email",
            "body" => "Body",
        ];
    }

    // Send the inputs of contact form
    public function send()
    {
        return true;
    }
}