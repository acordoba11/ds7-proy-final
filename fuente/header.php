<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ordenes de Produccion</title>
    <!-- <link rel="stylesheet" href="css/estilo.css" type="text/css"> -->
    <link rel='stylesheet' type='text/css' href='css/jquery.dataTables.min.css'>
    <script src='js/jquery-3.1.1.js'></script>
    <script src='js/jquery.dataTables.min.js'></script>
</head>
<body>
<script>
        $(document).ready(function() {
            $('#grid').DataTable({
                "lengthMenu": [10,20,50],
                "order": [[0,"asc"]],
                "language": {
                    "lengthMenu": "Mostrar _MENU_ registros por pagina",
                    "zeroRecords": "No existen resultados en su busqueda",
                    "info": "Mostrando pagina _PAGE_ de _PAGES_",
                    "infoEmpty": "No hay registros disponibles",
                    "infoFiltered": "(Buscado entre _MAX_ registros en total)",
                    "search": "Buscar",
                    "paginate": {
                        "first": "Primero",
                        "last": "Ultimo",
                        "next": "Siguiente",
                        "previous": "Anterior",
                    },
                },
            });

            $("*").css("font-family","arial").css("font-size","14px");
        });
    </script>

<nav class="nav">
<span>
    <a href="index.php"><input type='button' value='Ver ordenes de produccion'></a>
</span>
<span>
    <a href="nueva_orden.php"><input type='button' value='Crear nueva orden'></a>
</span>
<span>
    <a href="login.php"><input type='button' value='Salir'></a>
</span>
<hr>
</nav>

    
