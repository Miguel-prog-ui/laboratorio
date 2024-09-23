<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ejemplo de Operadores Lógicos</title>
</head>
<body>
    <h1>Ejemplo de Operaciones Lógicas en PHP</h1>
    <p> El programa comparara algunas numeros y dependiendo de la comparacion dira si es falso o verdadero
    <p>
    <?php
    // Declaración de variables
    $a = 8;
    $b = 3;
    $c = 3;

    // Primera operación lógica: AND
    // Verifica si $a es igual a $b y si $c es mayor que $b
    echo "Compara si 8 es igual a 3 y si 3 es mayor a 3 ", "<br>";
    echo ($a == $b) && ($c > $b) ? 'true' : 'false';
    echo "<br>";

    // Segunda operación lógica: OR
    // Verifica si $a es igual a $b o si $b es igual a $c
    echo "Compara si 8 es igual a 3 o  si 3 es igual a 3 ", "<br>";
    echo ($a == $b) || ($b == $c) ? 'true' : 'false';
    echo "<br>";

    // Tercera operación lógica: NOT
    // Verifica si $b no es menor o igual a $c
    echo "Compara si 3 es igual o mayor a 3 ", "<br>";
    echo !($b <= $c) ? 'true' : 'false';
    echo "<br>";
    ?>

</body>


</html>