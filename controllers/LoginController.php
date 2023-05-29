<?php 

namespace Controllers;

use Classes\Email;
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
                    // Hash password
                    $user->hashPassword();

                    // Crear token
                    $user->createToken();

                    // Enviamos el email del token
                    $fullName = $user->firstName . " " . $user->lastName;
                    $email = new Email($user->email, $fullName, $user->token);

                    $email->sendEmail();

                    // Creamos el usuario
                    $result = $user->save();

                    if ($result) {
                        header("Location: /createAccountMessage");
                    }

                    // debuguear($user);
                }
            }

        }
        
        $router->render("auth/createAccount", [
            "user" => $user,
            "alerts" => $alerts
        ]);
    }

    public static function confirmAccount(Router $router) {
        $router->render("auth/confirmAccount", []);
    }

    public static function confirmAccountMessage(Router $router) {
        $router->render("auth/confirmAccountMessage", []);
    }
}