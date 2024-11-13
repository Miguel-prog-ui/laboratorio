<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Problema</title>
</head>
<body>
<?php
$conexion = new mysqli("localhost", "root", "", "phpfacil"); 
if ($conexion->connect_error) {
    die("Problemas en la conexión: " . $conexion->connect_error);
}

$sql = "SELECT alu.codigo, alu.nombre, alu.apellido, alu.gmail, alu.fechanac, cur.nombrecur 
        FROM alumnos AS alu 
        INNER JOIN cursos AS cur ON cur.codigo = alu.curso";
$registros = $conexion->query($sql);
if (!$registros) {
    die("Problemas en el select: " . $conexion->error);
}

while ($reg = $registros->fetch_assoc()) {
    echo "Código: " . $reg['codigo'] . "<br>";
    echo "Nombre: " . $reg['nombre'] . "<br>";
    echo "Apellido: " . $reg['apellido'] . "<br>";
    echo "Mail: " . $reg['gmail'] . "<br>";
    echo "Fecha de Nacimiento: " . $reg['fechanac'] . "<br>";
    echo "Curso: " . $reg['nombrecur'] . "<br>";
    echo "<hr>";
}

$conexion->close();
?>
</body>
</html>
