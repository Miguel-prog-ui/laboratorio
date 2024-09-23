html>
<head>
    <title>Alta de Alumnos</title>
</head>
<body>
    <h1>Registrar Alumno</h1>
    <form method="POST" action="">
        Nombre: <input type="text" name="nombre" required><br>
        Mail: <input type="email" name="mail" required><br>
        Código de Curso: 
        <select name="codigocurso" required>
            <option value="1">PHP</option>
            <option value="2">ASP</option>
            <option value="3">JSP</option>
        </select><br>
        <input type="submit" value="Registrar">
    </form>

    <?php 
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $host = "localhost";
        $bd = "phpfacil";
        $usuario = "root";
        $contra = "";

        try {
            // Crear la conexión
            $conexion = new PDO("mysql:host=$host;dbname=$bd", $usuario, $contra);
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Preparar la consulta
            $sentenciaSQL = $conexion->prepare("INSERT INTO alumnos (nombre, mail, codigocurso) VALUES (:nombre, :mail, :codigocurso)");
            
            // Vincular los parámetros
            $sentenciaSQL->bindParam(':nombre', $_POST['nombre']);
            $sentenciaSQL->bindParam(':mail', $_POST['mail']);
            $sentenciaSQL->bindParam(':codigocurso', $_POST['codigocurso']);
            
            // Ejecutar la consulta
            $sentenciaSQL->execute();

            echo "El alumno fue registrado exitosamente.";
        } catch (PDOException $ex) {
            echo "Error en la conexión: " . $ex->getMessage();
        }
    }
    ?>
</body>
</html>