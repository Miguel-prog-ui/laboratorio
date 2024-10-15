<?php
    $conec = mysqli_connect ("localhost", "root", "") or die("Problemas!!!!!!!!"); 
    mysqli_select_db ($conec, "parcial") or die ("Se ha producido un problema"); 

    $nombre = $_POST ['nombre'];
    $apellido = $_POST ['apellido'];
    $cedula = $_POST ['cedula'];
    $deportes = $_POST ['deportes'];
    $equipos = $_POST ['equipos'];

    $insertar = "INSERT INTO usuarios (nombre, apellido, cedula, deportes, equipos) VALUES ('$nombre', '$apellido',$cedula, '$deportes', '$equipos')";
    $resultado = mysqli_query($conec,$insertar);


    $registrar = mysqli_query ($conec, "SELECT * FROM `usuarios`") or die("Problemas en el select:".mysqli_error($conexion));
    echo"Imprimiendo con while: <br><br>";
    while ($reg = mysqli_fetch_array($registrar)) {  
       echo "Nombre: ".$reg ['nombre']."<br>";
       echo "Apellido: ".$reg ['apellido']."<br>";
       echo "Cedula: ".$reg ['cedula']."<br>";
       echo "deportes: ".$reg ['deportes']."<br>";
       echo "equipos: ".$reg ['equipos']."<br>";
       echo "<-----------------------------------------------><br>";
    }

    $sql = "SELECT * FROM usuarios";
    $resultados = mysqli_query($conec, $sql); 
    $campos = mysqli_num_fields($resultados); 
    $filas = mysqli_num_rows($resultados); 
    echo "Imprimendo con for: <br><br>";    

    for ($j = 0; $j < $filas; $j++) { 
        $reg1 = mysqli_fetch_array($resultados);
        echo "Nombre: ".$reg1['nombre']."<br>";
        echo "Apellido: ".$reg1['apellido']."<br>";
        echo "Cedula: ".$reg1['cedula']."<br>";
        echo "deportes: ".$reg1['deportes']."<br>";
        echo "equipos: ".$reg1['equipos']."<br>";
        echo "<-----------------------------------------------><br>";
    } 

    $sql = "SELECT * FROM usuarios";
    $resultados = mysqli_query($conec, $sql); 
    $campos = mysqli_num_fields($resultados); 
    $filas = mysqli_num_rows($resultados); 
    echo "Imprimendo solo impares: <br><br>"; 

    for ($j = 0; $j < $filas; $j++) { 
        $reg1 = mysqli_fetch_array($resultados);
        if ($reg1['codigo'] %2 != 0) {
            echo "Esta fila es impar<br>";
            echo "Nombre : ".$reg1['nombre']."<br>";
            echo "Apellido : ".$reg1['apellido']."<br>";
            echo "Cedula : ".$reg1['cedula']."<br>";
            echo "deportes : ".$reg1['deportes']."<br>";
            echo "equipos : ".$reg1['equipos']."<br>";
        }
        echo "<hr>";
    } 


    echo "</tr>\n"; //Cierra la fila
    
mysqli_close($conec);

?>