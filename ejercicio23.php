<html> 
<head> 
 <title>Uso de Librerias y Funciones</title> 
</head> 
<body> 
<?php 
 function CabeceraPagina() 
 { 
?> 
 <FONT SIZE="+1">Esta cabecera estará en todas sus páginas.</FONT><BR> 
 <hr> 
<?php 
 } 
 function PiePagina() 
 { 
?> 
 <hr> 
 <FONT SIZE="-1">Este es el pie de página.</FONT><BR> 
 Autor: Joaquin Gracia 
<?php 
 } 
?> 

<?php 
 CabeceraPagina(); 
 PiePagina(); 
?> 
</body> 
</html>
