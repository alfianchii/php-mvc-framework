<?php

namespace app\core;

class View
{
    // The title of page
    public string $title = "";

    // VIEWS
    // Render layouts + views
    public function renderView($view, $params = [])
    {
        // Render the view first
        $viewContent = $this->renderOnlyView($view, $params);
        // Then render the layout
        $layoutContent = $this->layoutContent();

        // Replace the {{content}} inside $layoutContent, with $viewContent
        return str_replace("{{content}}", $viewContent, $layoutContent);
    }

    // Render the content (not file)
    public function renderContent($viewContent)
    {
        // Take the layout of content
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
        // Iterates the params
        foreach ($params as $key => $value) {
            // Populates the $key into name of a variable using $$
            $$key = $value;
        }

        ob_start();
        include_once Application::$ROOT_DIR . "/views/$view.php";
        return ob_get_clean();
    }
}