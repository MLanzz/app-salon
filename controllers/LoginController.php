<?php 

namespace Controllers;

use Classes\Email;
use Model\User;
use MVC\Router;

class LoginController {
    public static function login(Router $router) {

        $alerts = [];

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $auth = new User($_POST);

            $alerts = $auth->validateLogin();

            if(!$alerts) {

                $userExist = User::where("email", $auth->email);

                if($userExist) {
                    debuguear($userExist->isConfirmed);
                    if($userExist->isConfirmed) {
                        $login = $userExist->checkPassword($auth->password);
                    } else {
                        $alerts["errors"][] = "El usuario no esta confirmado";
                    }
                } else {
                    $alerts["errors"][] = "Usuario no encontrado";
                }

                // $auth->login();
            }
        }

        $router->render("auth/login", [
            "alerts" => $alerts
        ]);
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
                        header("Location: /confirmAccountMessage");
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
        $alerts = [];

        $token = s($_GET["token"]);

        $user = User::where('token', $token);

        if ($user) {
            $user->token = '';
            $user->isConfirmed = 1;

            $user->update();
            
            $alerts['success'][] = "Cuenta confirmada correctamente";
        } else {
            $alerts['errors'][] = "El token de confirmación no es valido";
        }
        
        $router->render("auth/confirmAccount", [
            "alerts" => $alerts
        ]);
    }

    public static function confirmAccountMessage(Router $router) {
        $router->render("auth/confirmAccountMessage", []);
    }
}