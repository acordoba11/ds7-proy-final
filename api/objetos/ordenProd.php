<?php
//require_once('conexion.php');
class OrdenProduccion {
    // conexion de base de datos y tabla productos
    private $conn;
    // private $nombre_tabla = "ordenes";
    // atributos de la clase
    protected $id;
    protected $numero;
    protected $id_cliente;
    protected $texto;
    protected $id_estado;
    protected $fecha_creada;
    protected $fecha_entrega;

    // constructor con $db como conexion a base de datos
    public function __construct($db){
        $this->conn = $db;
    }

    public function setId($valor) {
        $this->id = $valor;
    }
    public function setNumero($valor) {
        $this->numero = $valor;
    }
    public function setIdCliente($valor) {
        $this->id_cliente = $valor;
    }
    public function setTexto($valor) {
        $this->texto = $valor;
    }
    public function setIdEstado($valor) {
        $this->id_estado = $valor;
    }
    public function setFechaCreada($valor) {
        $this->fecha_creada = $valor;
    }
    public function setFechaEntrega($valor) {
        $this->fecha_entrega = $valor;
    }

    public function listar_ordenes(){
        // print("<br>En agenda.php entrando listar_notas: <br>");
        // query para seleccionar todos
        $query = "CALL sp_listar_ordenes";
        // sentencia para preparar query
        $stmt = $this->conn->prepare($query);
        // ejecutar query
        $stmt->execute();
        // print("<br>agenda.php saliendo de listar_notas<br>");
        return $stmt;
    }
    
    public function leer(){
        // consulta para leer un solo registro
        $query = "CALL sp_leer_una_orden('".$this->id."')";
        // preparar declaración de consulta
        $stmt = $this->conn->prepare( $query );
        // ejecutar consulta
        $stmt->execute();
        // obtener fila recuperada
        // $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // echo json_encode($row);
        return $stmt;
    }

    public function crear(){
        // query para insertar un registro
        $query = "CALL sp_crear_orden('".$this->numero."','".$this->id_cliente."','".$this->texto."','".$this->id_estado."','".$this->fecha_entrega."')";

        // preparar query
        $stmt = $this->conn->prepare($query);
    
        // execute query
        if($stmt->execute()){
            return true;
        }
        return false;
    }
    
    public function eliminar(){
        // query para eliminar un registro
        $query = "CALL sp_eliminar('".$this->id."')";
            
        // preparar query
        $stmt = $this->conn->prepare($query);
    
        // execute query
        if($stmt->execute()){
            return true;
        }
        return false;
    }

    public function editar(){
        // query para editar un registro
        $query = "CALL sp_modificar_orden('".$this->numero."','".$this->texto."','".$this->id_estado."','".$this->fecha_entrega."')";

        // preparar query
        $stmt = $this->conn->prepare($query);
    
        // execute query
        if($stmt->execute()){
            return true;
        }
        return false;
    }  

    public function filtrar_ordenes($campo, $valor) { 
        // print("<br>En agenda.php entrando listar_notas: <br>");
        // query para seleccionar todos
        $query = "CALL sp_filtrar_actividad('".$campo."','".$valor."')";
        // sentencia para preparar query
        $stmt = $this->conn->prepare($query);
        // ejecutar query
        $stmt->execute();
        // print("<br>agenda.php saliendo de listar_notas<br>");
        return $stmt;
    }   
}

?>