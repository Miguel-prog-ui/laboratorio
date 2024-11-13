<!DOCTYPE html>
<html>
<head>
    <title>MySQL 02 - Consulta BD con tabla (Agenda)</title>
</head>
<body>
<h1>MySQL 02 - Consulta BD con tabla (Agenda)</h1>
<?php
$dp = new mysqli("localhost", "root", "", "agenda");

// Verificar conexión
if ($dp->connect_error) {
    die("Conexión fallida: " . $dp->connect_error);
}

$sql = "SELECT * FROM direcciones";
$resultado = $dp->query($sql);

if ($resultado->num_rows > 0) {
    $campos = $resultado->field_count;
    $filas = $resultado->num_rows;
    echo "<p>Cantidad de filas: $filas</p>\n";
    echo "<table border='1' cellspacing='0'>\n"; // Empezar tabla
    echo "<tr>"; // Crear fila
    $fields = $resultado->fetch_fields();
    foreach ($fields as $field) {
        echo "<th>{$field->name}</th>";
    }
    echo "</tr>\n"; // Cerrar fila

    while ($row = $resultado->fetch_assoc()) {
        echo "<tr>"; // Crear fila
        foreach ($row as $value) {
            echo "<td>$value </td>";
        }
        echo "</tr>\n"; // Cerrar fila
    }
    echo "</table>\n"; // Cerrar tabla
} else {
    echo "0 resultados";
}

$dp->close();
?>
</body>
</html>
