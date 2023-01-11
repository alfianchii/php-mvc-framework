<?php
// The namespace
namespace app\core;

use app\core\exceptions\NotFoundException;

class Router
{
    // Properties
    protected array $routes = [];
    public Request $request;
    public Response $response;

    public function __construct(Request $request, Response $response)
    {
        // Fill out the properties
        $this->request = $request;
        $this->response = $response;
    }

    /*
    Methods
    */
    // Set get routes
    public function get($path, $callback)
    {
        $this->routes["get"][$path] = $callback;
    }

    // Set post routes
    public function post($path, $callback)
    {
        $this->routes["post"][$path] = $callback;
    }

    // Validate the routes
    public function resolve()
    {
        $path = $this->request->getPath();
        $method = $this->request->method();
        // Find the callback
        $callback = $this->routes[$method][$path] ?? false;

        // If false, return not found
        if (!$callback) {
            // Throw the NotFoundException
            throw new NotFoundException();
            // return $this->renderContent("<h1>Not found</h1>");
        }

        // If string, render Views
        if (is_string($callback)) {
            return $this->renderView($callback);
        }

        // If array, instance it [controller, method]
        if (is_array($callback)) {
            // Hey, the controller variable is an instance of Controller class.
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

    // VIEWS
    // Render layouts + views
    public function renderView($view, $params = [])
    {
        $layoutContent = $this->layoutContent();
        $viewContent = $this->renderOnlyView($view, $params);

        // Replace the {{content}} inside $layoutContent, with $viewContent
        return str_replace("{{content}}", $viewContent, $layoutContent);
    }

    // Render the content (not file)
    public function renderContent($viewContent)
    {
        $layoutContent = $this->layoutContent();

        // Replace the {{content}} inside $layoutContent, with $viewContent
        return str_replace("{{content}}", $viewContent, $layoutContent);
    }

    // Render layouts
    protected function layoutContent()
    {
        // By default, the layout will be "main"
        $layout = Application::$app->layout;

        // But if the controller was exists, take the layout from the controller
        if (Application::$app->controller) {
            $layout = Application::$app->controller->layout;
        }

        ob_start();
        include_once Application::$ROOT_DIR . "/views/layouts/$layout.php";
        return ob_get_clean();
    }

    // Render views
    protected function renderOnlyView($view, $params)
    {
        foreach ($params as $key => $value) {
            $$key = $value;
        }

        ob_start();
        include_once Application::$ROOT_DIR . "/views/$view.php";
        return ob_get_clean();
    }
}