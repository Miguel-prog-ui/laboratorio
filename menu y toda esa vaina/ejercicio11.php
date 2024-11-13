<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ejemplo de Operadores de Comparación</title>
</head>
<body>
    <h1>Ejemplo de Operaciones de Comparación en PHP</h1>
    <?php
    // Declaración de variables
    $a = 8;
    $b = 3;
    $c = 3;

    // Comparación de igualdad

    echo "Compara si 8 es igual a 3 ", "<br>";
    echo $a = $b ? 'false' : 'true'; // 8 = 3 es false
    echo "<br>";

    // Comparación de desigualdad
    echo "Compara si 8 es diferente a 3 ", "<br>";
    echo $a != $b ? 'true' : 'false'; // 8 != 3 es true
    echo "<br>";

    // Comparación menor que
    echo "Compara si 8 es menor a 3 ", "<br>";
    echo $a < $b ? 'true' : 'false'; // 8 < 3 es false
    echo "<br>";

    // Comparación mayor que
    echo "Compara si 8 es mayor a 3 ", "<br>";
    echo $a > $b ? 'true' : 'false'; // 8 > 3 es true
    echo "<br>";

    // Comparación mayor o igual que
    echo "Compara si 8 es mayor o igual a 3 ", "<br>";
    echo $a >= $c ? 'true' : 'false'; // 8 >= 3 es true
    echo "<br>";

    // Comparación menor o igual que
    echo "Compara si 8 es menor o igual a 3 ", "<br>";
    echo $a <= $c ? 'true' : 'false'; // 8 <= 3 es false
    echo "<br>";
    ?>
</body>
</html>
