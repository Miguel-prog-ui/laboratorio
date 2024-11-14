<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagos de Servicios</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            color: #333;
            margin: 0;
            display: flex;
            flex-direction: column;
            height: 100vh;
            background: #fafafa;
        }
        .header-bar {
            background: #333;
            height: 50px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 18px;
            color: white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .navbar {
            background-color: white;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .navbar a {
            color: #333;
            text-decoration: none;
            font-weight: bold;
            margin: 0 15px;
            font-size: 16px;
            transition: color 0.3s ease-in-out;
        }
        .navbar a:hover {
            color: #76C7C0;
        }
        .container {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        input[type="text"], input[type="number"] {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 10px;
        }
        button {
            background-color: #76C7C0;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s ease-in-out;
        }
        button:hover {
            background-color: #5DA9A3;
        }
    </style>
    <script>
        function showForm(service) {
            document.querySelectorAll('.service-form').forEach(form => {
                form.style.display = 'none';
            });
            document.getElementById(service).style.display = 'block';
        }
    </script>
</head>
<body>
    <div class="header-bar">
        <span>PAGOS DE SERVICIOS</span>
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
        <h2>Realiza tu Pago de Servicios</h2>
        <select onchange="showForm(this.value)">
            <option value="">Selecciona un servicio</option>
            <option value="luz">Luz</option>
            <option value="agua">Agua</option>
            <option value="recarga_telefonica">Recarga Telefónica</option>
            <option value="television_cable">Televisión por Cable</option>
            <option value="internet">Internet</option>
        </select>

        <form id="luz" class="service-form" action="procesar_pago.php" method="POST" style="display:none;">
            <div class="form-group">
                <label for="domicilio_luz">Domicilio:</label>
                <input type="text" id="domicilio_luz" name="domicilio_luz" required>
            </div>
            <div class="form-group">
                <label for="monto_luz">Monto:</label>
                <input type="number" id="monto_luz" name="monto_luz" required>
            </div>
            <button type="submit">Pagar Luz</button>
        </form>

        <form id="agua" class="service-form" action="procesar_pago.php" method="POST" style="display:none;">
            <div class="form-group">
                <label for="domicilio_agua">Domicilio:</label>
                <input type="text" id="domicilio_agua" name="domicilio_agua" required>
            </div>
            <div class="form-group">
                <label for="monto_agua">Monto:</label>
                <input type="number" id="monto_agua" name="monto_agua" required>
            </div>
            <button type="submit">Pagar Agua</button>
        </form>

        <form id="recarga_telefonica" class="service-form" action="procesar_pago.php" method="POST" style="display:none;">
            <div class="form-group">
                <label for="numero_telefono">Número de Teléfono:</label>
                <input type="text" id="numero_telefono" name="numero_telefono" required>
            </div>
            <div class="form-group">
                <label for="monto_recarga">Monto:</label>
                <input type="number" id="monto_recarga" name="monto_recarga" required>
            </div>
            <button type="submit">Recargar Teléfono</button>
        </form>

        <form id="television_cable" class="service-form" action="procesar_pago.php" method="POST" style="display:none;">
            <div class="form-group">
                <label for="codigo_aparato">Código del Aparato:</label>
                <input type="text" id="codigo_aparato" name="codigo_aparato" required>
            </div>
            <div class="form-group">
                <label for="monto_cable">Monto:</label>
                <input type="number" id="monto_cable" name="monto_cable" required>
            </div>
            <button type="submit">Pagar Cable</button>
        </form>

        <form id="internet" class="service-form" action="procesar_pago.php" method="POST" style="display:none;">
            <div class="form-group">
                <label for="cedula_titular">Número de Cédula del Titular:</label>
                <input type="text" id="cedula_titular" name="cedula_titular" required>
            </div>
            <div class="form-group">
                <label for="monto_internet">Monto:</label>
                <input type="number" id="monto_internet" name="monto_internet" required>
            </div>
            <button type="submit">Pagar Internet</button>
        </form>
    </div>
</body>
</html>
