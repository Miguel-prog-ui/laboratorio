<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario</title>
</head>
<body>
    <h1>Ingrese los datos solicitados</h1>

    <form action="arreglo.php" method="post">
        <label>Nombre:
            <input type="text" name="nombre" required>
        </label>
        <br>
        <label>Apellido:
            <input type="text" name="apellido" required>
        </label>
        <br>
        <label>Cedula:
            <input type="text" name="ci" required>
        </label>
        <br>
        <label>Materia:
            <select name="materia" required>
                <option value="Matematica">Matematica</option>
                <option value="Lenguaje">Lenguaje</option>
                <option value="Fisica">Fisica</option>
            </select>
        </label>
        <br>
        <label>Nota:
            <input type="text" name="nota" required>
        </label>
        <br>
        <label>Evaluacion:
            <select name="evaluacion" required>
                <option value=1>Parcial 1</option>
                <option value=2>Parcial 2</option>
                <option value=3>Parcial 3</option>
                <option value=4>Parcial 4</option>
            </select>
        </label>
        <br>
        <button type="submit">Enviar informacion</button>
    </form>
</body>
</html>