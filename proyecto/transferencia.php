<?php session_start(); ?>
<?php include 'db_connect.php'; // Conectar a la base de datos ?>
<?php
$nombreusuario = $_SESSION['nombreusuario'];
$message = ""; // Variable para el mensaje

// Procesar el formulario de transferencia
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $destinatario = $_POST['destinatario'];
    $correo = $_POST['correo'];
    $monto = $_POST['monto'];
    $contraseña = $_POST['contraseña'];
    $concepto = $_POST['concepto']; // Nuevo campo para concepto

    // Verificar la contraseña del usuario que realiza la transferencia
    $sql = "SELECT contraseña, saldo FROM usuarios WHERE nombreusuario = '$nombreusuario'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $saldo = $row['saldo'];
        if (password_verify($contraseña, $row['contraseña'])) {
            if ($saldo >= $monto) { // Verificar si el saldo es suficiente
                // Verificar que el destinatario existe y que el correo coincide
                $sql = "SELECT saldo FROM usuarios WHERE nombreusuario = '$destinatario' AND mail = '$correo'";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    // Realizar la transferencia
                    $conn->begin_transaction();
                    try {
                        // Restar el saldo del usuario que realiza la transferencia
                        $sql = "UPDATE usuarios SET saldo = saldo - $monto WHERE nombreusuario = '$nombreusuario'";
                        if ($conn->query($sql) !== TRUE) {
                            throw new Exception("Error al restar saldo: " . $conn->error);
                        }

                        // Sumar el saldo al destinatario
                        $sql = "UPDATE usuarios SET saldo = saldo + $monto WHERE nombreusuario = '$destinatario'";
                        if ($conn->query($sql) !== TRUE) {
                            throw new Exception("Error al sumar saldo: " . $conn->error);
                        }

                        // Insertar en historial
                        $fechaHora = date('Y-m-d H:i:s'); // Obtener la fecha y hora actual
                        $sql = "INSERT INTO historial (monto, concepto, fecha_hora, usuario_destino, usuario_origen) VALUES ('$monto', '$concepto', '$fechaHora', '$destinatario', '$nombreusuario')";
                        if ($conn->query($sql) !== TRUE) {
                            throw new Exception("Error al insertar en historial: " . $conn->error);
                        }

                        // Confirmar transacción
                        $conn->commit();
                        $message = "<h2 style='color: green;'>Transferencia realizada con éxito. Saldo actualizado.</h2>";
                    } catch (Exception $e) {
                        $conn->rollback();
                        $message = "<h2 style='color: red;'>Error durante la transferencia: " . $e->getMessage() . "</h2>";
                    }
                } else {
                    $message = "<h2 style='color: red;'>Destinatario no encontrado o correo incorrecto.</h2>";
                }
            } else {
                $message = "<h2 style='color: red;'>Saldo insuficiente para realizar la transferencia.</h2>";
            }
        } else {
            $message = "<h2 style='color: red;'>Contraseña incorrecta.</h2>";
        }
    } else {
        $message = "<h2 style='color: red;'>Usuario no encontrado.</h2>";
    }
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transferencia</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            color: #333;
            margin: 0;
            display: flex;
            flex-direction: column;
            height: 100vh;
            background: #fafafa; /* Fondo gris muy claro */
        }
        .header-bar {
            background: #333; /* Gris oscuro */
            height: 50px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 18px;
            color: white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .navbar {
            background-color: white; /* Blanco para minimalismo */
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .navbar a {
            color: #333; /* Gris oscuro */
            text-decoration: none;
            font-weight: bold;
            margin: 0 15px;
            font-size: 16px;
            transition: color 0.3s ease-in-out; /* Transición suave */
        }
        .navbar a:hover {
            color: #76C7C0; /* Verde claro al pasar el mouse */
        }
        .container {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        .form-container {
            background-color: white;
            padding: 40px; /* Más espacio */
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px; /* Ancho aumentado */
            text-align: center;
            transition: transform 0.3s ease-in-out; /* Animación suave */
        }
        .form-container:hover {
            transform: scale(1.05); /* Efecto de zoom al pasar el mouse */
        }
        .form-container input[type="text"],
        .form-container input[type="email"],
        .form-container input[type="number"],
        .form-container input[type="password"],
        .form-container input[type="text"],
        .form-container button {
            width: calc(100% - 30px); /* Reduce el ancho del campo */
            margin: 10px 10px; /* Márgenes más pequeños */
            padding: 12px; /* Aumenta el padding */
            font-size: 16px; /* Aumenta el tamaño del texto */
            border: 1px solid #ccc;
            border-radius: 20px; /* Bordes redondeados */
        }
        .form-container button {
            background-color: #76C7C0;
            color: white;
            border: none;
            cursor: pointer;
        }
        .form-container button:hover {
            background-color: #5AAEAA;
        }
    </style>
</head>
<body>
    <div class="header-bar">
        <span>TRANSFERENCIA</span>
    </div>
    <div class="navbar">
        <a href="menu.php">Inicio</a>
        <a href="saldo.php">Consultar Saldo</a>
        <a href="deposito.php">Depósito</a>
        <a href="transferencia.php">Transferencia</a>
        <a href="pagos_servicios.php">Pagos de Servicios</a>
        <a href="monda.html">Cerrar sesión</a>
    </div>
    <div class="container">
        <div class="form-container">
            <h2>Transferir Fondos</h2>
            <?php echo $message; ?> <!-- Mostrar el mensaje aquí -->
            <form method="POST" action="transferencia.php">
                <input type="text" name="destinatario" placeholder="Usuario destino" required>
                <input type="email" name="correo" placeholder="Correo del destinatario" required>
                <input type="number" name="monto" placeholder="Monto a transferir" required>
                <input type="password" name="contraseña" placeholder="Contraseña" required>
                <input type="text" name="concepto" placeholder="Concepto de la transferencia" required> <!-- Nuevo campo -->
                <button type="submit">Transferir</button>
            </form>
        </div>
    </div>
</body>
</html>
