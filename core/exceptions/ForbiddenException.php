<?php

namespace app\core\exceptions;

class ForbiddenException extends \Exception
{
    // Override the $message and $code
    protected $message = "You don't have permission to access this page.";
    protected $code = 403;
}