<?php
session_start();

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
    $nombreusuario = isset($_POST['nombreusuario']) ? $_POST['nombreusuario'] : '';
    $contraseña = isset($_POST['contraseña']) ? $_POST['contraseña'] : '';

    if (!empty($nombreusuario) && !empty($contraseña)) {
        $sql = "SELECT contraseña FROM usuarios WHERE nombreusuario=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $nombreusuario);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result) {
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                if (password_verify($contraseña, $row['contraseña'])) {
                    // Establecer el nombre de usuario en la sesión
                    $_SESSION['nombreusuario'] = $nombreusuario;
                    // Redirigir al menú
                    header("Location: menu.php");
                    exit();
                } else {
                    $mensaje = "La contraseña es incorrecta.";
                }
            } else {
                $mensaje = "El usuario no existe.";
            }
        } else {
            $mensaje = "Error en la consulta: " . $conn->error;
        }
    } else {
        $mensaje = "Faltan datos de usuario o contraseña.";
    }

    header("Location: resultado2.php?mensaje=" . urlencode($mensaje));
    exit();
}

$conn->close();
?>
