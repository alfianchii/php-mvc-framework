<?php

namespace app\controllers;

use app\core\{Application, Controller, Request, Response};
use app\models\{User, LoginForm};

class AuthController extends Controller
{
    /* Controller's methods */
    // [AuthController::class, "login"]
    public function login(Request $request, Response $response)
    {
        $loginForm = new LoginForm();

        // When user trying to login ...
        if ($request->isPost()) {
            $loginForm->loadData($request->getBody());

            if ($loginForm->validate() && $loginForm->login()) {
                $response->redirect("/");
                return;
            }
        }

        // Set auth layout
        $this->setLayout("auth");

        // Return layouts + views
        return $this->render("login", [
            "model" => $loginForm
        ]);
    }

    // [AuthController::class, "register"]
    public function register(Request $request)
    {
        $user = new User();

        if ($request->isPost()) {
            // Get the inputs from form, then load it
            $user->loadData($request->getBody());

            // If validation is pass and also created an account,
            // then set the flash and redirect it to home
            if ($user->validate() && $user->save()) {
                Application::$app->session->setFlash("success", "Thanks for registering!");
                Application::$app->response->redirect("/");
                exit;
            }

            // Return layouts + views + errors
            return $this->render("register", [
                "model" => $user
            ]);
        }

        // Set auth layout
        $this->setLayout("auth");

        // Return layouts + views
        return $this->render("register", [
            "model" => $user
        ]);
    }

    // [AuthController::class, "logout"]
    public function logout(Request $request, Response $response)
    {
        Application::$app->logout();
        $response->redirect("/");
    }
}