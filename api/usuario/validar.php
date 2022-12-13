<?php
// encabezados obligatorios
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
// incluir archivos de conexion y objetos
include_once '../configuracion/conexion.php';
include_once '../objetos/usuario.php';
// obtener conexion a la base de datos
$conex = new Conexion();
$db = $conex->obtenerConexion();
// obtener los datos
$data = json_decode(file_get_contents("php://input"), true);
// preparar el objeto producto
$usuario = new Usuario($db);
// set properties of record to read
$usuario->setNombre($data['nombre']);
$usuario->setClave($data['clave']);
// leer los detalles del producto a editar
$stmt = $usuario->validar();
$num = $stmt->rowCount();
// verificar si hay mas de 0 registros encontrados
if($num>0){
    // arreglo de productos
    // $arr=array();
    // // obtiene todo el contenido de la tabla
    // // fetch() es mas rapido que fetchAll()
    // while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
    //     // extraer fila
    //     // esto creara de $row['nombre'] a
    //     // solamente $nombre
    //     extract($row);
    //     $item_orden=array(
    //         "id" => $id,
    //         "numero" => $numero,
    //         "nombre_cliente" => $nombre,
    //         "texto" => $texto,
    //         "estado" => $descripcion,
    //         "fecha_creada" => $fecha_creada,
    //         "fecha_entrega" => $fecha_entrega
    //     );
    //     array_push($arr_ordenes["records"], $item_orden);
        
    // }

    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    extract($row);
    $arr = array( "coincidencia" => $coincidencia );
    // asignar codigo de respuesta - 200 OK
    http_response_code(200);
    // mostrar actividades en formato json
    // echo json_encode($arr_ordenes);
    echo json_encode($arr);
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