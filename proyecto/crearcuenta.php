<?php
// Datos de conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "proyecto";

// Crear conexión
$conn = new mysqli("localhost", "root", "", "proyecto");

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener datos del formulario
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$num_tlfn = $_POST['num_tlfn'];
$mail = $_POST['mail'];
$nombreusuario = $_POST['nombreusuario'];
$contraseña = $_POST['contraseña'];

// Preparar y ejecutar la consulta SQL
$sql = "INSERT INTO usuarios (nombre, apellido, num_tlfn, mail, nombreusuario, contraseña) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssss", $nombre, $apellido, $num_tlfn, $mail, $nombreusuario, $contraseña);

if ($stmt->execute()) {
    echo "Cuenta creada exitosamente";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Cerrar la conexión
$stmt->close();
$conn->close();
?>
