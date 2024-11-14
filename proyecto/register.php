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

    // Verificar si el correo, número de teléfono o nombre de usuario ya existe
    $check_sql = "SELECT * FROM usuarios WHERE mail = ? OR num_tlfn = ? OR nombreusuario = ?";
    $stmt = $conn->prepare($check_sql);
    $stmt->bind_param("sss", $mail, $num_tlfn, $nombreusuario);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $mensaje = "Error: El correo, teléfono o nombre de usuario ya está en uso.";
    } else {
        // Proceder con la inserción del nuevo usuario
        $insert_sql = "INSERT INTO usuarios (nombre, apellido, num_tlfn, mail, nombreusuario, contraseña) 
                       VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insert_sql);
        $stmt->bind_param("ssssss", $nombre, $apellido, $num_tlfn, $mail, $nombreusuario, $contraseña);

        if ($stmt->execute()) {
            $mensaje = "Registro exitoso.";
        } else {
            $mensaje = "Error: " . $stmt->error;
        }
    }

    $stmt->close();
    header("Location: resultado.php?mensaje=" . urlencode($mensaje));
    exit();
}

$conn->close();
?>
s