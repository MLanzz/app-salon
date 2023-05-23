<?php 

namespace Controllers;

use Model\User;
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
        
        $user = new User();
        if($_SERVER["REQUEST_METHOD"] === "POST") {
            $user->sincronizar($_POST);
        } 
        
        $router->render("auth/createAccount", [
            "user" => $user
        ]);
    }
}