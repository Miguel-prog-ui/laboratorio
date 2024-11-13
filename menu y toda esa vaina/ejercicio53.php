<html> 
<head> 
<title>Problema</title> 
</head> 
<body> 
<?php 
$conexion = new mysqli("localhost", "root", "", "phpfacil");

if ($conexion->connect_error) {
    die("Problemas en la conexión: " . $conexion->connect_error);
}

$sql = "SELECT COUNT(alu.codigo) AS cantidad, nombrecur 
        FROM alumnoss AS alu 
        INNER JOIN cursos AS cur ON cur.codigo = alu.codigocurso 
        GROUP BY alu.codigocurso";

if ($result = $conexion->query($sql)) {
    while ($reg = $result->fetch_assoc()) {
        echo "Nombre del curso: " . $reg['nombrecur'] . "<br>";
        echo "Cantidad de inscriptos: " . $reg['cantidad'] . "<br>";
        echo "<hr>";
    }
    $result->free();
} else {
    die("Problemas en el select: " . $conexion->error);
}

$conexion->close();
?> 
</body> 
</html>
