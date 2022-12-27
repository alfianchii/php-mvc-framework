<?php

namespace app\core;

class Controller
{
    // Whether the layout is auth.php or main.php (default)
    public string $layout = "main";

    // Set the $layout property
    public function setLayout($layout)
    {
        $this->layout = $layout;
    }

    // Render layouts + views
    public function render($view, $params = [])
    {
        return Application::$app->router->renderView($view, $params);
    }
}