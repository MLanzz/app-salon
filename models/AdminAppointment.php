<?php 

namespace Model;

class AdminAppointment extends ActiveRecord {

    protected static $table = "appointments";
    protected static $columnsDB = ["appointmentId", "appointmentDate", "fullName", "email", "appointmentTotal", "serviceId" , "serviceName", "servicePrice"];

    public $appointmentId;
    public $appointmentDate;
    public $fullName;
    public $email;
    public $appointmentTotal;
    public $serviceId;
    public $serviceName;
    public $servicePrice;

    public function __construct($args = []) {
        $this->appointmentId = $args["appointmentId"] ?? null;
        $this->appointmentDate = $args["appointmentDate"] ?? "";
        $this->fullName = $args["fullName"] ?? "";
        $this->email = $args["email"] ?? "";
        $this->appointmentTotal = $args["appointmentTotal"] ?? "0";
        $this->serviceId = $args["serviceId"] ?? null;
        $this->serviceName = $args["serviceName"] ?? "";
        $this->servicePrice = $args["servicePrice"] ?? "0";
    }
}