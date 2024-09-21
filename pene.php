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
    <script>
        function showContent(option) {
            let content = document.getElementById('content');
            let text = '';
            let result = '';

            switch(option) {
                case 'exercise1':
                    text = 'Ejercicio 1 seleccionado.';
                    result = '1 + 1 = ' + (1 + 1);
                    break;
                case 'exercise2':
                    text = 'Ejercicio 2 seleccionado.';
                    result = '2 * 2 = ' + (2 * 2);
                    break;
                case 'exercise3':
                    text = 'Ejercicio 3 seleccionado.';
                    result = '3 - 1 = ' + (3 - 1);
                    break;
                case 'exercise4':
                    text = 'Ejercicio 4 seleccionado.';
                    result = '4 / 2 = ' + (4 / 2);
                    break;
                case 'exercise5':
                    text = 'Ejercicio 5 seleccionado.';
                    result = '5 + 5 = ' + (5 + 5);
                    break;
                case 'exercise6':
                    text = 'Ejercicio 6 seleccionado.';
                    result = '6 * 6 = ' + (6 * 6);
                    break;
                case 'exercise7':
                    text = 'Ejercicio 7 seleccionado.';
                    result = '7 - 3 = ' + (7 - 3);
                    break;
                case 'exercise8':
                    text = 'Ejercicio 8 seleccionado.';
                    result = '8 / 4 = ' + (8 / 4);
                    break;
                case 'exercise9':
                    text = 'Ejercicio 9 seleccionado.';
                    result = '9 + 9 = ' + (9 + 9);
                    break;
                case 'exercise10':
                    text = 'Ejercicio 10 seleccionado.';
                    result = '10 * 10 = ' + (10 * 10);
                    break;
                default:
                    text = 'Selecciona un ejercicio del menú.';
                    result = '';
            }

            content.innerHTML = `<p>${text}</p><p>${result}</p>`;
        }
    </script>
</head>
<body onload="showContent()">
    <nav>
        <a href="javascript:void(0)" onclick="showContent('exercise1')">Ejercicio 1</a>
        <a href="javascript:void(0)" onclick="showContent('exercise2')">Ejercicio 2</a>
        <a href="javascript:void(0)" onclick="showContent('exercise3')">Ejercicio 3</a>
        <a href="javascript:void(0)" onclick="showContent('exercise4')">Ejercicio 4</a>
        <a href="javascript:void(0)" onclick="showContent('exercise5')">Ejercicio 5</a>
        <a href="javascript:void(0)" onclick="showContent('exercise6')">Ejercicio 6</a>
        <a href="javascript:void(0)" onclick="showContent('exercise7')">Ejercicio 7</a>
        <a href="javascript:void(0)" onclick="showContent('exercise8')">Ejercicio 8</a>
        <a href="javascript:void(0)" onclick="showContent('exercise9')">Ejercicio 9</a>
        <a href="javascript:void(0)" onclick="showContent('exercise10')">Ejercicio 10</a>
    </nav>
    <div id="content">
        <p>Selecciona un ejercicio del menú.</p>
    </div>
</body>
</html>
