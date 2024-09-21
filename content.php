<?php
$exercise = isset($_GET['exercise']) ? $_GET['exercise'] : '';

switch($exercise) {
    case '1':
        phpinfo();
        exit;
    case '2':
        $text = 'Ejercicio 2 seleccionado.';
        $result = '2 * 2 = ' . (2 * 2);
        break;
    case '3':
        $text = 'Ejercicio 3 seleccionado.';
        $result = '3 - 1 = ' . (3 - 1);
        break;
    case '4':
        $text = 'Ejercicio 4 seleccionado.';
        $result = '4 / 2 = ' . (4 / 2);
        break;
    case '5':
        $text = 'Ejercicio 5 seleccionado.';
        $result = '5 + 5 = ' . (5 + 5);
        break;
    case '6':
        $text = 'Ejercicio 6 seleccionado.';
        $result = '6 * 6 = ' . (6 * 6);
        break;
    case '7':
        $text = 'Ejercicio 7 seleccionado.';
        $result = '7 - 3 = ' . (7 - 3);
        break;
    case '8':
        $text = 'Ejercicio 8 seleccionado.';
        $result = '8 / 4 = ' . (8 / 4);
        break;
    case '9':
        $text = 'Ejercicio 9 seleccionado.';
        $result = '9 + 9 = ' . (9 + 9);
        break;
    case '10':
        $text = 'Ejercicio 10 seleccionado.';
        $result = '10 * 10 = ' . (10 * 10);
        break;
    default:
        $text = 'Selecciona un ejercicio del menú.';
        $result = '';
}

echo "<!DOCTYPE html>
<html lang='es'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Resultado del Ejercicio</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        #content {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <nav>
        <a href='index.html'>Volver al Menú</a>
    </nav>
    <div id='content'>
        <p>{$text}</p>
        <p>{$result}</p>
    </div>
</body>
</html>";
?>
