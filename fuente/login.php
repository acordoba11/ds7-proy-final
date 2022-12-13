<?php
session_start();

if( array_key_exists('IniciarSesion', $_POST) ) {
    if( isset($_REQUEST['usuario']) && isset($_REQUEST['clave']) ) {
        $usuario = $_REQUEST['usuario'];
        $clave = $_REQUEST['clave'];

        $salt = substr($usuario, 0, 2);
        $clave_crypt = crypt($clave, $salt);

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://localhost/ds7/proyecto_final/api/usuario/validar.php',
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
                "nombre" : "'.$usuario.'",
                "clave" : "'.$clave_crypt.'"
            }',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: text/plain'
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        // echo $response;
        $arr_response = json_decode($response, true);
        // echo $arr_response['coincidencia'];
        // echo $arr_response['message'];

        if( array_key_exists('message', $arr_response) ) {
            echo $arr_response['message'];
            return;
        }

        $coincidencias = $arr_response['coincidencia'];

        if( $coincidencias > 0 ) {
            $usuario_valido = $usuario;
            $_SESSION["usuario_valido"] = $usuario_valido;
        }
    }

}
elseif ( array_key_exists('CerrarSesion', $_POST) ) {
    if ( isset($_SESSION["usuario_valido"]) ) {
        unset($_SESSION["usuario_valido"]);
        session_destroy();
        print("<br><br><p align='center'>Conexión finalizada</p>\n");
    } else {
        print("<br><br><p align='center'>No existe una conexión activa</p>\n");
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/login.css" type="text/css">
</head>
<body>

<?php
    if( isset($_SESSION['usuario_valido']) ) {
        include_once 'header2.php';
        ?>

        <div class="login">
            <h1>¿Deseas cerrar sesión?</h1>
            <form method="post">
                <button name="CerrarSesion" type="submit" class="btn btn-primary btn-block btn-large">Cerrar sesión</button>
            </form>
        </div>
        </body>

        <?php
    }
    else {
        ?>

        <div class="login">
            <h1>Login</h1>
            <form method="post">
                <input type="text" name="usuario" placeholder="Username" required="required" />
                <input type="password" name="clave" placeholder="Password" required="required" />
                <button name="IniciarSesion" type="submit" class="btn btn-primary btn-block btn-large">Iniciar sesión</button>
            </form>
        </div>
        </body>

        <?php
    }
?>



