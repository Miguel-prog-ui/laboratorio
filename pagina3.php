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

$codigocurso = $_REQUEST['codigocurso'];
$mailviejo = $_REQUEST['mailviejo'];

$sql = "UPDATE alumnos SET codigocurso = ? WHERE mail = ?";
if ($stmt = $conexion->prepare($sql)) {
    $stmt->bind_param("is", $codigocurso, $mailviejo);
    if ($stmt->execute()) {
        echo "El curso fue modificado con éxito";
    } else {
        die("Problemas en el update: " . $stmt->error);
    }
    $stmt->close();
} else {
    die("Problemas en el prepare: " . $conexion->error);
}

$conexion->close();
?>
</body>
</html>