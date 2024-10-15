<?php 

$nombre=$_POST['nombre'];
$apellido=$_POST['apellido'];
$cedula=$_POST['cedula'];
$deportes=$_POST['deportes'];
$equipos=$_POST['equipos'];

$conexion = new mysqli("localhost", "root", "", "parcial");

    //Verificamos si hay algun error en la conexion
    if ($conexion->connect_error)
     {
        die("Falló la conexión con MySQL: (" . $mysqli->connect_error . ") " . $mysqli->connect_error);
    }

            // Preparar la consulta
            $insertar = "INSERT INTO usuarios (nombre, apellido, cedula, deportes, equipos) VALUES ('$nombre', '$apellido',$cedula, '$deportes', '$equipos')";
              // Consulta SQL para obtener todas las direcciones
            $sql = "SELECT * FROM usuarios";

    // Ejecutar la consulta
    if ($resultado = $conexion->query($sql)) {
        // Iterar sobre los resultados y mostrar los nombres y apellidos
        while ($row = $resultado->fetch_assoc()) {
            echo "{$row['nombre']} {$row['apellido']} {$row['cedula']} {$row['deportes']} {$row['equipos']}<br>\n";
        }
    }

    echo "<h2>Mostrando con ciclo for</h2>";
    // Mostrar los resultados usando for
    while ($row = $resultado->fetch_assoc()) {
        echo "<tr>"; // Crear fila
        foreach ($row as $key=>$value) {
            echo "<td>" . htmlspecialchars($value) . "&nbsp;</td>"; 
        }
        echo "</tr>\n"; // Cerrar fila
    }
    echo "</table>\n"; // Cerrar tabla
?>