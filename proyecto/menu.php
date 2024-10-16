<?php
session_start();
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
            background: white;
        }
        .header-bar {
            background: #76C7C0; /* Verde uniforme */
            height: 40px; /* Más ancha */
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 20px;
            color: white;
        }
        .navbar {
            background-color: black;
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
            font-size: 16px; /* Tamaño de la tipografía */
        }
        .navbar a:first-child {
            font-size: 20px; /* Tamaño más grande para "Inicio" */
        }
        .navbar a:hover {
            color: #76C7C0;
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
            color: #76C7C0; /* Color verde */
        }
        button {
            margin: 10px 0;
            padding: 15px;
            width: 100%;
            max-width: 320px;
            border: 1px solid #ccc;
            border-radius: 30px;
            background-color: #76C7C0;
            color: white;
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #5AAEAA;
        }
    </style>
</head>
<body>
    <div class="header-bar">
        <span>BIENVENIDO A NUESTRO BANCO</span>
    </div>
    <div class="navbar">
        <a href="#">Inicio</a>
        <a href="#">Opción 1</a>
        <a href="#">Opción 2</a>
        <a href="#">Opción 3</a>
        <a href="#">Opción 4</a>
        <a href="#">Opción 5</a>
    </div>
    <div class="container">
        <div class="welcome">
            <h2>Bienvenido al Menú Principal</h2>
            <p>Estamos encantados de verte de nuevo. Aquí puedes explorar diferentes opciones para encontrar exactamente lo que necesitas. <span class="highlight">¡Disfruta de tu experiencia!</span></p>
        </div>
    </div>
    <script>
        function showMessage(message) {
            document.body.innerHTML = '<h2 style="text-align: center; margin-top: 20px;">' + message + '</h2>';
        }
    </script>
</body>
</html>
