<html> 
<head> 
 <title>Contador Sencillo</title> 
</head> 
<body> 
<h1>Contador Sencillo</h1> 
<p>Cantidad de visitas: 
<b> 
<?php 
 // Para el contador necesitamos un archivo de texto externo donde almacenamos 
 // las visitas 
 // Aqui se veran las funciones para trabajar con archivos, en este caso 
 // abrir, leer, grabar y cerrar. El contador simplemente se va sumando. 
 
 $fp = fopen("counter.txt", "r+"); 
 $counter = fgets($fp, 7); 
 echo $counter; 
 $counter ++; 
 rewind($fp); 
 fputs($fp, $counter); 
 fclose($fp); 
?> 
</b></p> 
</body> 
</html>