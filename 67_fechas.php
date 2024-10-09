<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Problema</title>
    <script>
        function validateForm() {
            var nombre = document.forms["myForm"]["nombre"].value;
            var mail = document.forms["myForm"]["mail"].value;
            var dia = document.forms["myForm"]["dia"].value;
            var mes = document.forms["myForm"]["mes"].value;
            var anio = document.forms["myForm"]["anio"].value;
            if (nombre == "" || mail == "" || dia == "" || mes == "" || anio == "") {
                alert("Todos los campos deben ser completados");
                return false;
            }
            return true;
        }
    </script>
</head>
<body>
<form name="myForm" action="67_fechas1.php" method="post" onsubmit="return validateForm()">
    <label for="nombre">Ingrese nombre:</label>
    <input type="text" name="nombre" id="nombre"><br>
    <label for="mail">Ingrese mail:</label>
    <input type="text" name="mail" id="mail"><br>
    <label for="dia">Ingrese la fecha de nacimiento (dd/mm/aaaa):</label>
    <input type="text" name="dia" size="2" id="dia">
    <input type="text" name="mes" size="2" id="mes">
    <input type="text" name="anio" size="4" id="anio">
    <br>
    <label for="codigocurso">Seleccione el curso:</label>
    <select name="codigocurso" id="codigocurso">
    <?php
    $conexion = new mysqli("localhost", "root", "", "phpfacil");
    if ($conexion->connect_error) {
        die("Problemas en la conexión: " . $conexion->connect_error);
    }
    $stmt = $conexion->prepare("SELECT codigo, nombrecur FROM cursos");
    $stmt->execute();
    $result = $stmt->get_result();
    while ($reg = $result->fetch_assoc()) {
        echo '<option value="' . $reg['codigo'] . '">' . htmlspecialchars($reg['nombrecur']) . '</option>';
    }
    $stmt->close();
    $conexion->close();
    ?>
    </select>
    <br>
    <input type="submit" value="Registrar">
</form>
</body>
</html>
