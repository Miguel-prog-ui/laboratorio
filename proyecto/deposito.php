<?php
session_start();
include 'db_connect.php'; // Conectar a la base de datos

// Obtener el nombre de usuario de la sesión
$nombreusuario = $_SESSION['nombreusuario'];
$message = ""; // Variable para el mensaje

// Procesar el formulario de depósito
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $monto = $_POST['monto'];
    $contraseña = $_POST['contraseña'];

    // Verificar la contraseña del usuario
    $sql = "SELECT contraseña FROM usuarios WHERE nombreusuario = '$nombreusuario'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($contraseña, $row['contraseña'])) {
            // Actualizar el saldo del usuario
            $sql = "UPDATE usuarios SET saldo = saldo + $monto WHERE nombreusuario = '$nombreusuario'";
            if ($conn->query($sql) === TRUE) {
                $message = "<h2 style='color: green;'>Depósito realizado con éxito. Saldo actualizado.</h2>";
            } else {
                $message = "<h2 style='color: red;'>Error al actualizar el saldo: " . $conn->error . "</h2>";
            }
        } else {
            $message = "<h2 style='color: red;'>Contraseña incorrecta.</h2>";
        }
    } else {
        $message = "<h2 style='color: red;'>Usuario no encontrado.</h2>";
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Depósito</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            color: #333;
            margin: 0;
            display: flex;
            flex-direction: column;
            height: 100vh;
            background: #f4f4f4; /* Fondo gris claro */
        }
        .header-bar {
            background: #76C7C0; /* Verde claro */
            height: 50px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 20px;
            color: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .navbar {
            background-color: #3A3A3A; /* Gris oscuro */
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .navbar a {
            color: white;
            text-decoration: none;
            font-weight: bold;
            margin: 0 10px;
            font-size: 16px;
        }
        .navbar a:first-child {
            font-size: 20px;
        }
        .navbar a:hover {
            color: #A8D5BA;
        }
        .container {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        .form-container {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
        }
        .form-container input[type="number"],
        .form-container input[type="password"],
        .form-container button {
            width: 100%;
            margin: 10px 0;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .form-container button {
            background-color: #76C7C0;
            color: white;
            border: none;
            cursor: pointer;
        }
        .form-container button:hover {
            background-color: #5AAEAA;
        }
    </style>
</head>
<body>
    <div class="header-bar">
        <span>DEPÓSITO</span>
    </div>
    <div class="navbar">
        <a href="menu.php">Inicio</a>
        <a href="saldo.php">Consultar Saldo</a>
        <a href="deposito.php">Depósito</a>
        <a href="#">Opción 3</a>
        <a href="#">Opción 4</a>
        <a href="monda.php">cerrar sesion</a>
    </div>
    <div class="container">
        <div class="form-container">
            <h2>Depositar Fondos</h2>
            <?php echo $message; ?> <!-- Mostrar el mensaje aquí -->
            <form method="POST" action="deposito.php">
                <input type="number" name="monto" placeholder="Monto a depositar" required>
                <input type="password" name="contraseña" placeholder="Contraseña" required>
                <button type="submit">Depositar</button>
            </form>
        </div>
    </div>
</body>
</html>
