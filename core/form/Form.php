<?php

namespace app\core\form;

use app\core\Model;

class Form
{
    /* FORM'S STRUCTURE: BEGIN, FIELD, END */
    public static function begin($action, $method)
    {
        echo sprintf("<form action='%s' method='%s'>", $action, $method);
        return new Form();
    }

    public function field(Model $model, $attribute)
    {
        return new InputField($model, $attribute);
    }

    public static function end()
    {
        echo "</form>";
    }
}