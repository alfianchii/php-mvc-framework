<?php

namespace app\core\form;

use app\core\Model;

class InputField extends BaseField
{
    // Const(s)
    public const TYPE_TEXT = "text";
    public const TYPE_PASSWORD = "password";
    public const TYPE_NUMBER = "number";

    // Properties
    public string $type;

    public function __construct(Model $model, string $attribute)
    {
        $this->type = self::TYPE_TEXT;
        parent::__construct($model, $attribute);
    }

    // Set type to password
    public function passwordField()
    {
        $this->type = self::TYPE_PASSWORD;
        // In register.php, you would like to change the type
        return $this;
    }

    // Set render
    public function renderInput(): string
    {
        return sprintf(
            '<input type="%s" name="%s" value="%s" class="form-control %s">',
            $this->type,
            $this->attribute,
            $this->model->{$this->attribute},
            $this->model->hasError($this->attribute) ? "is-invalid" : "",
        );
    }
}