<?php

namespace app\core\middlewares;

use app\core\Application;
use app\core\exceptions\ForbiddenException;

class AuthMiddleware extends BaseMiddleware
{
    // To accomodates registered actions
    public array $actions = [];

    // Constructor (when the class was instaced, run this constructor)
    public function __construct(array $actions = [])
    {
        // Set the actions
        $this->actions = $actions;
    }

    // Execute the middleware
    public function execute()
    {
        // If the user was guest,
        if (Application::isGuest()) {
            // If actions were empty or there was action in the current action
            // And there was no "actions" or action behinds the "actions"
            if (empty($this->actions) || in_array(Application::$app->controller->action, $this->actions)) {
                // Throw Forbidden
                throw new ForbiddenException();
            }
        }
    }
}