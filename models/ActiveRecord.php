<?php
namespace Model;
class ActiveRecord {

    // Base DE DATOS
    protected static $db;
    protected static $table = '';
    protected static $columnsDB = [];

    // alerts y Mensajes
    protected static $alerts = [];
    
    // Definir la conexión a la BD - includes/database.php
    public static function setDB($database) {
        self::$db = $database;
    }

    public static function setAlerta($tipo, $mensaje) {
        static::$alerts[$tipo][] = $mensaje;
    }

    // Validación
    public static function getAlerts() {
        return static::$alerts;
    }

    public function validate() {
        static::$alerts = [];
        return static::$alerts;
    }

    // Consulta SQL para crear un objeto en Memoria
    public static function querySQL($query) {
        // Consultar la base de datos
        $resultado = self::$db->query($query);

        // Iterar los resultados
        $array = [];
        while($registro = $resultado->fetch_assoc()) {
            $array[] = static::crearObjeto($registro);
        }

        // liberar la memoria
        $resultado->free();

        // retornar los resultados
        return $array;
    }

    // Crea el objeto en memoria que es igual al de la BD
    protected static function crearObjeto($registro) {
        $objeto = new static;

        foreach($registro as $key => $value ) {
            if(property_exists( $objeto, $key  )) {
                $objeto->$key = $value;
            }
        }

        return $objeto;
    }

    // Identificar y unir los atributos de la BD
    public function atributos() {
        $atributos = [];
        foreach(static::$columnsDB as $columna) {
            if($columna === 'id') continue;
            $atributos[$columna] = $this->$columna;
        }
        return $atributos;
    }

    // Sanitizar los datos antes de guardarlos en la BD
    public function sanitizarAtributos() {
        $atributos = $this->atributos();
        $sanitizado = [];
        foreach($atributos as $key => $value ) {
            $sanitizado[$key] = self::$db->escape_string($value);
        }
        return $sanitizado;
    }

    // Sincroniza BD con Objetos en memoria
    public function sync($args=[]) { 
        foreach($args as $key => $value) {
          if(property_exists($this, $key) && !is_null($value)) {
            $this->$key = $value;
          }
        }
    }

    // Registros - CRUD
    public function save() {
        $resultado = '';
        if(!is_null($this->id) && $this->id !== "0") {
            // actualizar
            $resultado = $this->update();
        } else {
            // Creando un nuevo registro
            $resultado = $this->create();
        }
        return $resultado;
    }

    // Todos los registros
    public static function all() {
        $query = "SELECT * FROM " . static::$table;
        $resultado = self::querySQL($query);
        return $resultado;
    }

    // Busca un registro por su id
    public static function find($id) {
        $query = "SELECT * FROM " . static::$table  ." WHERE id = {$id}";
        $resultado = self::querySQL($query);
        return array_shift( $resultado ) ;
    }
    
    // Filtramos por una columna especificada
    public static function where($key, $value) {
        $query = "SELECT * FROM " . static::$table  ." WHERE {$key} = '{$value}'";
        $resultado = self::querySQL($query);
        return array_shift( $resultado ) ;
    }

    public static function whereAll($key, $value) {
        $query = "SELECT * FROM " . static::$table  ." WHERE {$key} = '{$value}'";
        $resultado = self::querySQL($query);
        return $resultado;
    }

    // Obtener Registros con cierta cantidad
    public static function get($limite) {
        $query = "SELECT * FROM " . static::$table . " LIMIT {$limite}";
        $resultado = self::querySQL($query);
        return array_shift( $resultado ) ;
    }

    // crea un nuevo registro
    public function create() {
        // Sanitizar los datos
        $atributos = $this->sanitizarAtributos();

        // Insertar en la base de datos
        $query = " INSERT INTO " . static::$table . " ( ";
        $query .= join(', ', array_keys($atributos));
        $query .= " ) VALUES (' "; 
        $query .= join("', '", array_values($atributos));
        $query .= " ') ";

        // Resultado de la consulta
        $resultado = self::$db->query($query);
        return [
           'resultado' =>  $resultado,
           'id' => self::$db->insert_id
        ];
    }

    // Actualizar el registro
    public function update() {
        // Sanitizar los datos
        $atributos = $this->sanitizarAtributos();

        // Iterar para ir agregando cada campo de la BD
        $valores = [];
        foreach($atributos as $key => $value) {
            $valores[] = "{$key}='{$value}'";
        }

        // Consulta SQL
        $query = "UPDATE " . static::$table ." SET ";
        $query .=  join(', ', $valores );
        $query .= " WHERE id = '" . self::$db->escape_string($this->id) . "' ";
        $query .= " LIMIT 1 "; 

        // Actualizar BD
        $resultado = self::$db->query($query);
        return $resultado;
    }

    // Eliminar un Registro por su ID
    public function delete() {
        $query = "DELETE FROM "  . static::$table . " WHERE id = " . self::$db->escape_string($this->id) . " LIMIT 1";
        $resultado = self::$db->query($query);
        return $resultado;
    }

}