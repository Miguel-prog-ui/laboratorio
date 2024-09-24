<?php 
if (isset($_REQUEST['pos'])) 
    $inicio = $_REQUEST['pos']; 
else 
    $inicio = 0; 
?> 
<html> 
<head> 
<title>Problema</title> 
</head> 
<body> 
<?php 
$conexion = new mysqli("localhost", "root", "z80", "phpfacil");

if ($conexion->connect_error) {
    die("Problemas en la conexión: " . $conexion->connect_error);
}

$sql = "SELECT alu.codigo AS codigo, nombre, mail, codigocurso, nombrecur 
        FROM alumnos AS alu 
        INNER JOIN cursos AS cur ON cur.codigo = alu.codigocurso 
        LIMIT ?, 2";

$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $inicio);
$stmt->execute();
$result = $stmt->get_result();

$impresos = 0;
while ($reg = $result->fetch_assoc()) {
    $impresos++;
    echo "Codigo: " . $reg['codigo'] . "<br>";
    echo "Nombre: " . $reg['nombre'] . "<br>";
    echo "Mail: " . $reg['mail'] . "<br>";
    echo "Curso: " . $reg['nombrecur'] . "<br>";
    echo "<hr>";
}

$stmt->close();
$conexion->close();

if ($inicio == 0) {
    echo "anteriores ";
} else {
    $anterior = $inicio - 2;
    echo "<a href=\"pagina1.php?pos=$anterior\">Anteriores </a>";
}

if ($impresos == 2) {
    $proximo = $inicio + 2;
    echo "<a href=\"pagina1.php?pos=$proximo\">Siguientes</a>";
} else {
    echo "siguientes";
}
?> 
</body> 
</html>
3