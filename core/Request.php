<?php

namespace app\core;

class Request
{
    // Get the url path
    public function getPath()
    {
        // Get path from REQUEST_URI. i.e, "/contact" or "/" if nothing else in url
        $path = $_SERVER["REQUEST_URI"] ?? "/";
        $position = strpos($path, "?");

        if ($position === false) {
            // return "/"
            return $path;
        }

        // i.e "/contact" without the params (?id=1)
        return substr($path, 0, $position);
    }

    // Getting the request method, for example, get
    public function method()
    {
        return strtolower($_SERVER["REQUEST_METHOD"]);
    }

    // Boolean; if the method() is get, then return true
    public function isGet()
    {
        return $this->method() === "get";
    }

    // Boolean; if the method() is post, then return true
    public function isPost()
    {
        return $this->method() === "post";
    }

    // Get the data from url (get) or form (post)
    public function getBody()
    {
        $body = [];

        if ($this->method() === "get") {
            foreach ($_GET as $key => $value) {
                // Remove some invalid characters
                $body[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }

        if ($this->method() === "post") {
            foreach ($_POST as $key => $value) {
                // Remove some invalid characters
                $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }

        return $body;
    }
}