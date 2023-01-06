<?php

namespace app\controllers;

use app\core\{Application, Controller, Request};
use app\models\User;

class AuthController extends Controller
{
    /* Controller's methods */
    // [AuthController::class, "login"]
    public function login()
    {
        // Set auth layout
        $this->setLayout("auth");

        // Return layouts + views
        return $this->render("login");
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
}