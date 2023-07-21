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
        $this->price = $args["price"] ?? "0";
    }

    public function validate() {

        if(!$this->serviceName) {
            self::$alerts[] =  "El nombre del servicio es obligatorio";
        }

        if(!$this->price || $this->price <= 0) {
            self::$alerts[] = "El precio debe ser mayor a $0";
        
        }
        if($this->price && !filter_var($this->price, FILTER_VALIDATE_FLOAT)) {
            self::$alerts[] = "El precio debe ser un valor numerico";
        }

        return self::$alerts;
    }
}