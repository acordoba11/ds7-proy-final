<?php
include ("header.php");
if (isset($_REQUEST['id'])){
    $id = $_REQUEST['id'];

    // $servicio = "http://localhost/ds7/proyecto2/api/agenda/leer_uno.php?id=".$id."";
    $servicio = "http://localhost/ds7/proyecto2/api/agenda/leer_uno.php?id=".$id;

    $data = file_get_contents($servicio);
    // echo $data;

    $actividades = json_decode($data, true);
    // echo "<br>tipo de dato actividades: ", gettype($actividades);
    // echo "<br>";

    if(array_key_exists('id', $_REQUEST)){
        // $obj_noticia = new agenda();
        // $actividades =$obj_noticia->ver_nota($_REQUEST['id']);
    }

    print("<td><h1>" . $actividades['titulo'] . "</h1></td>");
    print("<td><p><h2>" . $actividades['tipo_actividad'] . "</h2></td>");
    print("<td><p>" . $actividades['texto'] . "</td><br><br>");
    print("<td><b>Ubicacion:</b> &nbsp&nbsp " . $actividades['ubicacion'] . "</td><br>");
    $datetimerange = new DateTime($actividades['rango']);
    print("<td><b>Desde:</b> &nbsp" . $datetimerange->format("d/M/Y") . "</td>");
    $datetimerange = new DateTime($actividades['rango_final']);
    print("<td><b>&nbsp Hasta el:</b> &nbsp&nbsp" . $datetimerange->format("d/M/Y") . "</td><br>");
    $datetime = new DateTime($actividades['fecha']);
    print("<td><b>Creada el:</b> &nbsp" . $datetime->format("d/M/Y") . "</td><br>");

    ?>
    <br><br>
    <a href="eliminar.php?id=<?php echo $id ?>"><input type="button" value="ELIMINAR"></a>
    <a href="editar.php?id=<?php echo $id ?>"><input type="button" value="EDITAR"></a>
    <?php
}else {
    print"No hay regitro";
}

?> 
<?php
include ("footer.php");
?>