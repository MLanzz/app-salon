<?php 

namespace Model;

class Service extends ActiveRecord {
    // Base de datos
    protected static $table = "services";
    protected static $columnsDB = ["id", "serviceName", "price"];

    public $id;
    public $serviceName;
    public $price;

    public function __construct($args = []) {
        $this->id = $args["id"] ?? null;
        $this->serviceName = $args["serviceName"] ?? "";
        $this->price = $args["price"] ?? "";
    }
}