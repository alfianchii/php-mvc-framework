<?php

namespace app\core\form;

use app\core\Model;

abstract class BaseField
{
    // Properties
    public Model $model;
    public string $attribute;

    // Fill it out the properties
    public function __construct(Model $model, $attribute)
    {
        $this->model = $model;
        $this->attribute = $attribute;
    }

    // For the field. For example: textarea, input, etc.
    abstract public function renderInput(): string;

    // Return the form's field(s)
    public function __toString()
    {
        return sprintf(
            '
            <div class="form-group">
                <label>%s</label>
                %s
                <div class="invalid-feedback">
                    %s
                </div>
            </div>
        ',
            $this->model->getLabel($this->attribute),
            $this->renderInput(),
            $this->model->getFirstError($this->attribute)
        );
    }
}