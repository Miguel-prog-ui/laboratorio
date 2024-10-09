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

$mailnuevo = $conexion->real_escape_string($_REQUEST['mailnuevo']);
$mailviejo = $conexion->real_escape_string($_REQUEST['mailviejo']);
$sql = "UPDATE alumnoss SET mail='$mailnuevo' WHERE mail='$mailviejo'";

if ($conexion->query($sql) === TRUE) {
    echo "El mail fue modificado con exito";
} else {
    die("Problemas en el select: " . $conexion->error);
}

$conexion->close();
?>
</body> 
</html>
