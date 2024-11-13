<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resultado de la Consulta</title>
</head>
<body>
<?php
$host = "localhost";
$usuario = "root";
$bd = "phpfacil";

$conexion = new mysqli($host, $usuario, "", $bd); // Conexión sin contraseña

if ($conexion->connect_error) {
    die("Problemas en la conexión: " . $conexion->connect_error);
}

if (isset($_POST['mail']) && !empty($_POST['mail'])) {
    $mail = $conexion->real_escape_string($_POST['mail']);
    $query = "SELECT codigo, nombre, codigocurso FROM alumnoss WHERE mail='$mail'";
    $resultado = $conexion->query($query);

    if ($resultado->num_rows > 0) {
        while ($reg = $resultado->fetch_assoc()) {
            echo "Nombre: " . htmlspecialchars($reg['nombre']) . "<br>";
            echo "Curso: ";
            switch ($reg['codigocurso']) {
                case 1:
                    echo "PHP";
                    break;
                case 2:
                    echo "ASP";
                    break;
                case 3:
                    echo "JSP";
                    break;
                default:
                    echo "Desconocido";
                    break;
            }
            echo "<br>";
        }
    } else {
        echo "No existe un alumno con ese mail.";
    }
} else {
    echo "Faltan datos para insertar.";
}

$conexion->close();
?>
</body>
</html>
