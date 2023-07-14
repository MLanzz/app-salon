<?php 

namespace Controllers;

use Model\Service;
use MVC\Router;

class ServiceController {
    public static function index(Router $router) {

        $services = Service::all();

        $router->render("services/index", [
            "fullName" => $_SESSION["fullName"],
            "services" => $services
        ]);
    }
}