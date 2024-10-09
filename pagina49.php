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

$stmt = $conexion->prepare("INSERT INTO alumnoss (nombre, mail, codigocurso) VALUES (?, ?, ?)");
$stmt->bind_param("ssi", $_REQUEST['nombre'], $_REQUEST['mail'], $_REQUEST['codigocurso']);

if ($stmt->execute()) {
    echo "El alumno fue dado de alta.";
} else {
    echo "Problemas en el insert: " . $stmt->error;
}

$stmt->close();
$conexion->close();
?>
</body>
</html>
