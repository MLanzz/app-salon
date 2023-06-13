<?php 

namespace Model;

class AdminAppointment extends ActiveRecord {

    protected static $table = "appointments";
    protected static $columnsDB = ["appointmentId", "appointmentDate", "fullName", "email", "serviceName", "price"];

    public $appointmentId;
    public $appointmentDate;
    public $fullName;
    public $email;
    public $serviceName;
    public $price;

    public function __construct($args = []) {
        $this->appointmentId = $args["appointmentId"] ?? null;
        $this->appointmentDate = $args["appointmentDate"] ?? "";
        $this->fullName = $args["fullName"] ?? "";
        $this->email = $args["email"] ?? "";
        $this->serviceName = $args["serviceName"] ?? "";
        $this->price = $args["price"] ?? "";
    }
}