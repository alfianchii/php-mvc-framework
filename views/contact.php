<?php

// Annotatings
/** @var $this \alfianchii\phpmvc\View */
/** @var $model \app\models\ContactForm */

use alfianchii\phpmvc\form\TextareaField;

// Set the title of contact page
$this->title = "Contact";

?>

<h1 class="mb-3">Contact us</h1>

<?php $form = \alfianchii\phpmvc\form\Form::begin("", "POST") ?>

<?= $form->field($model, "subject") ?>
<?= $form->field($model, "email") ?>
<?= new TextareaField($model, "body") ?>
<button type="submit" class="btn btn-primary">Submit</button>

<?php \alfianchii\phpmvc\form\Form::end(); ?>