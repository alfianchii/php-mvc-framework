<?php

/** @var $this \app\core\View */
/** @var $model \app\models\ContactForm */

use app\core\form\TextareaField;

// Set the title of contact page
$this->title = "Contact";

?>

<h1>Contact us</h1>

<?php $form = \app\core\form\Form::begin("", "POST") ?>

<?= $form->field($model, "subject") ?>
<?= $form->field($model, "email") ?>
<?= new TextareaField($model, "body") ?>
<button type="submit" class="btn btn-primary">Submit</button>

<?php \app\core\form\Form::end(); ?>