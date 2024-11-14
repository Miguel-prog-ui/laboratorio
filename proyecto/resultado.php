<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado del Registro</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #A8E6CF, #DCEDC8);
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
            text-align: center;
            width: 90%;
            max-width: 400px;
        }
        h1 {
            color: #333333;
        }
        p {
            color: #666666;
        }
        .btn {
            display: inline-block;
            background-color: #76C7C0;
            color: #ffffff;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }
        .btn:hover {
            background-color: #5AAEAA;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Resultado del Registro</h1>
        <p><?php echo htmlspecialchars($_GET['mensaje']); ?></p>
        <a href='monda.html' class='btn'>Volver a la página de inicio de sesión</a>
    </div>
</body>
</html>
