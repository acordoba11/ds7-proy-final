<?php
session_start();

if( isset($_SESSION['usuario_valido']) ) {
    include_once 'ordenes.php';
}
else {
    ?>

    <br><br>
    <p align='center'>Acceso no autorizado.</p>
    <p align='center'>[ <a href='login.php'>Iniciar sesión</a> ]</p>

    <?php
}
?>
