<?php

/** @var $model \app\models\User */

?>

<h1>Login</h1>
<?php $form = \app\core\form\Form::begin("", "POST"); ?>

<?= $form->field($model, "email") ?>
<?= $form->field($model, "password")->passwordField() ?>
<button type="submit" class="btn btn-primary">Submit</button>

<?php \app\core\form\Form::end(); ?>