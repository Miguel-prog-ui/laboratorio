<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú de Navegación</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        nav {
            background-color: #333;
            overflow: hidden;
        }
        nav a {
            float: left;
            display: block;
            color: white;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }
        nav a:hover {
            background-color: #ddd;
            color: black;
        }
        #content {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <nav>
        <a href="content.php?exercise=1">Ejercicio 1</a>
        <a href="content.php?exercise=2">Ejercicio 2</a>
        <a href="content.php?exercise=3">Ejercicio 3</a>
        <a href="content.php?exercise=4">Ejercicio 4</a>
        <a href="content.php?exercise=5">Ejercicio 5</a>
        <a href="content.php?exercise=6">Ejercicio 6</a>
        <a href="content.php?exercise=7">Ejercicio 7</a>
        <a href="content.php?exercise=8">Ejercicio 8</a>
        <a href="content.php?exercise=9">Ejercicio 9</a>
        <a href="content.php?exercise=10">Ejercicio 10</a>
    </nav>
    <div id="content">
        <p>Selecciona un ejercicio del menú.</p>
    </div>
</body>
</html>
