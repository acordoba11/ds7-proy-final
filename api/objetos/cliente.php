<?php
//require_once('conexion.php');
class Cliente {
    // conexion de base de datos y tabla productos
    private $conn;
    // atributos de la clase
    protected $id;
    protected $nombre;
    protected $codigo;

    // constructor con $db como conexion a base de datos
    public function __construct($db){
        $this->conn = $db;
    }

    public function listar(){
        // query para seleccionar todos
        $query = "CALL sp_listar_clientes";
        // sentencia para preparar query
        $stmt = $this->conn->prepare($query);
        // ejecutar query
        $stmt->execute();
        return $stmt;
    }
    
}

?>