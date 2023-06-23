<?php 

namespace Controllers;

use Model\AdminAppointment;
use MVC\Router;

class AdminController {
    public static function index(Router $router) {
        
        isAdmin();

        $date = date("Y-m-d");

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $date = $_POST["appointmentDate"] === "" ? date("Y-m-d") : $_POST["appointmentDate"];
        }

        $query = "SELECT  
            a.id AS appointmentId, 
            concat(a.appointmentDate, ' ', a.appointmentTime) AS appointmentDate, 
            CONCAT(u.firstName, ' ', u.lastName) AS fullName,
            u.email,
            a.appointmentTotal
        FROM appointments a 
        INNER JOIN users u
        ON u.id = a.userId ";
        // -- WHERE appointmentDate = '{$date}'";
        
        $appointments = AdminAppointment::querySQL($query);

        $router->render("admin/index", [
            "fullName" => $_SESSION["fullName"],
            "appointments" => $appointments,
            "date" => $date
        ]);
    }
}