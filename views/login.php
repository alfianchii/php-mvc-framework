<?php

// Annotate
/** @var $model \app\models\User */

// Set title of login page
$this->title = "Login";

?>

<section class="mt-5">
    <h1 class="mb-3">Login</h1>
    <?php $form = \alfianchii\phpmvc\form\Form::begin("", "POST"); ?>

    <?= $form->field($model, "email") ?>
    <?= $form->field($model, "password")->passwordField() ?>
    <button type="submit" class="btn btn-primary">Submit</button>

    <?php \alfianchii\phpmvc\form\Form::end(); ?>
</section>