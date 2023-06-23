<?php 

namespace Controllers;

use Model\Appointment;
use Model\AppointmentService;
use Model\appointmentDetails;
use Model\Service;

class APIController {
    public static function index() {
        $services = Service::all();

        echo json_encode($services);
        
    }

    public static function save() {

        $appointment = new Appointment($_POST); 
        $servicesIds = explode(",", $_POST["servicesIds"]);
        
        $appointmentTotal = 0;
        foreach ($servicesIds as $serviceId) { // Recorremos los servicios y seteamos el monto total de la cita
            $service = Service::find($serviceId);

            $appointmentTotal += $service->price;            
        }
        $appointment->appointmentTotal = $appointmentTotal;

        $result = $appointment->save(); // Guardamos la cita
        
        $appointmentId = $result["id"]; // Obtenemos el id de la cita insertado/guardado

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

        $appointmentServices = appointmentDetails::querySQL($query);

        $response = [
            "appointmentServices" => $appointmentServices
        ];
        
        echo json_encode($response);
    }
}