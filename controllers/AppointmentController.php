<?php 

namespace Controllers;

use MVC\Router;

class AppointmentController {
    public static function index(Router $router) {

        $router->render("appointments/index", [
            "fullName" => $_SESSION["fullName"]
        ]);
    }
}