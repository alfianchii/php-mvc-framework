<?php

namespace app\core\middlewares;

abstract class BaseMiddleware
{
    // Every middlewares would have its own execute
    abstract public function execute();
}