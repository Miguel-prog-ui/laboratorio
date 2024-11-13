<!DOCTYPE html>
<html>
<head>
    <title>Tabla de Multiplicar</title>
</head>
<body>
<?php
if (isset($_GET['tabla'])) {
    $tabla = intval($_GET['tabla']);
    echo "<h1>Tabla del $tabla</h1>";
    for ($i = 1; $i <= 10; $i++) {
        $resultado = $tabla * $i;
        echo "$tabla x $i = $resultado<br>";
    }

} 
else 
{
    echo "No se ha especificado ninguna tabla.";
}
?>
</body>
</html>