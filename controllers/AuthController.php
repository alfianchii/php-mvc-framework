<?php

namespace app\controllers;

use app\core\{Controller, Request};
use app\models\RegisterModel;

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
        $registerModel = new RegisterModel();

        if ($request->isPost()) {
            // Get the inputs from form, then load it
            $registerModel->loadData($request->getBody());

            // If validation is pass and also created an account, then success
            if ($registerModel->validate() && $registerModel->register()) {
                return "Success";
            }

            // Return layouts + views + errors
            return $this->render("register", [
                "model" => $registerModel
            ]);
        }

        // Set auth layout
        $this->setLayout("auth");

        // Return layouts + views
        return $this->render("register", [
            "model" => $registerModel
        ]);
    }
}