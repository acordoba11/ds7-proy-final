<?php
//require_once('conexion.php');
class Usuario {
    // conexion de base de datos y tabla productos
    private $conn;
    // atributos de la clase
    protected $id;
    protected $nombre;
    protected $clave;

    // constructor con $db como conexion a base de datos
    public function __construct($db){
        $this->conn = $db;
    }

    public function setNombre($valor) {
        $this->nombre = $valor;
    }

    public function setClave($valor) {
        $this->clave = $valor;
    }

    public function validar(){
        // print("<br>En agenda.php entrando listar_notas: <br>");
        // query para seleccionar todos
        $query = "CALL sp_validar_usuario('".$this->nombre."','".$this->clave."')";
        // sentencia para preparar query
        $stmt = $this->conn->prepare($query);
        // ejecutar query
        $stmt->execute();
        // print("<br>agenda.php saliendo de listar_notas<br>");
        return $stmt;
    }
    
}

?>