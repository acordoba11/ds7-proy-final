<?php
include ("header.php");
?>

<!-- <form name="FormFiltro" action="index.php" method="post">
    <br>
    Buscar por: <select name="campo">
        <option value="tipo_actividad" selected>Estado</option>
        <option value="titulo">Titulo</option>
        <option value="texto">Texto</option>
    </select>
    <input type="text" name="valor">
    <input type="submit" value="Filtrar Datos" name="ConsultarFiltro">
    <input type="submit" value="Ver Todos" name="ConsultarTodos">
</form>
<br> -->

<?php

$campo = "";
$valor = "";

if(array_key_exists('ConsultarFiltro', $_POST)) {
    $campo = $_POST['campo'];
    $valor = $_POST['valor'];
}

$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => 'http://localhost/ds7/proyecto_final/api/ordenProd/leer.php',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS =>'{
        "campo" : "'.$campo.'",
        "valor" : "'.$valor.'"
    }',
    CURLOPT_HTTPHEADER => array(
        'Content-Type: text/plain'
    ),
));

$response = curl_exec($curl);
curl_close($curl);
// echo $response;
$arr_response = json_decode($response, true);
// echo $arr_response['message'];



if( array_key_exists('records', $arr_response) ) {
    mostrarOrdenes($arr_response['records']);
} else {
    echo "<br>".$arr_response['message'];
}

function mostrarOrdenes($arr_registros) {
    print("<table id='grid' class='display' cellspacing='0'>\n");
    print("<thead>\n");
    print("<tr>\n");
    print("<th>Numero</th>\n");
    print("<th>Cliente</th>\n");
    print("<th>Estado</th>\n");
    print("<th>F. Creada</th>\n");
    print("<th>F. Entrega</th>\n");
    print("<th>Acciones</th>\n");
    print("</tr>\n");
    print("</thead>\n");

    print("<tbody>\n");
    foreach($arr_registros as $registro) {
        print("<tr>\n");
        print("<td>" .$registro['numero'] . "</td>\n");
        print("<td>" . $registro['nombre_cliente'] . "</td>\n");
        print("<td>" . $registro['estado'] . "</td>\n");

        $date = new DateTime($registro['fecha_creada']);
        print("<td>" . $date->format("d/M/Y") . "</td>\n");
        $date = new DateTime($registro['fecha_entrega']);
        print("<td>" . $date->format("d/M/Y") . "</td>\n");

        print("<td>\n");
        print("<a href='http://localhost/ds7/proyecto_final/fuente/ver_una_orden.php?id=" . $registro['id'] . "'><input type='button' value='Ampliar'></a>\n");
        print("<a href='http://localhost/ds7/proyecto_final/fuente/eliminar.php?id=" . $registro['id'] . "'><input type='button' value='Eliminar'></a>\n");
        print("</td>\n");

        print("</tr>\n");
    }
    print("</tbody>\n");
    print("</table>\n");
}

include ("footer_index.php");
?>