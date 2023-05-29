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
        $alerts = [];
        if($_SERVER["REQUEST_METHOD"] === "POST") {
            $user->sincronizar($_POST);

            $alerts = $user->validateUser();

            if (empty($alerts)) {
                $alreadyExist = $user->alreadyExist();

                if ($alreadyExist) {
                    $alerts = User::getAlerts();
                } else {
                    //No esta registrado
                }
            }

        } 
        
        $router->render("auth/createAccount", [
            "user" => $user,
            "alerts" => $alerts
        ]);
    }
}