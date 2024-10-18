<?php
session_start();
include 'db_connect.php'; // Conectar a la base de datos

// Obtener el nombre de usuario de la sesión
$nombreusuario = $_SESSION['nombreusuario'];

// Consulta para obtener el saldo del usuario
$sql = "SELECT saldo FROM usuarios WHERE nombreusuario = '$nombreusuario'";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú</title>
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
        .saldo {
            font-size: 50px;
            color: #4CAF50;
        }
        .header {
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
        }
        .highlight {
            color: #76C7C0; /* Color verde */
        }
        .error {
            font-size: 20px;
            color: red;
        }
    </style>
</head>
<body>
    <div class="header-bar">
        <span>CONSULTAR SALDO</span>
    </div>
    <div class="navbar">
        <a href="menu.php">Inicio</a>
        <a href="saldo.php">Consultar Saldo</a>
        <a href="deposito.php">Deposito</a>
        <a href="#">Opción 3</a>
        <a href="#">Opción 4</a>
        <a href="monda.html">cerrar sesion</a>
    </div>
    <div class="container">
        <?php
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $saldo = $row['saldo'];
            echo "<div class='header'>Saldo</div>";
            echo "<div class='saldo'>$$saldo</div>";
        } else {
            echo "<div class='header highlight'>No se encontró el saldo del usuario.</div>";
        }
        $conn->close();
        ?>
    </div>
</body>
</html>
