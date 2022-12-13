<?php
// encabezados obligatorios
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
// incluir archivos de conexion y objetos
include_once '../configuracion/conexion.php';
include_once '../objetos/ordenProd.php';
// obtener conexion a la base de datos
$conex = new Conexion();
$db = $conex->obtenerConexion();
// preparar el objeto
$obj_ordenProd = new OrdenProduccion($db);

// obtener los datos
$data = json_decode(file_get_contents("php://input"), true);

// set ID property of record to read
$obj_ordenProd->setId($data['id']);
$stmt = $obj_ordenProd->leer();
$num = $stmt->rowCount();
// verificar si hay mas de 0 registros encontrados
if($num>0){
    // obtiene todo el contenido del registro
    // fetch() es mas rapido que fetchAll()
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    // asignar codigo de respuesta - 200 OK
    http_response_code(200);
    // mostrar actividades en formato json
    echo json_encode($row);
}
else{
    // asignar codigo de respuesta - 404 No encontrado
    http_response_code(404);
    // informarle al usuario que no se encontraron productos
    echo json_encode(
        array("message" => "No se encontraron ordenes de produccion.")
    );
}
?>