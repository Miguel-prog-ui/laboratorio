<!DOCTYPE html>
<html>
<head>
    <title>Problema</title>
</head>
<body>
<h1>Mostrar Datos de Alumnos y Cursos</h1>
<?php
$conexion = new mysqli("localhost", "root", "", "phpfacil");

if ($conexion->connect_error) {
    die("Problemas en la conexión: " . $conexion->connect_error);
}

$sql = "SELECT alu.codigo AS codigo, nombre, mail, codigocurso, nombrecur 
        FROM alumnoss AS alu 
        INNER JOIN cursos AS cur ON cur.codigo = alu.codigocurso";

if ($stmt = $conexion->prepare($sql)) {
    $stmt->execute();
    $stmt->bind_result($codigo, $nombre, $mail, $codigocurso, $nombrecur);

    // Verificar si hay resultados
    $hay_resultados = false;
    while ($stmt->fetch()) {
        $hay_resultados = true;
        echo "Codigo: " . htmlspecialchars($codigo) . "<br>";
        echo "Nombre: " . htmlspecialchars($nombre) . "<br>";
        echo "Mail: " . htmlspecialchars($mail) . "<br>";
        echo "Curso: " . htmlspecialchars($nombrecur) . "<br>";
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