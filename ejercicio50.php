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

$sql = "SELECT alu.codigo AS codigo, nombre, mail, codigocurso, nombrecur 
        FROM alumnoss AS alu 
        INNER JOIN cursos AS cur ON cur.codigo = alu.codigocurso";

if ($result = $conexion->query($sql)) {
    while ($reg = $result->fetch_assoc()) {
        echo "Codigo: " . $reg['codigo'] . "<br>";
        echo "Nombre: " . $reg['nombre'] . "<br>";
        echo "Mail: " . $reg['mail'] . "<br>";
        echo "Curso: " . $reg['nombrecur'] . "<br>";
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
