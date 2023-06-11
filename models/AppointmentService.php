<?php 

namespace Model;

class AppointmentService extends ActiveRecord {

    protected static $table = "appointmentsServices";
    protected static $columnsDB = ["id", "appointmentId", "serviceId"];

    public $id;
    public $appointmentId;
    public $serviceId;

    public function __construct($args = []) {
        $this->id = $args["id"] ?? null;
        $this->appointmentId = $args["appointmentId"] ?? null;
        $this->serviceId = $args["serviceId"] ?? null;
    }
}