<?php
class Persona {
    public $nombre;
    public $edad;
    public $domicilio;
    public $telefono;
    public $correoElectronico;
    public $estatura;
    public $peso;
    public $colorDeOjos;
    public $nacionalidad;

    public function __construct($nombre, $edad, $domicilio, $telefono, $correoElectronico, $estatura, $peso, $colorDeOjos, $nacionalidad = "Venezolano") {
        $this->nombre = $nombre;
        $this->edad = $edad;
        $this->domicilio = $domicilio;
        $this->telefono = $telefono;
        $this->correoElectronico = $correoElectronico;
        $this->estatura = $estatura;
        $this->peso = $peso;
        $this->colorDeOjos = $colorDeOjos;
        $this->nacionalidad = $nacionalidad;
    }

    public function presentarInformación() {
        return "Nombre: $this->nombre<br>Edad: $this->edad<br>Domicilio: $this->domicilio<br>Teléfono: $this->telefono<br>Correo Electrónico: $this->correoElectronico<br>Estatura: $this->estatura<br>Peso: $this->peso<br>Color de Ojos: $this->colorDeOjos<br>Nacionalidad: $this->nacionalidad<br>";
    }

    public function calcularEdad($añoActual) {
        return $añoActual - (date('Y') - $this->edad);
    }

    public function compararEstatura($otraPersona) {
        return $this->estatura > $otraPersona->estatura;
    }

    public function calcularIMC() {
        return $this->peso / ($this->estatura * $this->estatura);
    }

    public function mostrarNacionalidad() {
        return $this->nacionalidad;
    }
}
?>
