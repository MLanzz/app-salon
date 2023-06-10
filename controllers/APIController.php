<?php 

namespace Controllers;

use Model\Appointment;
use Model\Service;

class APIController {
    public static function index() {
        $services = Service::all();

        echo json_encode($services);
        
    }


    public static function save() {
        
        $appointment = new Appointment($_POST);
        
        // $result = $appointment->save();

        $response = [
            // "result" => $result,
            "appointment" => $appointment
        ];

        echo json_encode($response);
    }
}