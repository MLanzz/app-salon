<?php 

namespace Controllers;

use Model\AdminAppointment;
use MVC\Router;

class AdminController {
    public static function index(Router $router) {
        
        isAdmin();

        $appointmentDate = date("Y-m-d");

        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $appointmentId = $_POST["appointmentId"] === "" ? null : $_POST["appointmentId"];
            $appointmentDate = $_POST["appointmentDate"] === "" ? date("Y-m-d") : $_POST["appointmentDate"];
            $appointmentUser = $_POST["appointmentUser"] === "" ? null : $_POST["appointmentUser"];
            $appointmentEmail = $_POST["appointmentEmail"] === "" ? null : $_POST["appointmentEmail"];
        }

        if (isMobile()) {
            $query = "SELECT  
                        a.id AS appointmentId, 
                        CONCAT(DATE_FORMAT(a.appointmentDate, '%d/%m/%Y'), ' ', a.appointmentTime) AS appointmentDate, 
                        CONCAT(u.firstName, ' ', u.lastName) AS fullName,
                        u.email,
                        a.appointmentTotal,
                        s.id as serviceId,
                        s.serviceName,
                        s.price as servicePrice
                    FROM appointments a 
                    INNER JOIN users u
                    ON u.id = a.userId 
                    LEFT JOIN appointmentsServices as2
                    ON as2.appointmentId = a.id 
                    LEFT JOIN services s 
                    ON s.id = as2.serviceId ";
        } else {
            $query = "SELECT  
                a.id AS appointmentId, 
                CONCAT(DATE_FORMAT(a.appointmentDate, '%d/%m/%Y'), ' ', a.appointmentTime) AS appointmentDate, 
                CONCAT(u.firstName, ' ', u.lastName) AS fullName,
                u.email,
                a.appointmentTotal
            FROM appointments a 
            INNER JOIN users u
            ON u.id = a.userId ";
        }

        $query .= " WHERE a.appointmentDate = '{$appointmentDate}'";

        if (isset($appointmentId) || isset($appointmentUser) || isset($appointmentEmail)) {
            if ($appointmentUser) {
                $query .= " AND CONCAT(u.firstName, ' ', u.lastName) LIKE '%{$appointmentUser}%'";
            }

            if ($appointmentEmail) {
                $query .= " AND u.email LIKE '%{$appointmentEmail}%'";
            }

            if ($appointmentId) {
                $query .= " AND a.id = {$appointmentId}";
            }
        }

        $appointments = AdminAppointment::querySQL($query);

        $router->render("admin/index", [
            "fullName" => $_SESSION["fullName"],
            "appointments" => $appointments,
            "appointmentDate" => $appointmentDate,
            "appointmentId" => $appointmentId ?? "",
            "appointmentUser" => $appointmentUser ?? "",
            "appointmentEmail" => $appointmentEmail ?? ""
        ]);
    }
}