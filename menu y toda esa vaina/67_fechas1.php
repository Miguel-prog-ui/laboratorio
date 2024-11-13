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

// Verificar y escapar variables para evitar inyección SQL
$nombre = isset($_REQUEST['nombre']) ? $conexion->real_escape_string($_REQUEST['nombre']) : null;
$apellido = isset($_REQUEST['apellido']) ? $conexion->real_escape_string($_REQUEST['apellido']) : null;
$mail = isset($_REQUEST['mail']) ? $conexion->real_escape_string($_REQUEST['mail']) : null;
$codigocurso = isset($_REQUEST['codigocurso']) ? $conexion->real_escape_string($_REQUEST['codigocurso']) : null;
$dia = isset($_REQUEST['dia']) ? (int)$_REQUEST['dia'] : null;
$mes = isset($_REQUEST['mes']) ? (int)$_REQUEST['mes'] : null;
$anio = isset($_REQUEST['anio']) ? (int)$_REQUEST['anio'] : null;

// Verificar si todas las variables están definidas
if ($nombre && $apellido && $mail && $codigocurso && $dia && $mes && $anio) {
    // Verificar si la fecha es válida
    if (checkdate($mes, $dia, $anio)) {
        $fechanacimiento = "$anio-$mes-$dia";
        $sql = "INSERT INTO alumnos (nombre, apellido, gmail, curso, fechanac) VALUES ('$nombre', '$apellido', '$mail', '$codigocurso', '$fechanacimiento')";
        if ($conexion->query($sql) === TRUE) {
            echo "El alumno fue dado de alta.";
        } else {
            echo "Problemas en el insert: " . $conexion->error;
        }
    } else {
        echo "Fecha de nacimiento no válida.";
    }
} else {
    echo "Faltan datos necesarios.";
}

// Cerrar conexión
$conexion->close();
?>
<br>
<a href="67_fechas2.php">Ver listado de alumnos</a>
</body>
</html>