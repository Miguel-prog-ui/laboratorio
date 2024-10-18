<?php session_start(); ?>
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
        .welcome {
            text-align: center;
            margin-bottom: 20px;
        }
        .highlight {
            color: #A8D5BA;
        }
    </style>
</head>
<body>
    <div class="header-bar">
        <span>BIENVENIDO A NUESTRO BANCO</span>
    </div>
    <div class="navbar">
        <a href="#">Inicio</a>
        <a href="saldo.php">Consultar Saldo</a>
        <a href="deposito.php">Depósito</a>
        <a href="#">Opción 3</a>
        <a href="#">Opción 4</a>
        <a href="monda.html">cerrar sesion</a>
    </div>
    <div class="container">
        <div class="welcome">
            <h2>Bienvenido al Menú Principal</h2>
            <p>Estamos encantados de verte de nuevo. Aquí puedes explorar diferentes opciones para encontrar exactamente lo que necesitas. <span class="highlight">¡Disfruta de tu experiencia!</span></p>
        </div>
    </div>
</body>
</html>
