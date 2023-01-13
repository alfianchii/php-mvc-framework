<?php

namespace app\core;

class View
{
    // VIEWS
    // Render layouts + views
    public function renderView($view, $params = [])
    {
        // Render the view
        $viewContent = $this->renderOnlyView($view, $params);
        // Render the layout
        $layoutContent = $this->layoutContent();

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