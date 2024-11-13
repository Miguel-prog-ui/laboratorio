<html> 
<head> 
<title>Un pequeño mailer para recopilar la opinión</title> 
<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1"> 
</head> 
<body> 
<h1>Feedback-Mailer</h1> 
<p>¡Envíame un e-mail!</p> 
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post"> 
Tu dirección de e-mail: <br> 
<input type="text" name="Mail"><br> 
Tu comentario: <br> 
<textarea name="message" cols="50" rows="5"></textarea><br> 
<input type="submit" value="Enviar"> 
</form> 
<?php 
$receiverMail = "tudireccion@tudominio.es"; // escribe aquí tu dirección 
if (isset($_POST['Mail']) && $_POST['Mail'] != "") { 
    $mail = filter_var($_POST['Mail'], FILTER_VALIDATE_EMAIL);
    if ($mail) {
        $subject = "¡Tienes correo nuevo!";
        $message = $_POST['message'];
        $headers = "From: $mail";
        
        // Mensajes de depuración
        echo "<p>Mail: $mail</p>";
        echo "<p>Subject: $subject</p>";
        echo "<p>Message: $message</p>";
        echo "<p>Headers: $headers</p>";
        
        if (mail($receiverMail, $subject, $message, $headers)) { 
            echo "<p>Gracias por enviarme tu opinión.</p>\n";
        } else { 
            echo "<p>Lo siento, ha ocurrido un error al enviar el correo.</p>\n";
        } 
    } else {
        echo "<p>Por favor, introduce una dirección de correo electrónico válida.</p>\n";
    }
} else {
    echo "<p>Por favor, completa todos los campos.</p>\n";
}
?> 
</body> 
</html>

