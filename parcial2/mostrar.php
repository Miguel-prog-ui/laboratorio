<?php
include 'persona.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Crear las dos instancias de la clase Persona con los datos del formulario
    $persona1 = new Persona(
        $_POST['nombre1'],
        $_POST['edad1'],
        $_POST['domicilio1'],
        $_POST['telefono1'],
        $_POST['correo1'],
        $_POST['estatura1'],
        $_POST['peso1'],
        $_POST['colorDeOjos1']
    );

    $persona2 = new Persona(
        $_POST['nombre2'],
        $_POST['edad2'],
        $_POST['domicilio2'],
        $_POST['telefono2'],
        $_POST['correo2'],
        $_POST['estatura2'],
        $_POST['peso2'],
        $_POST['colorDeOjos2']
    );

    // Mostrar la información de la primera persona
    echo "<h2>Información de la Persona 1</h2>";
    echo $persona1->presentarInformación();

    // Mostrar la información de la segunda persona
    echo "<h2>Información de la Persona 2</h2>";
    echo $persona2->presentarInformación();

    // Comparar las estaturas de las dos personas
    echo "<h3>Comparación de Estaturas</h3>";
    echo $persona1->compararEstatura($persona2) ? "Persona 1 es más alta que Persona 2.<br>" : "Persona 1 no es más alta que Persona 2.<br>";

    // Calcular el IMC de cada persona
    echo "<h3>Índice de Masa Corporal (IMC)</h3>";
    echo "IMC de Persona 1: " . $persona1->calcularIMC() . "<br>";
    echo "IMC de Persona 2: " . $persona2->calcularIMC() . "<br>";
}
?>
