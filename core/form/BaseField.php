<?php

namespace app\core\form;

use app\core\Model;

abstract class BaseField
{
    // Properties
    public Model $model;
    public string $attribute;

    // Constructor (when the class was instaced, run this constructor)
    public function __construct(Model $model, $attribute)
    {
        // Fill out the properties
        $this->model = $model;
        $this->attribute = $attribute;
    }

    // For the field. For example: textarea, input, etc.
    abstract public function renderInput(): string;

    // Return the form's field
    public function __toString()
    {
        return sprintf(
            '
            <div class="mb-3">
            <label for="%s" class="form-label">%s</label>
                %s
                <div class="invalid-feedback">
                    %s
                </div>
            </div>
        ',
            $this->attribute,
            $this->model->getLabel($this->attribute),
            $this->renderInput(),
            $this->model->getFirstError($this->attribute)
        );
    }
}