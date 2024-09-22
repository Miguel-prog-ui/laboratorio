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
        form {
            display: flex;
            flex-direction: column;
            max-width: 300px;
            margin: auto;
        }
        label, input, textarea {
            margin-bottom: 10px;
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
                    // Opción 1: Muestra la información de PHP
                    phpinfo();
                    break;
                case 2:
                    // Opción 2: Imprime "Hola Mundo"
                    echo "Hola Mundo";
                    break;
                case 3:

                    echo  "<b>Hola</b> Mundo!";
                    break;
                case 4:
                    $Name = "Miguel"; 
                    echo "Hola <b>$Name</b>, encantado de conocerte";
                    break;
                case 5:
                    // Opción 3: Incrementa y muestra un contador de sesiones
                    session_start();
                    if (!isset($_SESSION['contador'])) {
                        $_SESSION['contador'] = 0;
                    }
                    $_SESSION['contador']++;
                    echo "Contador: " . $_SESSION['contador'];
                    break;
                case 6:
                    // Opción 6: Formulario para ingresar comentario, nombre y correo electrónico
                    echo '<h1>Libro de visitas</h1>';
                    if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['comment']) && !empty($_POST['name']) && !empty($_POST['email'])) {
                        $comment = htmlspecialchars($_POST['comment']);
                        $name = htmlspecialchars($_POST['name']);
                        $email = htmlspecialchars($_POST['email']);
                        $dateOfEntry = date("Y-n-j");
                        $entry = "<p><b>$name</b> (<a href=\"mailto:$email\">$email</a>) escribió el <i>$dateOfEntry</i>:<br>$comment</p>\n";
                        // Guarda la entrada en el archivo guestbook.txt
                        file_put_contents('guestbook.txt', $entry, FILE_APPEND);
                        echo "Datos guardados.<br>";
                    }
                    // Formulario para ingresar datos
                    echo '<form method="post" action="?opcion=6">
                            <label for="comment">Tu comentario:</label>
                            <textarea id="comment" name="comment" cols="55" rows="4" required></textarea><br>
                            <label for="name">Tu nombre:</label>
                            <input type="text" id="name" name="name" required><br>
                            <label for="email">Tu e-mail:</label>
                            <input type="email" id="email" name="email" required><br>
                            <input type="submit" value="Publicar">
                          </form>';
                    // Muestra todos los comentarios guardados en guestbook.txt
                    echo '<h3>Mostrar todos los comentarios</h3>';
                    if (file_exists('guestbook.txt')) {
                        echo nl2br(file_get_contents('guestbook.txt'));
                    }
                    break;
                case 7:
                    // Opción 7: Imprime un texto y realiza una división
                    echo "Texto de la opción 7. División: " . (20 / 4);
                    break;
                case 8:
                    // Opción 8: Imprime un texto y calcula el módulo
                    echo "Texto de la opción 8. Módulo: " . (15 % 4);
                    break;
                case 9:
                    // Opción 9: Imprime un texto y calcula una potencia
                    echo "Texto de la opción 9. Potencia: " . pow(2, 3);
                    break;
                case 10:
                    // Opción 10: Imprime un texto y calcula una raíz cuadrada
                    echo "Texto de la opción 10. Raíz cuadrada: " . sqrt(16);
                    break;
                default:
                    // Opción por defecto: Mensaje de opción no implementada
                    echo "Opción no implementada.";
                    break;
            }
        }
        ?>
    </div>
</body>
</html>