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

                $user = User::where("email", $auth->email);

                if($user) {
                    // Verificamos confirmación y contraseña
                    if ($user->checkPasswordAndConfirmed($auth->password)) {
                        // Iniciamos sesion
                        // session_start();
                        $_SESSION["id"] = $user->id;
                        $_SESSION["fullName"] = $user->firstName . " " . $user->lastName;
                        $_SESSION["email"] = $user->email;
                        $_SESSION["login"] = true;
                        
                        if ($user->admin === "1") {
                            $_SESSION["admin"] = $user->admin ?? null;
                            header("Location: /admin");
                        } else {
                            header("Location: /appointments");
                        }
                    } else {
                        $alerts = $user->getAlerts();
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

        $alerts = [];

        if($_SERVER["REQUEST_METHOD"] === "POST") {
            $auth = new User($_POST);

            $user = User::where("email", $auth->email);

            if (!$user || $user->isConfirmed === "0") {
                $alerts["errors"][] = "Debe ingresar un e-mail registrado y confirmado";
            } else {
                $user->createToken();
                $user->update();

                $fullName = $user->firstName . " " . $user->lastName;
                $email = new Email($user->email, $fullName, $user->token);

                $email->sendResetPasswordEmail();

                $alerts["success"][] = "El token para reestablecer la contraseña a sido enviado al e-mail indicado";

            }
        }

        $router->render("auth/forgotPassword", [
            "alerts" => $alerts
        ]);
    }
    
    public static function resetPassword() {
        $token = s($_GET["token"]);
        debuguear($token);
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

                    $email->sendConfirmationEmail();

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