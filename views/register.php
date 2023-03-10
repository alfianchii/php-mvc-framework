<?php

// Annotate
/** @var $model \app\models\User */

// Set title of register page
$this->title = "Register";

?>

<section class="mt-5">
    <h1 class="mb-3">Create an account</h1>

    <?php $form = \alfianchii\phpmvc\form\Form::begin("", "POST"); ?>

    <div class="row">
        <div class="col">
            <?= $form->field($model, "firstname") ?>
        </div>
        <div class="col">
            <?= $form->field($model, "lastname") ?>
        </div>
    </div>

    <?= $form->field($model, "email") ?>
    <?= $form->field($model, "password")->passwordField() ?>
    <?= $form->field($model, "confirmPassword")->passwordField() ?>
    <button type="submit" class="btn btn-primary">Submit</button>

    <?php \alfianchii\phpmvc\form\Form::end(); ?>
</section>