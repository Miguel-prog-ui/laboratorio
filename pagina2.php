<html>
<head>
    <title>Problema</title>
</head>
<body>
<?php 
$host = "localhost";
$bd = "agenda";
$usuario = "root";
$contra = "";

try {
    // Crear la conexión
    $conexion = new PDO("mysql:host=$host;dbname=$bd", $usuario, $contra);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 

    // Comprobar que los datos se han enviado
    if (isset($_REQUEST['nombre']) && isset($_REQUEST['mail']) && isset($_REQUEST['codigocurso'])) {
        // Preparar la consulta
        $sentenciaSQL = $conexion->prepare("INSERT INTO alumnos (nombre, mail, codigocurso) VALUES (:nombre, :mail, :codigocurso)");
        
        // Vincular los parámetros
        $sentenciaSQL->bindParam(':nombre', $_REQUEST['nombre']);
        $sentenciaSQL->bindParam(':mail', $_REQUEST['mail']);
        $sentenciaSQL->bindParam(':codigocurso', $_REQUEST['codigocurso']);
        
        // Ejecutar la consulta
        $sentenciaSQL->execute();
        
        echo "El alumno fue dado de alta.";
    } else {
        echo "Faltan datos para insertar.";
    }
} catch (PDOException $ex) {
    echo "Error de conexión: " . $ex->getMessage();
}
?>
</body>
</html>