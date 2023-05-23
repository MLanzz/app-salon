<?php 

namespace Model;

class User extends ActiveRecord {
    // Base de datos
    protected static $table = "users";
    protected static $columnsDB = ["id", "firstName", "lastName", "email", "phone", "admin", "isConfirmed", "token", "password"];

    public $id;
    public $firstName;
    public $lastName;
    public $email;
    public $phone;
    public $admin;
    public $isConfirmed;
    public $token;
    public $password;

    public function __construct($args = []) {
        $this->id = $args["id"] ?? null;
        $this->firstName = $args["firstName"] ?? "";
        $this->lastName = $args["lastName"] ?? "";
        $this->email = $args["email"] ?? "";
        $this->phone = $args["phone"] ?? "";
        $this->admin = $args["admin"] ?? 0;
        $this->isConfirmed = $args["isConfirmed"] ?? 0;
        $this->token = $args["token"] ?? "";
        $this->password = $args["password"] ?? "";
    }
}