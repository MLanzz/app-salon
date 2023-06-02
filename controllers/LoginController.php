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
    
    public static function resetPassword(Router $router) {
        $alerts = [];
        $invalidToken = false;
        $token = s($_GET["token"]);

        $user = User::where("token", $token);

        if (!$user){
            $invalidToken = true;
            $alerts["errors"][] = "Token invalido";
        }

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $newPassword = new User($_POST);

            if(!$newPassword->password) {
                $alerts["errors"][] = "La contraseña es obligatoria";
            } elseif (strlen($newPassword->password) < 6) {
                $alerts["errors"][] = "La contraseña debe tener un minimo de 6 caracteres";
            }

            if (!$alerts) {
                $user->password = $newPassword->password;
                $user->hashPassword();
                $user->token = "";

                $result = $user->update();

                if($result) {
                    header("Location: /");
                }

                
            }
        }

        $router->render("auth/resetPassword", [
            "alerts" => $alerts,
            "invalidToken" => $invalidToken
        ]);
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