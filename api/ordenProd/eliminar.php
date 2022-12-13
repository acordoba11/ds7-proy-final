<?php
// echo "Entrando a crear.php";
// encabezados obligatorios
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-AllowHeaders, Authorization, X-Requested-With");
// obtener conexion de base de datos
include_once '../configuracion/conexion.php';
// instanciar el objeto producto
include_once '../objetos/agenda.php';
$conex = new Conexion();
$db = $conex->obtenerConexion();
$agenda = new Agenda($db);
// obtener los datos
$data = json_decode(file_get_contents("php://input"), true);
// print_r($data);
// asegurar que los datos no esten vacios
if(
    !empty($data['id'])
){
    // asignar valores de propiedad a producto
    $agenda->id = $data['id'];

    // insertar la actividad en la tabla
    if($agenda->eliminar_nota()){
        // asignar codigo de respuesta - 201 creado
        http_response_code(201);
        // informar al usuario
        echo json_encode(array("message" => "La actividad ha sido borrada."));
    }
    // si no puede crear la actividad, informar al usuario
    else{
        // asignar codigo de respuesta - 503 servicio no disponible
        http_response_code(503);
        // informar al usuario
        echo json_encode(array("message" => "No se puede borrar la actividad."));
    }
}
// informar al usuario que los datos estan incompletos
else{
    // asignar codigo de respuesta - 400 solicitud incorrecta
    http_response_code(400);
    // informar al usuario
    echo json_encode(array("message" => "No se puede borrar la actividad. Los datos estan incompletos."));
}
// echo "Saliendo de crear.php";
?>