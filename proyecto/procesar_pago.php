<?php include 'db_connect.php'; // Conectar a la base de datos ?>
<?php
session_start();

// Obtener el nombre de usuario de la sesión
$nombreusuario = $_SESSION['nombreusuario'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener datos del formulario
    $servicio = $_POST['servicio'];
    $monto = $_POST['monto'];
    
    // Dependiendo del servicio, obtener los datos específicos
    $domicilio = isset($_POST['domicilio']) ? $_POST['domicilio'] : null;
    $numero_telefono = isset($_POST['numero_telefono']) ? $_POST['numero_telefono'] : null;
    $codigo_aparato = isset($_POST['codigo_aparato']) ? $_POST['codigo_aparato'] : null;
    $cedula_titular = isset($_POST['cedula_titular']) ? $_POST['cedula_titular'] : null;

    // Verificar el saldo del usuario
    $query_saldo = "SELECT saldo FROM usuarios WHERE nombreusuario = '$nombreusuario'";
    $result_saldo = mysqli_query($conn, $query_saldo);
    if ($result_saldo && mysqli_num_rows($result_saldo) > 0) {
        $row = mysqli_fetch_assoc($result_saldo);
        $saldo_actual = $row['saldo'];
        
        if ($saldo_actual >= $monto) {
            // Realizar la transacción
            $nuevo_saldo = $saldo_actual - $monto;
            $query_actualizar_saldo = "UPDATE usuarios SET saldo = '$nuevo_saldo' WHERE nombreusuario = '$nombreusuario'";
            if (mysqli_query($conn, $query_actualizar_saldo)) {
                // Registrar el pago
                $query_registrar_pago = "INSERT INTO pagos (nombreusuario, servicio, monto, domicilio, numero_telefono, codigo_aparato, cedula_titular) 
                                        VALUES ('$nombreusuario', '$servicio', '$monto', '$domicilio', '$numero_telefono', '$codigo_aparato', '$cedula_titular')";
                if (mysqli_query($conn, $query_registrar_pago)) {
                    echo "Pago realizado con éxito.";
                } else {
                    echo "Error al registrar el pago.";
                }
            } else {
                echo "Error al actualizar el saldo.";
            }
        } else {
            echo "Saldo insuficiente.";
        }
    } else {
        echo "Error al obtener el saldo del usuario.";
    }
}
?>
