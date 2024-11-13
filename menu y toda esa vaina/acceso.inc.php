<?php 
$dp = @mysqli_connect("localhost", "root", "", "agenda");

if (!$dp) {
    die("<p>No se ha podido establecer la conexión con MySQL.</p>");
}

if (!mysqli_select_db($dp, "agenda")) {
    die("<p>No se ha podido establecer la conexión con la base de datos.</p>");
}
?>
