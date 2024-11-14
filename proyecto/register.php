<?php
// Configuración de la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "proyecto";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) { 
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $num_tlfn = $_POST['num_tlfn'];
    $mail = $_POST['mail'];
    $nombreusuario = $_POST['nombreusuario'];
    $contraseña = password_hash($_POST['contraseña'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO usuarios (nombre, apellido, num_tlfn, mail, nombreusuario, contraseña) 
            VALUES ('$nombre', '$apellido', '$num_tlfn', '$mail', '$nombreusuario', '$contraseña')";

    if ($conn->query($sql) === TRUE) {
        $mensaje = "Registro exitoso.";
    } else {
        $mensaje = "Error: " . $sql . "<br>" . $conn->error;
    }
    header("Location: resultado.php?mensaje=" . urlencode($mensaje));
    exit();
}

$conn->close();
?>
