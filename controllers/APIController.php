<?php 

namespace Controllers;

use Model\Appointment;
use Model\AppointmentService;
use Model\appointmentDetails;
use Model\Service;

class APIController {
    public static function getServices() {
        $services = Service::all();

        echo json_encode($services);
        
    }

    public static function saveAppointment() {

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

    public static function getAppointmentDetails() {

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

    public static function deleteAppointment() {
        $appointmentId = $_POST["appointmentId"];
        $appointment = Appointment::find($appointmentId);

        $appointmentServices = AppointmentService::whereAll("appointmentId", $appointment->id);

        foreach ($appointmentServices as $appointmentService) {
            $appointmentService->delete();
        }

        $result = $appointment->delete();

        $response = [
            "result" => $result
        ];

        echo json_encode($response);
    }

    public static function saveService() {
        $service = new Service($_POST);

        $result = $service->save();

        $id = $result["id"] ?? 0;

        // Si tenemos un id en el result significa que estamos creando
        if (intval($id) !== 0) {
            $service->sync(["id" => $id]);
        }

        $response = [
            "result" => $result,
            "service" => $service
        ];

        echo json_encode($response);
    }

    public static function deleteService() {
        $service = new Service($_POST);

        $result = $service->delete();

        $response = [
            "result" => $result
        ];

        echo json_encode($response);
    }
}