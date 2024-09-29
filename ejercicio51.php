<!DOCTYPE html>
<html>
<head>
    <title>Problema</title>
</head>
<body>
<?php
$conexion = new mysqli("localhost", "root", "", "phpfacil");

if ($conexion->connect_error) {
    die("Problemas en la conexión: " . $conexion->connect_error);
}

$sql = "SELECT COUNT(*) AS cantidad FROM alumnos";

if ($resultado = $conexion->query($sql)) {
    $reg = $resultado->fetch_assoc();
    echo "La cantidad de alumnos inscriptos son: " . htmlspecialchars($reg['cantidad']);
    $resultado->free();
} else {
    die("Problemas en el select: " . $conexion->error);
}

$conexion->close();
?>
</body>
</html>