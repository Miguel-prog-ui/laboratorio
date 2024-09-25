<!DOCTYPE html>
<html>
<head>
    <title>Introducir Direcciones</title>
</head>
<body>
<h3>Introducir direcciones</h3>

<?php
$dp = new mysqli("localhost", "root", "", "agenda");

// Verificar conexión
if ($dp->connect_error) {
    die("<p>No se ha podido establecer la conexión con MySQL.</p>");
}

if (isset($_POST['submit'])) {
    // Validación de campos
    $errors = [];
    
    if (empty($_POST['Nombre'])) {
        $errors[] = "<p>Introduzca el <b>nombre</b>.</p>";
    }
    if (strlen($_POST['Apellido']) < 3) {
        $errors[] = "<p>El apellido debe tener como mínimo <b>3</b> caracteres.</p>";
    }

    // Mostrar errores
    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo $error;
        }
    } else {
        // Preparar la consulta
        $stmt = $dp->prepare("INSERT INTO direcciones (Tratamiento, Nombre, Apellido, Calle, CP, Localidad, Tel, Movil, Mail, Website, Categoria, Notas) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssssssssss", $_POST['Tratamiento'], $_POST['Nombre'], $_POST['Apellido'], $_POST['Calle'], $_POST['CP'], $_POST['Localidad'], $_POST['Tel'], $_POST['Movil'], $_POST['Mail'], $_POST['Website'],$_POST['Categoria'] , $_POST['Notas']); 
        
        if ($stmt->execute()) {
            echo "<p> Datos agregados con éxito.</p>";
        } else {
            echo "<p>Datos <b>no</b> agregados.</p>";
        }
        
        $stmt->close();
        echo "[ <a href='javascript:history.back()'>Volver</a> ] - [ <a href='{$_SERVER['PHP_SELF']}'> Introducir nueva fila</a> ]";
    }
} else {
    // Obtener categorías
    $sql2 = "SELECT * FROM categorias";
    $resultado2 = $dp->query($sql2);
    
    $campocat = "";
    while ($row = $resultado2->fetch_assoc()) {
        $campocat .= "<option value='{$row['Categoria']}'>{$row['Categoria']}</option>\n"; 
    }
}
?>

<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
    <table>
        <tr>
            <td>Tratamiento:</td>
            <td>
                <select name="Tratamiento">
                    <option>Sr.</option>
                    <option>Sra.</option>
                </select>
            </td>
        </tr>
        <tr><td>Nombre:</td><td><input type="text" name="Nombre"></td></tr>
        <tr><td>Apellido:</td><td><input type="text" name="Apellido"></td></tr>
        <tr><td>Calle:</td><td><input type="text" name="Calle"></td></tr>
        <tr><td>CP:</td><td><input type="text" name="CP"></td></tr>
        <tr><td>Localidad:</td><td><input type="text" name="Localidad"></td></tr>
        <tr><td>Tel:</td><td><input type="text" name="Tel"></td></tr>
        <tr><td>Movil:</td><td><input type="text" name="Movil"></td></tr>
        <tr><td>E-mail:</td><td><input type="text" name="Mail"></td></tr>
        <tr><td>Website:</td><td><input type="text" name="Website"></td></tr>
        <tr><td>Categoría:</td><td><select name="Categoria"><?php echo $campocat; ?></select></td></tr>
        <tr><td>Notas:</td><td><textarea cols="60" rows="4" name="Notas"></textarea></td></tr>
        <tr><td><input type="submit" value="Introducir datos" name="submit"></td></tr>
    </table>
</form>

<?php
$dp->close();
?>
</body>
</html>