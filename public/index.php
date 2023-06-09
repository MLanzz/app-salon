<?php 

require_once __DIR__ . '/../includes/app.php';

use Controllers\AdminController;
use Controllers\APIController;
use Controllers\AppointmentController;
use Controllers\LoginController;
use MVC\Router;

$router = new Router();

// Iniciar y cerrar sesion
$router->get("/", [LoginController::class, "login"]);
$router->post("/", [LoginController::class, "login"]);
$router->get("/logout", [LoginController::class, "logout"]);

// Recuperar password
$router->get("/forgotPassword", [LoginController::class, "forgotPassword"]);
$router->post("/forgotPassword", [LoginController::class, "forgotPassword"]);
$router->get("/resetPassword", [LoginController::class, "resetPassword"]);
$router->post("/resetPassword", [LoginController::class, "resetPassword"]);

// Crear cuenta
$router->get("/createAccount", [LoginController::class, "createAccount"]);
$router->post("/createAccount", [LoginController::class, "createAccount"]);

// Confirmar cuenta
$router->get("/confirmAccountMessage", [LoginController::class, "confirmAccountMessage"]);
$router->get("/confirmAccount", [LoginController::class, "confirmAccount"]);

// Paginas que necesitan autenticación
$router->get("/appointments", [AppointmentController::class, "index"]);

// Paginas solo para admins
$router->get("/admin", [AdminController::class, "index"]);
$router->post("/admin", [AdminController::class, "index"]);

// API de citas
$router->get("/api/services", [APIController::class, "index"]);
$router->post("/api/appointments", [APIController::class, "save"]);
$router->post("/api/appointmentDetails", [APIController::class, "appointmentDetails"]);
$router->post("/api/deleteAppointment", [APIController::class, "delete"]);

// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();