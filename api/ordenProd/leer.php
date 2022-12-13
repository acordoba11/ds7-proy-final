<?php
// print("<br>Entrando a leer.php");
//encabezados obligatorios
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
// incluir archivos de conexion y objetos
include_once '../configuracion/conexion.php';
include_once '../objetos/ordenProd.php';
// inicializar base de datos y objeto producto
$conex = new Conexion();
$db = $conex->obtenerConexion();
// inicializar objeto
$obj_ordenProd = new OrdenProduccion($db);

// obtener los datos
$data = json_decode(file_get_contents("php://input"), true);
// print_r($data);
// asegurar que los datos no esten vacios
if( !empty($data['campo']) && !empty($data['valor']) ) {
    // query productos
    $stmt = $obj_ordenProd->filtrar_ordenes($data['campo'], $data['valor']);
}
else {
    // query productos
    $stmt = $obj_ordenProd->listar_ordenes();
}

$num = $stmt->rowCount();
// verificar si hay mas de 0 registros encontrados
if($num>0){
    // arreglo de productos
    $arr_ordenes=array();
    $arr_ordenes["records"]=array();
    // obtiene todo el contenido de la tabla
    // fetch() es mas rapido que fetchAll()
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extraer fila
        // esto creara de $row['nombre'] a
        // solamente $nombre
        extract($row);
        $item_orden=array(
            "id" => $id,
            "numero" => $numero,
            "nombre_cliente" => $nombre,
            "texto" => $texto,
            "estado" => $descripcion,
            "fecha_creada" => $fecha_creada,
            "fecha_entrega" => $fecha_entrega
        );
        array_push($arr_ordenes["records"], $item_orden);
    }
    // asignar codigo de respuesta - 200 OK
    http_response_code(200);
    // mostrar actividades en formato json
    echo json_encode($arr_ordenes);
}
else{
    // asignar codigo de respuesta - 404 No encontrado
    http_response_code(404);
    // informarle al usuario que no se encontraron productos
    echo json_encode(
        array("message" => "No se encontraron ordenes de produccion.")
    );
}
// print("<br>Saliendo de leer.php");
?>