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

if( isset($_REQUEST['id']) ) {
    $id = $_REQUEST['id'];
    // echo "id: ".$id;

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'http://localhost/ds7/proyecto_final/api/ordenProd/leer_uno.php',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        // CURLOPT_POSTFIELDS =>'{
        //     "titulo" : "Front",
        //     "texto" : "Prueba desde frontend",
        //     "actividad" : "Estudios",
        //     "rango" : "2022-11-17 17:30:15",
        //     "rango_final" : "2022-12-16 18:30:15",
        //     "ubicacion" : "Universidad"
        // }',
        CURLOPT_POSTFIELDS =>'{
            "id" : "'.$id.'"
        }',
        CURLOPT_HTTPHEADER => array(
            'Content-Type: text/plain'
        ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
    // echo $response;

    $arr_response = json_decode($response, true);
    // print_r($arr_response);
    // echo $arr_response['message'];
    // echo "<script>alert(".$arr_response['message'].")</script>";

    if( array_key_exists('message', $arr_response) ) {
        echo "<br>".$arr_response['message'];
        return;
    }

}



?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualizar Orden</title>
    <link rel="stylesheet" href="css/nueva_orden.css" type="text/css">
</head>
<body>

<div class="container">

<span>
    <a href="index.php"><input type='button' value='Página principal'></a>
</span>

  <div class="title">
      <h2>Orden de Producción</h2>
  </div>
<div class="d-flex">
  <form action="editar.php" method="post">
    <label>
      <span class="fname">Número <span class="required">*</span></span>
      <input type="text" name="numero" readonly value="<?php echo $arr_response['numero'];?>">
    </label>
    <label>
      <span>Cliente <span class="required">*</span></span>
      <input type="text" name="cliente" readonly value="<?php echo $arr_response['cliente'];?>">
    </label>
    <label>
      <span>Descripción <span class="required">*</span></span>
      <input type="text" name="texto" readonly value="<?php echo $arr_response['texto'];?>">
    </label>
    <label>
      <span>Estado <span class="required">*</span></span>
      <select name="estado" required>
        <option value="<?php echo $arr_response['id_estado'];?>"><?php echo $arr_response['estado'];?></option>
      </select> 
    </label>
    <label>
      <span>Fecha de creación <span class="required">*</span></span>
      <input type="date" name="fecha_creada" readonly value="<?php echo $arr_response['fecha_creada'];?>"> 
    </label>
    <label>
      <span>Fecha de entrega <span class="required">*</span></span>
      <input type="date" name="fecha_entrega" readonly value="<?php echo $arr_response['fecha_entrega'];?>"> 
    </label>
    <button type="submit" name="editar">Editar Orden</button>
  </form>
  
 </div>
</div>

</body>

<?php

if(array_key_exists("crear", $_POST)) {

    $numero = $_POST["numero"];
    echo "numero: ".$numero;
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
echo $response;

$arr_response = json_decode($response, true);
// echo $arr_response['message'];
// echo "<script>alert(".$arr_response['message'].")</script>";


}

?>