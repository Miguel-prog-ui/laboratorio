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

$mail = $conexion->real_escape_string($_REQUEST['mail']);
$sql = "SELECT * FROM alumnoss WHERE mail='$mail'";
$registros = $conexion->query($sql);

if ($registros->num_rows > 0) {
    $reg = $registros->fetch_assoc();
    ?> 
    <form action="pagina48a.php" method="post"> 
    Ingrese nuevo mail: 
    <input type="text" name="mailnuevo" value="<?php echo $reg['mail'] ?>"> 
    <br> 
    <input type="hidden" name="mailviejo" value="<?php echo $reg['mail'] ?>"> 
    <input type="submit" value="Modificar"> 
    </form> 
    <?php 
} else {
    echo "No existe alumno con dicho mail"; 
}

$conexion->close();
?>
</body> 
</html>
