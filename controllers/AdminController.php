<?php 

namespace Controllers;

use Model\AdminAppointment;
use MVC\Router;

class AdminController {
    public static function index(Router $router) {
        
        isAdmin();

        // SELECT  
        //     a.id AS appointmentId, 
        //     concat(a.appointmentDate, ' ', a.appointmentTime) AS appointmentDate, 
        //     CONCAT(u.firstName, ' ', u.lastName) AS fullName,
        //     u.email,
        //     s.serviceName,
        //     s.price 
        // FROM appointments a 
        // INNER JOIN appointmentsServices aps
        // ON aps.appointmentId = a.id
        // INNER JOIN users u
        // ON u.id = a.userId
        // LEFT JOIN services s 
        // ON s.id = aps.serviceId

        $query = "SELECT  
            a.id AS appointmentId, 
            concat(a.appointmentDate, ' ', a.appointmentTime) AS appointmentDate, 
            CONCAT(u.firstName, ' ', u.lastName) AS fullName,
            u.email
        FROM appointments a 
        INNER JOIN users u
        ON u.id = a.userId ";
        
        $appointments = AdminAppointment::querySQL($query);

        $router->render("admin/index", [
            "fullName" => $_SESSION["fullName"],
            "appointments" => $appointments
        ]);
    }
}