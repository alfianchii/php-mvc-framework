<?php

namespace app\controllers;

use app\core\{Controller, Request};

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

    // [SiteController::class, "handleContact"]
    public function handleContact(Request $request)
    {
        // Get data from forms
        $body = $request->getBody();

        return "Handling submitted data.";
    }
}