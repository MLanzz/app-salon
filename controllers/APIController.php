<?php 

namespace Controllers;

use Model\Appointment;
use Model\AppointmentService;
use Model\Service;

class APIController {
    public static function index() {
        $services = Service::all();

        echo json_encode($services);
        
    }

    public static function save() {

        $appointment = new Appointment($_POST); 
        $result = $appointment->save(); // Guardamos la cita
        $appointmentId = $result["id"]; // Obtenemos el id de la cita insertado/guardado

        $servicesIds = explode(",", $_POST["servicesIds"]);

        foreach ($servicesIds as $serviceId) { // Recorremos los servicios y guardamos la relación con la cita
            $appointmentService = new AppointmentService([
                "serviceId" => $serviceId,
                "appointmentId" => $appointmentId
            ]);

            $appointmentService->save();
            
        }

        $response = [
            "result" => $result,
            "appointment" => $appointment
        ];

        echo json_encode($response);
    }

    public static function appointmentDetails() {

        $appointmentId = $_POST["appointmentId"] ?? 0;

        $query = "
            SELECT
                as2.id,
                as2.appointmentId,
                as2.serviceId,
                s.serviceName,
                s.price
            FROM appointmentsServices as2 
            INNER JOIN services s
            on s.id = as2.serviceId
            WHERE as2.appointmentId = {$appointmentId}
            ORDER BY as2.id DESC
        ";

        $appointmentServices = AppointmentService::querySQL($query);

        $response = [
            "appointmentServices" => $appointmentServices
        ];
        
        echo json_encode($response);
    }
}