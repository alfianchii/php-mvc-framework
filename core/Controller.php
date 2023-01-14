<?php

namespace app\core;

use app\core\middlewares\BaseMiddleware;

class Controller
{
    // Whether the layout is auth.php or main.php (default)
    public string $layout = "main";
    // For set the middleware
    public string $action = '';

    // This is not just an array, but it's an array of BaseMiddleware's class.
    /**
     * @var \app\core\middlewares\BaseMiddleware[]
     */
    protected array $middlewares = [];

    // Set the $layout property
    public function setLayout($layout)
    {
        $this->layout = $layout;
    }

    // Render layouts + views
    public function render($view, $params = [])
    {
        return Application::$app->view->renderView($view, $params);
    }

    // Register the middleware
    public function registerMiddleware(BaseMiddleware $middleware)
    {
        $this->middlewares[] = $middleware;
    }

    // Get middlewares
    public function getMiddlewares(): array
    {
        return $this->middlewares;
    }
}