<?php

namespace app\models;

use alfianchii\phpmvc\Model;

class ContactForm extends Model
{
    // Properties of contact form
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
            "subject" => "Your Subject",
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
