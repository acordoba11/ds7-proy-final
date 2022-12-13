<?php
session_start();
if( !isset($_SESSION['usuario_valido']) ) {
    ?>

    <br><br>
    <p align='center'>Acceso no autorizado.</p>
    <p align='center'>[ <a href='login.php'>Iniciar sesión</a> ]</p>

    <?php

    return;
}

$servicio = "http://localhost/ds7/proyecto_final/api/cliente/leer.php";

$response_clientes = file_get_contents($servicio);
// echo $response_clientes;
// echo "<br>tipo de dato response_clientes: ", gettype($response_clientes);

$arr_clientes = json_decode($response_clientes, true);
// print_r($arr_clientes);
// echo "<br>tipo de dato arr_clientes: ", gettype($arr_clientes);
// echo "<br>";

$servicio = "http://localhost/ds7/proyecto_final/api/estadoProd/leer.php";
$response_estados = file_get_contents($servicio);
$arr_estados = json_decode($response_estados, true);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva Orden</title>
    <link rel="stylesheet" href="css/nueva_orden.css" type="text/css">
</head>
<body>

<div class="container">

<span>
    <a href="index.php"><input type='button' value='Página principal'></a>
</span>

  <div class="title">
      <h2>Nueva Orden de Producción</h2>
  </div>
<div class="d-flex">
  <form action="nueva_orden.php" method="post">
    <label>
      <span class="fname">Número <span class="required">*</span></span>
      <input type="text" name="numero" placeholder="19000" pattern="^[0-9]+$" required>
    </label>
    <label>
      <span>Cliente <span class="required">*</span></span>
      <select name="cliente" required>
        <option value="select">Seleccione un cliente...</option>
        <?php
        foreach ($arr_clientes as $cliente) {
            print("<option value=".$cliente['codigo'].">".$cliente['nombre']."</option>\n");
        }
        ?>
      </select>
    </label>
    <label>
      <span>Descripción <span class="required">*</span></span>
      <input type="text" name="texto" placeholder="Fabricación de..." required>
    </label>
    <label>
      <span>Estado <span class="required">*</span></span>
      <select name="estado" required>
        <option value="select">Seleccione un estado...</option>
        <?php
        foreach ($arr_estados as $estado) {
            print("<option value=".$estado['codigo'].">".$estado['descripcion']."</option>\n");
        }
        ?>
      </select> 
    </label>
    <label>
      <span>Fecha de creación <span class="required">*</span></span>
      <input type="date" name="fecha_creada" readonly required  value="<?php echo date("Y-m-d");?>"> 
    </label>
    <label>
      <span>Fecha de entrega <span class="required">*</span></span>
      <input type="date" name="fecha_entrega" required> 
    </label>
    <button type="submit" name="crear">Crear Orden</button>
  </form>
  
 </div>
</div>

</body>

<?php

if(array_key_exists("crear", $_POST)) {

    $numero = $_POST["numero"];
    $id_cliente = $_POST["cliente"];
    $texto = $_POST["texto"];
    $id_estado = $_POST["estado"];
    $fecha_entrega = $_POST["fecha_entrega"];

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'http://localhost/ds7/proyecto_final/api/ordenProd/crear.php',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>'{
            "numero" : "'.$numero.'",
            "id_cliente" : "'.$id_cliente.'",
            "texto" : "'.$texto.'",
            "id_estado" : "'.$id_estado.'",
            "fecha_entrega" : "'.$fecha_entrega.'"
        }',
        CURLOPT_HTTPHEADER => array(
            'Content-Type: text/plain'
        ),
    ));

$response = curl_exec($curl);

curl_close($curl);
// echo $response;

$arr_response = json_decode($response, true);
echo $arr_response['message'];

}

?>