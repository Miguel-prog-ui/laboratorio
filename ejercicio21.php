<!DOCTYPE html>
<html> 
<head> 
    <title>Bucle While</title> 
</head> 
<body> 
    <h1>Bucle While</h1> 

    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <label for="number">Introduce un número:</label>
        <input type="number" id="number" name="number" required>
        <input type="submit" value="Enviar">
    </form>

    <?php 
    /* Mostraremos el uso de la sentencia While y comenzamos a usar entrada 
    del teclado mediante un formulario simple */ 
    if (isset($_POST['number'])) { 
        $number = $_POST['number']; 
        $counter = 1; 
        while ($counter <= $number) { 
            echo "¡Los bucles son fáciles!<br>\n"; 
            $counter++; 
        } 
        echo "Se acabó.\n"; 
    }
    ?> 
</body> 
</html>
