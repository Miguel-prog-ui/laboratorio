<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Problema</title>
</head>
<body>
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "phpfacil";

// Crear conexión
$conexion = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conexion->connect_error) {
    die("Problemas en la conexión: " . $conexion->connect_error);
}

// Escapar variables para evitar inyección SQL
$nombre = $_REQUEST['nombre'];
$mail = $_REQUEST['mail'];
$codigocurso = $_REQUEST['codigocurso'];
$dia = (int)$_REQUEST['dia'];
$mes = (int)$_REQUEST['mes'];
$anio = (int)$_REQUEST['anio'];

// Verificar si la fecha es válida
if (checkdate($mes, $dia, $anio)) {
    $fechanacimiento = "$anio-$mes-$dia";
    $sql = $conexion->prepare("INSERT INTO alumnoss (nombre, mail, codigocurso, fechanac) VALUES (?, ?, ?, ?)");
    $sql->bind_param("ssss", $nombre, $mail, $codigocurso, $fechanacimiento);
    
    if ($sql->execute() === TRUE) {
        echo "El alumno fue dado de alta.";
    } else {
        die("Problemas en el insert: " . $sql->error);
    }
    $sql->close();
} else {
    echo "Fecha de nacimiento no válida.";
}

// Cerrar conexión
$conexion->close();
?>
<br>
<a href="67_fechas2.php">Ver listado de alumnoss</a>
</body>
</html>
