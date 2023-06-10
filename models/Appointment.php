<?php 

namespace Model;

class Appointment extends ActiveRecord {
    protected static $table = "appointments";
    protected static $columnsDB = ["id", "appointmentDate", "appointmentTime", "userId"];

    public $id;
    public $appointmentDate;
    public $appointmentTime;
    public $userId;

    public function __construct($args = []) {
        $this->id = $args["id"] ?? null;
        $this->appointmentDate = $args["appointmentDate"] ?? "";
        $this->appointmentTime = $args["appointmentTime"] ?? "";
        $this->userId = $args["userId"] ?? null;
    }
}