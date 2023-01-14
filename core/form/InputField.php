<?php

namespace app\core\form;

use app\core\Model;

class InputField extends BaseField
{
    // Consts
    public const TYPE_TEXT = "text";
    public const TYPE_PASSWORD = "password";
    public const TYPE_NUMBER = "number";

    // Property
    public string $type;

    // Constructor (when the class was instaced, run this constructor)
    public function __construct(Model $model, string $attribute)
    {
        // Set type and run the parent's constructor
        $this->type = self::TYPE_TEXT;
        parent::__construct($model, $attribute);
    }

    // Set type to password
    public function passwordField()
    {
        // Set type to password
        $this->type = self::TYPE_PASSWORD;
        // In register.php, you would like to change the type
        return $this;
    }

    // Set render to input
    public function renderInput(): string
    {
        return sprintf(
            '<input type="%s" name="%s" id="%s" value="%s" class="form-control %s">',
            $this->type,
            $this->attribute,
            $this->attribute,
            $this->model->{$this->attribute},
            $this->model->hasError($this->attribute) ? "is-invalid" : "",
        );
    }
}