<?php

namespace app\core;

use app\core\exceptions\NotFoundException;

class Router
{
    // Properties
    protected array $routes = [];
    public Request $request;
    public Response $response;

    // Constructor (when the class was instaced, run this constructor)
    public function __construct(Request $request, Response $response)
    {
        // Fill out the properties
        $this->request = $request;
        $this->response = $response;
    }

    // Set "get" routes
    public function get($path, $callback)
    {
        $this->routes["get"][$path] = $callback;
    }

    // Set "post" routes
    public function post($path, $callback)
    {
        $this->routes["post"][$path] = $callback;
    }

    // Validate the routes
    public function resolve()
    {
        // Take the path, method, and callback
        $path = $this->request->getPath();
        $method = $this->request->method();
        $callback = $this->routes[$method][$path] ?? false;

        // If no $callback, return not found
        if (!$callback) {
            // Throw the NotFoundException
            throw new NotFoundException();
            // return $this->renderContent("<h1>Not found</h1>");
        }

        // If $callback was a string, render Views
        if (is_string($callback)) {
            return Application::$app->view->renderView($callback);
        }

        // If $callback was an array, instance it [controller, method], then set the action
        if (is_array($callback)) {
            // Hey, the $controller variable is an instance of Controller class.
            /** @var \app\core\Controller $controller */

            // Instance
            $controller = new $callback[0]();
            Application::$app->controller = $controller;
            // Take the action
            $controller->action = $callback[1];
            $callback[0] = $controller;

            // Iterates the middlewares, and execute it
            foreach ($controller->getMiddlewares() as $middleware) {
                $middleware->execute();
            }
        }

        // If found, run the callback
        // $this->request argument is for controller's methods
        // such as handleContact() in SiteController.php.
        // And also the $this->response just like the $this->request
        return call_user_func($callback, $this->request, $this->response);
    }
}