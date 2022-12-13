<?php
// include ("header.php");

if(array_key_exists('guardar', $_POST)){
    
    $numero = $_POST["numero"];
    $texto = $_POST["texto"];
    $id_estado = $_POST["estado"];
    $fecha_entrega = $_POST["fecha_entrega"];

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'http://localhost/ds7/proyecto_final/api/ordenProd/editar.php',
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
            "numero" : "'.$numero.'",
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
elseif(array_key_exists('editar', $_REQUEST)) {
    // echo "existe POST editar";
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
      <h2>EDITAR Orden de Producción</h2>
  </div>
<div class="d-flex">
  <form action="editar.php" method="post">
    <label>
      <span class="fname">Número <span class="required">*</span></span>
      <input type="text" name="numero" readonly value="<?php echo $_REQUEST['numero'];?>">
    </label>
    <label>
      <span>Cliente <span class="required">*</span></span>
      <input type="text" name="cliente" readonly value="<?php echo $_REQUEST['cliente'];?>">
    </label>
    <label>
      <span>Descripción <span class="required">*</span></span>
      <input type="text" name="texto" value="<?php echo $_REQUEST['texto'];?>">
    </label>
    <label>
      <span>Estado <span class="required">*</span></span>
      <select name="estado" required>
        <option value="select">Seleccione un estado...</option>
        <?php
        foreach ($arr_estados as $estado) {
            $selected = "";
            if($_REQUEST['estado'] == $estado['id']) {
                $selected = "selected";
            }
            print("<option ". $selected ." value=".$estado['codigo'].">".$estado['descripcion']."</option>\n");
        }
        ?>
      </select> 
    </label>
    <label>
      <span>Fecha de creación <span class="required">*</span></span>
      <input type="date" name="fecha_creada" readonly value="<?php echo $_REQUEST['fecha_creada'];?>"> 
    </label>
    <label>
      <span>Fecha de entrega <span class="required">*</span></span>
      <input type="date" name="fecha_entrega" value="<?php echo $_REQUEST['fecha_entrega'];?>"> 
    </label>
    <button type="submit" name="guardar">Guardar cambios</button>
  </form>
  
 </div>
</div>

</body>

<?php
}
else {

    if (isset($id)){
    
        $servicio = "http://localhost/ds7/proyecto2/api/agenda/leer_uno.php?id=".$id;
    
        $data = file_get_contents($servicio);
        // echo $data;
    
        $actividad = json_decode($data, true);
        // echo "<br>tipo de dato actividades: ", gettype($actividad);
        // echo "<br>";
        
        ?>
            <form action="editar.php" method="post">
            <label for="cars">Tipo de actividad:</label>
            <select name="actividad" id="actividad">
                <option value="Trabajo">Trabajo</option>
                <option value="Estudios">Estudios</option>
                <option value="Pendientes del Hogar">Pendientes del Hogar</option>
            </select><br><br><br>
            <input type="hidden" name="id" value="<?php echo $_REQUEST['id'] ?>">
            <input type="text" name="titulo" value="<?php echo("" . $actividad['titulo'] . ""); ?>">
            <br><br>
            <textarea name="texto" id="" cols="30" rows="10"><?php echo("" . $actividad['texto'] . ""); ?></textarea>
            <br><br>
            <input type="text" name="ubicacion" value="<?php echo("" . $actividad['ubicacion'] . ""); ?>">
            <br><br>
            Fecha inicio: <input type="date" name="rango" value="<?php echo("".($actividad['rango']).""); ?>">
            Fecha final<input type="date" name="rango_final" value="<?php echo("".($actividad['rango']).""); ?>">
            <br><br>
            <input type="submit" name="guardar_cambios" value="Guardar cambios">
            </form>
    
        <?php
        
    }
    
}

include ("footer.php");
?>