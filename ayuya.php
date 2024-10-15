<!DOCTYPE html>
<html>
<head>
    <title>Problema</title>
</head>
<body>
<h1>Mostrar Datos de Alumnos y Cursos</h1>
<?php
$conexion = new mysqli("localhost", "root", "", "parcial");

if ($conexion->connect_error) {
    die("Problemas en la conexión: " . $conexion->connect_error);
}

$sql = "SELECT nombre, apellido, cedula, deportes, equipos 
        FROM usuarios AS alu";
        
if ($stmt = $conexion->prepare($sql)) {
    $stmt->execute();
    $stmt->bind_result($nombre, $apellido, $cedula, $deportes, $equipos);

    // Verificar si hay resultados
    $hay_resultados = false;
    while ($stmt->fetch()) {
        $hay_resultados = true;
        echo "nombre: " . htmlspecialchars($nombre) . "<br>";
        echo "apellido: " . htmlspecialchars($apellido) . "<br>";
        echo "cedula: " . htmlspecialchars($cedula) . "<br>";
        echo "deportes: " . htmlspecialchars($deportes) . "<br>";
        echo "equipos: " . htmlspecialchars($equipos) . "<br>";

        echo "<hr>";
    }

    if (!$hay_resultados) {
        echo "No se encontraron resultados.<br>";
    }

    $stmt->close();
} else {
    die("Problemas en el select: " . $conexion->error);
}

$conexion->close();
?>
</body>
</html>