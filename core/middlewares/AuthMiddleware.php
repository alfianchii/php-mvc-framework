<?php

namespace app\core\middlewares;

use app\core\Application;
use app\core\exceptions\ForbiddenException;

class AuthMiddleware extends BaseMiddleware
{
    public array $actions = [];

    public function __construct(array $actions = [])
    {
        $this->actions = $actions;
    }

    public function execute()
    {
        if (Application::isGuest()) {
            // If actions were empty or there was action in the current action
            if (empty($this->actions) || in_array(Application::$app->controller->action, $this->actions)) {
                // Throw error
                throw new ForbiddenException();
            }
        }
    }
}