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

$mail = $_REQUEST['mail'];
$stmt = $conexion->prepare("SELECT codigo FROM alumnoss WHERE mail = ?");
$stmt->bind_param("s", $mail);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $stmt = $conexion->prepare("DELETE FROM alumnoss WHERE mail = ?");
    $stmt->bind_param("s", $mail);
    $stmt->execute();
    echo "Se efectuó el borrado del alumno con dicho mail.";
} else {
    echo "No existe un alumno con ese mail.";
}

$stmt->close();
$conexion->close();
?> 
</body> 
</html>
