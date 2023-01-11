<?php

namespace app\core\middlewares;

abstract class BaseMiddleware
{
    // Execute the middlewares
    abstract public function execute();
}