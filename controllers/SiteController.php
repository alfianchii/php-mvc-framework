<?php

namespace app\controllers;

use app\core\{Application, Controller, Request, Response};
use app\models\ContactForm;

class SiteController extends Controller
{
    // [SiteController::class, "home"]
    public function home()
    {
        // Set the parameters
        $params = [
            "name" => "Alfianchii"
        ];

        // Return layouts + views
        return $this->render("home", $params);
    }

    // [SiteController::class, "contact"]
    public function contact()
    {
        // Return layouts + views
        return $this->render("contact");
    }
}