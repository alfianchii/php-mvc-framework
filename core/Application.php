<?php
// The namespace
namespace app\core;

class Application
{
    // Properties
    public static string $ROOT_DIR;
    public static Application $app;
    public Router $router;
    public Request $request;
    public Response $response;
    public Controller $controller;
    public Database $db;

    public function __construct($rootPath, array $config)
    {
        // Fill out the properties
        self::$ROOT_DIR = $rootPath;
        self::$app = $this;
        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router($this->request, $this->response);
        $this->db = new Database($config["db"]);
    }

    /*
        Methods
    */
    // Running the application
    public function run()
    {
        echo $this->router->resolve();
    }

    // Getter and setter
    public function getController(): \app\core\Controller
    {
        return $this->controller;
    }

    public function setController(\app\core\Controller $controller): void
    {
        $this->controller = $controller;
    }
}