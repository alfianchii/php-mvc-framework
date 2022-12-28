<?php

namespace app\core;

abstract class Model
{
    public const RULE_REQUIRED = "required";
    public const RULE_EMAIL = "email";
    public const RULE_MIN = "min";
    public const RULE_MAX = "max";
    public const RULE_MATCH = "match";

    // Load all of inputs; $data was an result of getBody(): array
    public function loadData($data)
    {
        // Iterates every attributes (firstname, lastname, etc)
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
    }

    // EVERY MODEL WOULD HAVE THEIR OWN RULES
    abstract public function rules(): array;

    // Would contains all of the error(s)
    public array $errors = [];

    // VALIDATE THE INPUTS
    public function validate()
    {
        // ITERATES EVERY RULE'S ATTRIBUTES
        foreach ($this->rules() as $attribute => $rules) {
            // ACCESS THE VALUES OF EVERY ATTRIBUTE
            $value = $this->{$attribute};

            /* ITERATES EVERY RULE'S NAME. For example :
            required: as a STRING or [self::RULE_MATCH, "match" => "password"] as an ARRAY */
            foreach ($rules as $rule) {
                $ruleName = $rule;

                // If the rules was an ARRAY, just take the [0].
                // It means, take the actual rule's name
                if (!is_string($ruleName)) {
                    $ruleName = $rule[0];
                }

                // VALIDATE THE REQUIRED: if the values doesn't exist ...
                if ($ruleName === self::RULE_REQUIRED && !$value) {
                    /* ADD KIND OF ERRORS
                    $attribute will just contain attributes that were in error.
                    If you don't fill out the firstname, for example, then
                    the firstname will be at $attribute.
                    */
                    $this->addError($attribute, self::RULE_REQUIRED);
                }

                // VALIDATE THE EMAIL: if not the valid email ...
                if ($ruleName === self::RULE_EMAIL && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    // Add an error at attribute of email
                    $this->addError($attribute, self::RULE_EMAIL);
                }

                // VALIDATE THE MIN (minimum value): if the $value is less than $min's value ...
                if ($ruleName === self::RULE_MIN && strlen($value) < $rule["min"]) {
                    // Then ddd an error
                    $this->addError($attribute, self::RULE_MIN, $rule);
                }

                // VALIDATE THE MAX (maximum value): if the $value is more than $max's value ...
                if ($ruleName === self::RULE_MAX && strlen($value) > $rule["max"]) {
                    // Then ddd an error with passing the whole $rule
                    $this->addError($attribute, self::RULE_MAX, $rule);
                }

                // VALIDATE THE MATCH: if the $value doesn't equal to password ...
                // The $this->{$rule["match"]} is the attribute name, in this case, password.
                if ($ruleName === self::RULE_MATCH && $value !== $this->{$rule["match"]}) {
                    // Then ddd an error with passing the whole $rule

                    // echo '<pre>';
                    // var_dump($this->{$rule["match"]});
                    // var_dump($value);
                    // echo '</pre>';
                    // exit;

                    $this->addError($attribute, self::RULE_MATCH, $rule);
                }
            }
        }

        // If the $errors empty, return true. And vice versa.
        return empty($this->errors);
    }

    // For add some error (needs $attribute and their $rule)
    public function addError(string $attribute, string $rule, $params = [])
    {
        // TAKE THE ERROR MESSAGE(s)
        $message = $this->errorMessages()[$rule] ?? "";

        // Iterates the $params (rule): [self::RULE_MIN, "min" => 8],
        foreach ($params as $key => $value) {
            $message = str_replace("{{$key}}", $value, $message);
        }

        // Add the error(s)
        $this->errors[$attribute][] = $message;
    }

    // List of error messages
    public function errorMessages()
    {
        return [
            self::RULE_REQUIRED => "This field is required.",
            self::RULE_EMAIL => "This field must be valid email address.",
            self::RULE_MIN => "Min length of this field must be {min}.",
            self::RULE_MAX => "Max length of this field must be {max}.",
            self::RULE_MATCH => "This field must be the same as {match}.",
        ];
    }
}