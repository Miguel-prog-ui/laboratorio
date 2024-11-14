<?php
session_start();
include 'db_connect.php'; // Conexión a tu base de datos

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verifica que el nombre de usuario y el monto del pago estén establecidos
    if (!isset($_SESSION['nombreusuario']) || !isset($_POST['monto_pago'])) {
        header("Location: pagos_servicios.php?message=Error: Datos no definidos.&message_type=error");
        exit();
    }

    $nombreusuario = $_SESSION['nombreusuario']; // Obtener el nombre de usuario de la sesión
    $monto_pago = $_POST['monto_pago']; // El monto a pagar enviado desde el formulario

    // Consulta el saldo actual del usuario
    $query = "SELECT saldo FROM usuarios WHERE nombreusuario = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $nombreusuario);
    $stmt->execute();
    $stmt->bind_result($saldo);
    $stmt->fetch();
    $stmt->close();

    if ($saldo < $monto_pago) {
        // Redirige con mensaje de error si el saldo es insuficiente
        header("Location: pagos_servicios.php?message=Saldo insuficiente. Por favor, recargue su cuenta.&message_type=error");
    } else {
        // Calcula el nuevo saldo
        $nuevo_saldo = $saldo - $monto_pago;

        // Actualiza el saldo en la base de datos
        $update_query = "UPDATE usuarios SET saldo = ? WHERE nombreusuario = ?";
        $stmt = $conn->prepare($update_query);
        $stmt->bind_param("ds", $nuevo_saldo, $nombreusuario);
        if ($stmt->execute()) {
            // Redirige con mensaje de éxito si el pago se realizó correctamente
            header("Location: pagos_servicios.php?message=Pago realizado con éxito. &message_type=success");
        } else {
            // Redirige con mensaje de error si hubo un problema al actualizar el saldo
            header("Location: pagos_servicios.php?message=Hubo un error al procesar su pago. Por favor, intente de nuevo.&message_type=error");
        }
        $stmt->close();
    }

    $conn->close();
}
?>
