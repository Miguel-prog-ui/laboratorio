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
                case 'option1':
                    text = 'Opción 1 seleccionada.';
                    result = '1 + 1 = ' + (1 + 1);
                    break;
                case 'option2':
                    text = 'Opción 2 seleccionada.';
                    result = '2 * 2 = ' + (2 * 2);
                    break;
                case 'option3':
                    text = 'Opción 3 seleccionada.';
                    result = '3 - 1 = ' + (3 - 1);
                    break;
                case 'option4':
                    text = 'Opción 4 seleccionada.';
                    result = '4 / 2 = ' + (4 / 2);
                    break;
                case 'option5':
                    text = 'Opción 5 seleccionada.';
                    result = '5 + 5 = ' + (5 + 5);
                    break;
                case 'option6':
                    text = 'Opción 6 seleccionada.';
                    result = '6 * 6 = ' + (6 * 6);
                    break;
                case 'option7':
                    text = 'Opción 7 seleccionada.';
                    result = '7 - 3 = ' + (7 - 3);
                    break;
                case 'option8':
                    text = 'Opción 8 seleccionada.';
                    result = '8 / 4 = ' + (8 / 4);
                    break;
                case 'option9':
                    text = 'Opción 9 seleccionada.';
                    result = '9 + 9 = ' + (9 + 9);
                    break;
                case 'option10':
                    text = 'Opción 10 seleccionada.';
                    result = '10 * 10 = ' + (10 * 10);
                    break;
                default:
                    text = 'Selecciona una opción del menú.';
                    result = '';
            }

            content.innerHTML = `<p>${text}</p><p>${result}</p>`;
        }
    </script>
</head>
<body onload="showContent()">
    <nav>
        <a href="javascript:void(0)" onclick="showContent('option1')">Opción 1</a>
        <a href="javascript:void(0)" onclick="showContent('option2')">Opción 2</a>
        <a href="javascript:void(0)" onclick="showContent('option3')">Opción 3</a>
        <a href="javascript:void(0)" onclick="showContent('option4')">Opción 4</a>
        <a href="javascript:void(0)" onclick="showContent('option5')">Opción 5</a>
        <a href="javascript:void(0)" onclick="showContent('option6')">Opción 6</a>
        <a href="javascript:void(0)" onclick="showContent('option7')">Opción 7</a>
        <a href="javascript:void(0)" onclick="showContent('option8')">Opción 8</a>
        <a href="javascript:void(0)" onclick="showContent('option9')">Opción 9</a>
        <a href="javascript:void(0)" onclick="showContent('option10')">Opción 10</a>
    </nav>
    <div id="content">
        <p>Selecciona una opción del menú.</p>
    </div>
</body>
</html>
