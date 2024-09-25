<!DOCTYPE html>
<html>
<head>
    <title>MySQL 02 - Consulta BD con tabla (Agenda)</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
<h1>MySQL 02 - Consulta BD con tabla (Agenda)</h1>

<?php
// Conectar a la base de datos
$conexion = new mysqli("localhost", "root", "", "agenda");

// Verificar la conexión
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

// Realizar la consulta
$sql = "SELECT * FROM direccioness";
$resultado = $conexion->query($sql);

// Verificar si hay resultados
if ($resultado->num_rows > 0) {
    echo "<p>Cantidad de filas: " . $resultado->num_rows . "</p>\n";
    echo "<table>\n"; // Empezar tabla
    echo "<tr>"; // Crear fila de encabezado

    // Obtener nombres de columnas
    $columnas = $resultado->fetch_fields();
    foreach ($columnas as $columna) {
        echo "<th>{$columna->name}</th>";
    }
    echo "</tr>\n"; // Cerrar fila de encabezado

    // Mostrar los resultados
    while ($row = $resultado->fetch_assoc()) {
        echo "<tr>"; // Crear fila
        foreach ($row as $valor) {
            echo "<td>" . htmlspecialchars($valor) . " </td>"; 
        }
        echo "</tr>\n"; // Cerrar fila
    }
    echo "</table>\n"; // Cerrar tabla
} else {
    echo "<p>No se encontraron registros.</p>";
}

// Cerrar la conexión
$conexion->close();
?>

</body>
</html>
