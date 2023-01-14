<?php

// Annotating
/** @var $name \app\controllers\SiteController */

use app\core\Application;

// Set the title of home page
$this->title = "Home";

?>

<h1>Home</h1>

<?php if (Application::isGuest()) : ?>
<h3>Welcome!</h3>
<?php else : ?>
<h3>Welcome, <?= $name ?>!</h3>
<?php endif; ?>