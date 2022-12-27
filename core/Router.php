<?php
// The namespace
namespace app\core;

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
            // Throw the status code and visit _404.php
            $this->response->setStatusCode(404);
            return $this->renderView("_404");
            // return $this->renderContent("<h1>Not found</h1>");
        }

        // If string, render Views
        if (is_string($callback)) {
            return $this->renderView($callback);
        }

        // If array, instance it [controller, method]
        if (is_array($callback)) {
            Application::$app->controller = new $callback[0]();
            $callback[0] = Application::$app->controller;
        }

        // If found, run the callback
        // $this->request argument is for controller's methods
        // such as handleContact() in SiteController.php
        return call_user_func($callback, $this->request);
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
        $layout = Application::$app->controller->layout;

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