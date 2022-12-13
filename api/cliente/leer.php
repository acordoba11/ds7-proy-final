<?php
// print("<br>Entrando a leer.php");
//encabezados obligatorios
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
// incluir archivos de conexion y objetos
include_once '../configuracion/conexion.php';
include_once '../objetos/cliente.php';
// inicializar base de datos y objeto producto
$conex = new Conexion();
$db = $conex->obtenerConexion();
// inicializar objeto
$obj_cliente = new Cliente($db);

// obtener los datos
// $data = json_decode(file_get_contents("php://input"), true);

// query clientes
$stmt = $obj_cliente->listar();
$num = $stmt->rowCount();
// verificar si hay mas de 0 registros encontrados
if($num>0){
    // arreglo de productos
    $arr_clientes = array();
    // $arr_clientes["records"]=array();
    // obtiene todo el contenido de la tabla
    // fetch() es mas rapido que fetchAll()
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extraer fila
        // esto creara de $row['nombre'] a
        // solamente $nombre
        extract($row);
        $item_cliente=array(
            "id" => $id,
            "codigo" => $codigo,
            "nombre" => $nombre
        );
        array_push($arr_clientes, $item_cliente);
    }
    // asignar codigo de respuesta - 200 OK
    http_response_code(200);
    // mostrar actividades en formato json
    echo json_encode($arr_clientes);
}
else{
    // asignar codigo de respuesta - 404 No encontrado
    http_response_code(404);
    // informarle al usuario que no se encontraron productos
    echo json_encode(
        array("message" => "No se encontraron clientes.")
    );
}
// print("<br>Saliendo de leer.php");
?>