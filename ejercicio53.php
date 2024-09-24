<html> 
<head> 
<title>Problema</title> 
</head> 
<body> 
<?php 
$conexion=mysql_connect("localhost","root","z80") or 
 die("Problemas en la conexion"); 
mysql_select_db("phpfacil",$conexion) or 
 die("Problemas en la selección de la base de datos"); 
$registros=mysql_query("select count(alu.codigo) as cantidad, 
 nombrecur from alumnos as alu 
 inner join cursos as cur on cur.codigo=alu.codigocurso 
 group by alu.codigocurso", $conexion) or 
 die("Problemas en el select:".mysql_error()); 
while ($reg=mysql_fetch_array($registros)) 
{ 
 echo "Nombre del curso:".$reg['nombrecur']."<br>"; 
 echo "Cantidad de inscriptos:".$reg['cantidad']."<br>"; 
 echo "<hr>"; 
} 
mysql_close($conexion); 
?> 
</body> 
</html>
