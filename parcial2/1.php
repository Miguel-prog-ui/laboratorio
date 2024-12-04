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

    public function __construct($nombre, $edad, $domicilio, $telefono, $correoElectronico, $estatura, $peso, $colorDeOjos) {
        $this->nombre = $nombre;
        $this->edad = $edad;
        $this->domicilio = $domicilio;
        $this->telefono = $telefono;
        $this->correoElectronico = $correoElectronico;
        $this->estatura = $estatura;
        $this->peso = $peso;
        $this->colorDeOjos = $colorDeOjos;
    }
}
?>