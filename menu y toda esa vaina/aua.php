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
$cedula = isset($_REQUEST['cedula']) ? (int)$_REQUEST['cedula'] : null;
$deportes = isset($_REQUEST['deportes']) ? $conexion->real_escape_string($_REQUEST['deportes']) : null;
$equipos = isset($_REQUEST['equipos']) ? $conexion->real_escape_string($_REQUEST['equipos']) : null;




// Verificar si todas las variables están definidas
if ($nombre && $apellido && $cedula && $deporte && $equipo ) {
    // Verificar si la fecha es válida
 
        $sql = "INSERT INTO usuarios (nombre, apellido, cedula, deporte, equipo) VALUES ('$nombre', '$apellido', '$cedula', '$deportes', '$equipos')";
        if ($conexion->query($sql) === TRUE) {
            echo "El alumno fue dado de alta.";
        } else {
            echo "Problemas en el insert: " . $conexion->error;
        }   else  {
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