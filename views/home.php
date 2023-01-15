<?php

// Annotating
/** @var $name \app\controllers\SiteController */

use alfianchii\phpmvc\Application;

// Set the title of home page
$this->title = "Home";

?>

<h1 class="mb-3">Home</h1>

<section>
    <?php if (Application::isGuest()) : ?>
        <h3>Welcome!</h3>
    <?php else : ?>
        <h3>Welcome, <?= $name ?>!</h3>
    <?php endif; ?>
</section>