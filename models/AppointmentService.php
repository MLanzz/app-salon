<?php 

namespace Model;

class AppointmentService extends ActiveRecord {

    protected static $table = "appointmentsServices";
    protected static $columnsDB = ["id", "appointmentId", "serviceId", "serviceName", "price"];

    public $id;
    public $appointmentId;
    public $serviceId;
    public $serviceName;
    public $price;

    public function __construct($args = []) {
        $this->id = $args["id"] ?? null;
        $this->appointmentId = $args["appointmentId"] ?? null;
        $this->serviceId = $args["serviceId"] ?? null;
        $this->serviceId = $args["serviceName"] ?? "";
        $this->serviceId = $args["price"] ?? "";
    }
}