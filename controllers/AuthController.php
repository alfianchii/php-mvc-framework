<?php

namespace app\controllers;

use app\core\{Controller, Request};

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
        // Set auth layout
        $this->setLayout("auth");

        if ($request->isPost()) {
            // Get data from forms
            $body = $request->getBody();

            return "Handle submitted data.";
        }

        // Return layouts + views
        return $this->render("register");
    }
}