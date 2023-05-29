<?php 

namespace Model;

use LengthException;

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

    // Mensajes de validación para la creación de una cuenta
    public function validateUser() {
        if(!$this->firstName) {
            self::$alerts["errors"][] = "El nombre del usuario es obligatorio";
        }

        if(!$this->lastName) {
            self::$alerts["errors"][] = "El apellido del usuario es obligatorio";
        }

        if(!$this->email) {
            self::$alerts["errors"][] = "El e-mail del usuario es obligatorio";
        }

        if(!$this->phone) {
            self::$alerts["errors"][] = "El teléfono del usuario es obligatorio";
        }

        if(!$this->password) {
            self::$alerts["errors"][] = "La contraseña es obligatoria";
        } elseif (strlen($this->password) < 6) {
            self::$alerts["errors"][] = "La contraseña debe tener un minimo de 6 caracteres";
        }


        return self::$alerts;
    }

    // Revisamos si el usuario ya existe
    public function alreadyExist() {

        $query = "SELECT * FROM users WHERE email = '" . self::$db->escape_string($this->email) . "' LIMIT 1";

        $result = self::$db->query($query);

        if ($result->num_rows) {
            self::$alerts["errors"][] = "El e-mail ingresado ya esta esta registrado";
        }

        return $result->num_rows;

    }

    public function hashPassword() {
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    public function createToken() {
        $this->token = uniqid();
    }
}