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
                case 'home':
                    text = 'Bienvenido a la página de inicio.';
                    result = '2 + 2 = ' + (2 + 2);
                    break;
                case 'services':
                    text = 'Estos son nuestros servicios.';
                    result = '5 * 3 = ' + (5 * 3);
                    break;
                case 'about':
                    text = 'Acerca de nosotros.';
                    result = '10 / 2 = ' + (10 / 2);
                    break;
                case 'contact':
                    text = 'Contáctanos aquí.';
                    result = '8 - 4 = ' + (8 - 4);
                    break;
                case 'blog':
                    text = 'Bienvenido a nuestro blog.';
                    result = '7 + 6 = ' + (7 + 6);
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
        <a href="javascript:void(0)" onclick="showContent('home')">Inicio</a>
        <a href="javascript:void(0)" onclick="showContent('services')">Servicios</a>
        <a href="javascript:void(0)" onclick="showContent('about')">Acerca de</a>
        <a href="javascript:void(0)" onclick="showContent('contact')">Contacto</a>
        <a href="javascript:void(0)" onclick="showContent('blog')">Blog</a>
    </nav>
    <div id="content">
        <p>Selecciona una opción del menú.</p>
    </div>
</body>
</html>
