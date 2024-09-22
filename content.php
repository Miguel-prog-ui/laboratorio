<?php
$exercise = isset($_GET['exercise']) ? $_GET['exercise'] : '';

switch($exercise) {
    case '1':
        $text = 'Ejercicio 1 seleccionado.';
        phpinfo();
        exit;
    case '2':
        $text = 'Ejercicio 2 seleccionado.';
        $result = 'Hola mundo';
        break;
    case '3':
        $text = 'Ejercicio 3 seleccionado.';
        $result = '<b>Hola</b> Mundo!';
        break;
    case '4':
        $name = 'Miguel';
        $text = 'Ejercicio 4 seleccionado.';
        $result = 'Hola ' . $name;
        break;
    case '5'://29
        echo "<h1>Contador sencillo</h1>";
        $fp = fopen("counter.txt", "r+"); 
     $counter = fgets($fp, 7); 
     echo $counter; 
     $counter ++; 
     rewind($fp); 
     fputs($fp, $counter); 
     fclose($fp);
        break;
        
    case '6':
        $file ="guestbook.txt"; 
        //¿variable comment definida? ¿Nombre e e-mail no estan vacios? 
        //if isset($_POST['comment']) && $_POST['name'] ! = "" && $_POST['email'] != "" { 
         if (isset($_POST['comment']) && isset($_POST['name']) != "" && $_POST['email'] != "") { 
         $comment = $_POST['comment']; 
         $name = $_POST['name']; 
         $email = $_POST['email']; 
         //El archivo se abre para escritura-lectura 
         $fp = fopen($file, "r+"); 
         //Leer todos los datos y almacenar en $old
         $old = fread ($fp, filesize($file)); 
         //Se crea el vinculo de e-mail 
         $email = "<a href=\mailto:$email\">$email</a>"; 
         //Se incluye la fecha y se le da formato 
         $dateOfEntry = date ("y-n-j"); 
         //Ocultar caracteres html, eliminar slashes, mantener saltos de linea 
         $comment = htmlspecialchars($comment); 
        // $comment = stripslashes(n12br($comment)); 
         $comment = stripslashes($comment); 
         //"Montar la entrada (entry) del libro de visitas 
         $entry="<p><b>$name</b> ($email) wrote on <i>$dateOfentry</i>;<br>$comment</p>\n"; 
         //El cursor invisible salta al principio 
         rewind($fp); 
         //Escribir en la nueva entrada antes de las antiguas en el archivo: 
         fputs($fp, "$entry \n $old"); 
         //cerrar rl archivo 
         fclose($fp); 
        } 
        //Mostrar el archivo completo 
        readfile($file);
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
    <div id='content'>
        <p>{$text}</p>
        <p>{$result}</p>
    </div>
</body>
</html>";
?>
