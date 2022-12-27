<?php

namespace app\core;

class Response
{
    // Set the status code
    public function setStatusCode(int $code)
    {
        http_response_code($code);
    }
}