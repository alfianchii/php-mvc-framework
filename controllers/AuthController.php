<?php

namespace app\controllers;

use app\core\{Application, Controller, Request, Response};
use app\core\middlewares\AuthMiddleware;
use app\models\{User, LoginForm};

class AuthController extends Controller
{
    // Constructor (when the class was instaced, run this constructor)
    // Restrict a page with middlewares
    public function __construct()
    {
        // Restrict the "profile" page
        $this->registerMiddleware(new AuthMiddleware(["profile"]));
    }

    /* Controller's methods */
    // [AuthController::class, "login"]
    public function login(Request $request, Response $response)
    {
        // Instances LoginForm.php model
        $loginForm = new LoginForm();

        // If the request was POST,
        if ($request->isPost()) {
            // Load inputs from the form
            $loginForm->loadData($request->getBody());

            // Validate and login
            if ($loginForm->validate() && $loginForm->login()) {
                Application::$app->session->setFlash("success", "Login was success!");
                // Then redirect to "/"
                return $response->redirect("/");
            }
        }

        // Otherwise, just set auth layout
        $this->setLayout("auth");

        // And eturn layouts + views
        return $this->render("login", [
            "model" => $loginForm
        ]);
    }

    // [AuthController::class, "register"]
    public function register(Request $request, Response $response)
    {
        // Instances User.php model
        $user = new User();

        // If the request was POST,
        if ($request->isPost()) {
            // Load inputs from the form
            $user->loadData($request->getBody());

            // Validate and save
            if ($user->validate() && $user->save()) {
                // Then set the flash and redirect it to home
                Application::$app->session->setFlash("success", "Thanks for registering!");
                return $response->redirect("/");
            }

            // Return layouts + views + errors
            return $this->render("register", [
                "model" => $user
            ]);
        }

        // Otherwise, just set auth layout
        $this->setLayout("auth");

        // Return layouts + views
        return $this->render("register", [
            "model" => $user
        ]);
    }

    // [AuthController::class, "logout"]
    public function logout(Request $request, Response $response)
    {
        // Remove user's session and redirect to home "/"
        Application::$app->logout();
        $response->redirect("/");
    }

    // [AuthController::class, "profile"]
    public function profile()
    {
        // Render profile.php
        return $this->render('profile');
    }
}