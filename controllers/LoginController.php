<?php 

namespace Controllers;

use MVC\Router;

class LoginController {
    public static function login(Router $router) {
        $router->render("auth/login");
    }

    public static function logout() {
        echo "Desde logout";
    }

    public static function forgotPassword(Router $router) {
        $router->render("auth/forgotPassword", [

        ]);
    }
    
    public static function resetPassword() {
        echo "Desde resetPassword";
    }

    public static function createAccount(Router $router) {
        $router->render("auth/createAccount", [

        ]);
    }
}