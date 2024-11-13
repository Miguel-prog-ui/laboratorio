<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<h1>Libro de visitas</h1> 
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" 
Tu comentario:<br> 
<textarea cols="55" rows="4" name="comment"></textarea><br> 
Tu nombre:<br> 
<input type="text" name="name"><br> 
Tu e-mail:<br> 
<input type="text" name="email"><br> 
<input type="submit" value="publica:"> 
</form> 
<h3>Mostrar todos los comentarios</h3>
</body>
</html>
<?php 
//Guarda el nombre del archivo en la variable 
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
            $entry="<p><b>$name</b> ($email) wrote on <i>$dateOfEntry</i>;<br>$comment</p>\n"; 
        //El cursor invisible salta al principio 
            rewind($fp); 
        //Escribir en la nueva entrada antes de las antiguas en el archivo: 
            fputs($fp, "$entry \n $old"); 
        //cerrar rl archivo 
            fclose($fp); 
} 
//Mostrar el archivo completo 
    readfile($file); 
?> 
</body> 
</html>