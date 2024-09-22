<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú PHP</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }
        .menu {
            background-color: #333;
            overflow: hidden;
        }
        .menu a {
            float: left;
            display: block;
            color: white;
            text-align: center;
            padding: 14px 16px;
            text-decoration: none;
        }
        .menu a:hover {
            background-color: #ddd;
            color: black;
        }
        .content {
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="menu">
        <a href="?opcion=1">Opción 1</a>
        <a href="?opcion=2">Opción 2</a>
        <a href="?opcion=3">Opción 3</a>
        <a href="?opcion=4">Opción 4</a>
        <a href="?opcion=5">Opción 5</a>
        <a href="?opcion=6">Opción 6</a>
        <a href="?opcion=7">Opción 7</a>
        <a href="?opcion=8">Opción 8</a>
        <a href="?opcion=9">Opción 9</a>
        <a href="?opcion=10">Opción 10</a>
    </div>
    <div class="content">
        <?php
        if (isset($_GET['opcion'])) {
            $opcion = $_GET['opcion'];
            switch ($opcion) {
                case 1:
                    phpinfo();
                    break;
                case 2:
                    echo "Hola Mundo";
                    break;
                case 3:
                    echo "<b>Hola</b> Mundo!";
                    break;
                case 4:
                    $Name = "Miguel"; 
                    echo "Hola <b>$Name</b>, encantado de conocerte";
                    break;
                case 5:
                    session_start();
                    if (!isset($_SESSION['contador'])) {
                        $_SESSION['contador'] = 0;
                    }
                    $_SESSION['contador']++;
                    echo "Contador: " . $_SESSION['contador'];
                    break;
                case 6:
                    echo "Texto de la opción 6. Multiplicación: " . (7 * 2);
                    break;
                case 7:
                    echo "Texto de la opción 7. División: " . (20 / 4);
                    break;
                case 8:
                    echo "Texto de la opción 8. Módulo: " . (15 % 4);
                    break;
                case 9:
                    echo "Texto de la opción 9. Potencia: " . pow(2, 3);
                    break;
                case 10:
                    echo "Texto de la opción 10. Raíz cuadrada: " . sqrt(16);
                    break;
                default:
                    echo "Opción no implementada.";
                    break;
            }
        }
        ?>
    </div>
</body>
</html>
