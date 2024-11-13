<html> 
<head> 
<title>Problema</title> 
</head> 
<body> 
<?php 
$conexion = new mysqli("localhost", "root", "", "phpfacil");

if ($conexion->connect_error) {
    die("Problemas en la conexion: " . $conexion->connect_error);
}

$sql = "DELETE FROM alumnoss";

if ($conexion->query($sql) === TRUE) {
    echo "Se efectuó el borrado de todos los alumnos.";
} else {
    die("Problemas en el select: " . $conexion->error);
}

$conexion->close();
?>
</body> 
</html>
