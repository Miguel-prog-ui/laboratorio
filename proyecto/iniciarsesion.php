<?php
// Datos de conexión a la base de datos
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

// Obtener datos del formulario
$nombreusuario = $_POST['nombreusuario'];
$contraseña = $_POST['contraseña'];

// Preparar y ejecutar la consulta SQL
$sql = "SELECT * FROM usuarios WHERE nombreusuario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $nombreusuario);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Verificar la contraseña
    $row = $result->fetch_assoc();
    if ($contraseña === $row['contraseña']) {
        echo "Inicio de sesión exitoso. Bienvenido, " . $row['nombre'] . "!";
    } else {
        echo "Contraseña incorrecta.";
    }
} else {
    echo "Nombre de usuario no encontrado.";
}

// Cerrar la conexión
$stmt->close();
$conn->close();
?>
