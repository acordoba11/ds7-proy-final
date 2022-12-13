<?php

if(isset($_REQUEST['id'])) {
    $id=$_REQUEST['id'];
    echo '¿Estás seguro de que deseas eliminar esta Orden de Producción?';
    ?>
    <br><br>
    <form action="" method="post">
    <input type="hidden" name="<?php $id ?>">
    <input type="submit" value="Eliminar" name="SI">
    <a href="ordenes.php"><input type="button" value="Cancelar"></a>
    </form>

    <?php
    if(isset($_POST['SI'])){
        if($_POST['SI']){
            
            // $titulo = $_POST["titulo"];
            // $texto = $_POST["texto"];
            // $actividad = $_POST["actividad"];
            // $rango = $_POST["rango"];
            // $rango_final = $_POST["rango_final"];
            // $ubicacion = $_POST["ubicacion"];

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'http://localhost/ds7/proyecto2/api/agenda/eliminar.php',
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
            echo $arr_response['message'];


            ?>
            <br><br><a href="index.php"><input type="button" value="VOLVER"></a>
            <?php      
        }
    }
} 
else{
    // echo '<script>alert("Error")</script>';
    ?>
    <a href="index.php"><input type="button" value="VOLVER"></a>
    <?php
}
?>