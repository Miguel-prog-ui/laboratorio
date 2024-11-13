<!DOCTYPE html>
<html>
<head>
    <title>Problema</title>
</head>
<body>
<form action="pagina49.php" method="post">
    Ingrese nombre:
    <input type="text" name="nombre"><br>
    Ingrese mail:
    <input type="text" name="mail"><br>
    Seleccione el curso:
    <select name="codigocurso">
    <?php
    $conexion = new mysqli("localhost", "root", "", "phpfacil");

    if ($conexion->connect_error) {
        die("Problemas en la conexión: " . $conexion->connect_error);
    }

    $registros = $conexion->query("SELECT codigo, nombrecur FROM cursos");

    if ($registros->num_rows > 0) {
        while ($reg = $registros->fetch_assoc()) {
            echo "<option value=\"{$reg['codigo']}\">{$reg['nombrecur']}</option>";
        }
    } else {
        echo "<option value=\"\">No hay cursos disponibles</option>";
    }

    $conexion->close();
    ?>
    </select>
    <br>
    <input type="submit" value="Registrar">
</form>
</body>
</html>
