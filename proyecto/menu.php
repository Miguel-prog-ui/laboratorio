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
            background: #fafafa; /* Fondo gris muy claro */
        }
        .header-bar {
            background: #333; /* Gris oscuro */
            height: 50px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 18px;
            color: white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .navbar {
            background-color: white; /* Blanco para minimalismo */
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .navbar a {
            color: #333; /* Gris oscuro */
            text-decoration: none;
            font-weight: bold;
            margin: 0 15px;
            font-size: 16px;
            transition: color 0.3s ease-in-out; /* Transición suave */
        }
        .navbar a:hover {
            color: #76C7C0; /* Verde claro al pasar el mouse */
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
            color: #333;
            background-color: #76C7C0; /* Fondo de resaltado */
            padding: 5px 10px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
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
        <a href="transferencia.php">Transferencia</a>
        <a href="pagos_servicios.php">Pagos de servicios</a>
        <a href="monda.html">Cerrar sesión</a>
    </div>
    <div class="container">
        <div class="welcome">
            <h2>Bienvenido al Menú Principal</h2>
            <p>Estamos encantados de verte de nuevo. Aquí puedes explorar diferentes opciones para encontrar exactamente lo que necesitas. <span class="highlight">¡Disfruta de tu experiencia!</span></p>
        </div>
    </div>
</body>
</html>
