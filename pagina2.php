<!DOCTYPE html>
<html>
<head>
    <title>Problema</title>
</head>
<body>
<?php
$conexion = new mysqli("localhost", "root", "", "phpfacil");

if ($conexion->connect_error) {
    die("Problemas en la conexión: " . $conexion->connect_error);
}

$mail = $_REQUEST['mail'];
$sql = "SELECT * FROM alumnoss WHERE mail = ?";
if ($stmt = $conexion->prepare($sql)) {
    $stmt->bind_param("s", $mail);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($regalu = $resultado->fetch_assoc()) {
?>
<form action="pagina3.php" method="post">
    <input type="hidden" name="mailviejo" value="<?php echo htmlspecialchars($regalu['mail']); ?>">
    <select name="codigocurso">
    <?php
        $sql_cursos = "SELECT * FROM cursos";
        if ($resultado_cursos = $conexion->query($sql_cursos)) {
            while ($reg = $resultado_cursos->fetch_assoc()) {
                $selected = ($regalu['codigocurso'] == $reg['codigo']) ? "selected" : "";
                echo "<option value=\"" . htmlspecialchars($reg['codigo']) . "\" $selected>" . htmlspecialchars($reg['nombrecur']) . "</option>";
            }
            $resultado_cursos->free();
        } else {
            die("Problemas en el select: " . $conexion->error);
        }
    ?>
    </select>
    <br>
    <input type="submit" value="Modificar">
</form>
<?php
    } else {
        echo "No existe alumno con dicho mail";
    }

    $stmt->close();
} else {
    die("Problemas en el select: " . $conexion->error);
}

$conexion->close();
?>
</body>
</html>