<?php
declare(strict_types=1);

require_once __DIR__ . '/Persona.php';

class Estudiante extends Persona
{
    private string $codigo;
    private string $carrera;
    public function __construct(string $nombre, string $apellido, int $edad, string $codigo, string $carrera)
    {
        parent::__construct($nombre, $apellido, $edad);
        $this->codigo = $codigo;
        $this->carrera = $carrera;
    }
    public function getCodigo(): string
    {
        return $this->codigo;
    }
    public function getCarrera(): string
    {
        return $this->carrera;
    }
    public function toArray(): array
    {
        $datos = parent::toArray();
        $datos['codigo'] = $this->codigo;
        $datos['carrera'] = $this->carrera;
        return $datos;
    }
}