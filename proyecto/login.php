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
        $sql = "SELECT contraseña FROM usuarios WHERE nombreusuario='$nombreusuario'";
        $result = $conn->query($sql);

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
                    echo "<h2 style='text-align: center;'>La contraseña es incorrecta</h2>";
                    echo "<p style='text-align: center;'><a href='monda.html'>Volver a intentar</a></p>";
                } 
            } else {
                echo "<h2 style='text-align: center;'>El usuario no existe</h2>";
                echo "<p style='text-align: center;'><a href='monda.html'>Volver a intentar</a></p>";
            }
        } else {
            echo "Error en la consulta: " . $conn->error;
        }
    } else {
        echo "<h2 style='text-align: center;'>Faltan datos de usuario o contraseña.</h2>";
    }
}

$conn->close();
?>