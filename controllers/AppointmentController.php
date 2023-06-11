<?php 

namespace Controllers;

use MVC\Router;

class AppointmentController {
    public static function index(Router $router) {

        isAuth();

        $router->render("appointments/index", [
            "fullName" => $_SESSION["fullName"],
            "userId" => $_SESSION["id"],
        ]);
    }
}