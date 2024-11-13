<html>
<head>
<title>Problema</title>
</head>
<body>
<?php 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los valores del formulario
    $dia = $_POST['dia'];
    $mes = $_POST['mes'];
    $anio = $_POST['anio'];

    // Convertir los valores a enteros
    $dia = (int)$dia;
    $mes = (int)$mes;
    $anio = (int)$anio;

    // Validar la fecha
    if (checkdate($mes, $dia, $anio)) {
        echo "La fecha es válida.";
    } else {
        echo "La fecha no es válida.";
    }
}

   

?>
<a href="ejercicio66.php">volver para ingresar fecha</a>
</body>
</html>