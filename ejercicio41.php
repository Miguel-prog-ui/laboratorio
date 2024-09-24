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

// Manejo del formulario para agregar nuevos registros
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    
    // Validar datos
    if (!empty($nombre) && !empty($apellido)) {
        // Preparar la inserción
        $stmt = $conexion->prepare("INSERT INTO direcciones (Nombre, Apellido) VALUES (?, ?)");
        $stmt->bind_param("ss", $nombre, $apellido);
        if ($stmt->execute()) {
            echo "<p>Registro agregado con éxito.</p>";
        } else {
            echo "<p>Error al agregar registro: " . $stmt->error . "</p>";
        }
        $stmt->close();
    } else {
        echo "<p>Por favor, introduzca un nombre y un apellido válidos.</p>";
    }
}

// Realizar la consulta
$sql = "SELECT * FROM direcciones";
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
            echo "<td>" . htmlspecialchars($valor) . "&nbsp;</td>"; 
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

<!-- Formulario para agregar nuevos registros -->
<h2>Agregar Nuevo Registro</h2>
<form method="POST" action="">
    <label for="nombre">Nombre:</label>
    <input type="text" name="nombre" required>
    <br>
    <label for="apellido">Apellido:</label>
    <input type="text" name="apellido" required>
    <br>
    <input type="submit" value="Agregar Registro">
</form>

</body>
</html>