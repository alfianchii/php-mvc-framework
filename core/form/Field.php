<?php

namespace app\core\form;

use app\core\Model;

class Field
{
    // Const(s)
    public const TYPE_TEXT = "text";
    public const TYPE_PASSWORD = "password";
    public const TYPE_NUMBER = "number";
    // Properties
    public Model $model;
    public string $attribute;
    public string $type;

    // Fill it out the properties
    public function __construct(Model $model, $attribute)
    {
        $this->model = $model;
        $this->attribute = $attribute;
        $this->type = self::TYPE_TEXT;
    }

    // Return the form's field(s)
    public function __toString()
    {
        return sprintf(
            '
            <div class="form-group">
                <label>%s</label>
                <input type="%s" name="%s" value="%s" class="form-control %s">
                <div class="invalid-feedback">
                    %s
                </div>
            </div>
        ',
            $this->attribute,
            $this->type,
            $this->attribute,
            $this->model->{$this->attribute},
            $this->model->hasError($this->attribute) ? "is-invalid" : "",
            $this->model->getFirstError($this->attribute)
        );
    }

    // Set type to password
    public function passwordField()
    {
        $this->type = self::TYPE_PASSWORD;
        // In register.php, you would like to change the type
        return $this;
    }
}