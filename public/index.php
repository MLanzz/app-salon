<?php 

require_once __DIR__ . '/../includes/app.php';

use Controllers\AdminController;
use Controllers\APIController;
use Controllers\AppointmentController;
use Controllers\LoginController;
use Controllers\ServiceController;
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

// Servicios
$router->get("/services", [ServiceController::class, "index"]);


// API de citas
$router->get("/api/getServices", [APIController::class, "getServices"]); // Listado de servicios
$router->post("/api/saveAppointment", [APIController::class, "saveAppointment"]); // Guardado de cita
$router->post("/api/getAppointmentDetails", [APIController::class, "getAppointmentDetails"]); // Detalles de una cita
$router->post("/api/deleteAppointment", [APIController::class, "deleteAppointment"]); // Borrado de una cita

$router->post("/api/saveService", [APIController::class, "saveService"]); // Guardado (creación/borrado) de un servicio
$router->post("/api/deleteService", [APIController::class, "deleteService"]); // Borrado de una cita



// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();