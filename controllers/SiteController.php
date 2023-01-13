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
    public function contact(Request $request, Response $response)
    {
        $contact = new ContactForm();

        if ($request->isPost()) {
            $contact->loadData($request->getBody());

            if ($contact->validate() && $contact->send()) {
                Application::$app->session->setFlash("success", "Thanks for contacting us!");
                return $response->redirect("/contact");
            }
        }

        // Return layouts + views
        return $this->render("contact", [
            "model" => $contact
        ]);
    }
}