<!DOCTYPE html>
<html>
<head>
    <title>Problema</title>
</head>
<body>
    <?php
    // Establecer la zona horaria
    date_default_timezone_set('America/Caracas');

    echo "La fecha de hoy es: ";
    $fecha = date("d/m/Y");
    echo $fecha;
    echo "<br>";
    echo "La hora actual es: ";
    $hora = date("H:i:s");
    echo $hora;
    echo "<br>";
    ?>
    <a href="pagina65.php">Siguiente problema</a>
</body>
</html>
