<?php
declare(strict_types=1);

require_once __DIR__ . '/Estudiante.php';

class MapaEstudiantes
{
    private array $estudiantes = [];
    private string $archivo = __DIR__ . '/../estudiantes.json';

    public function __construct()
    {
        if (file_exists($this->archivo)) {
            foreach (json_decode(file_get_contents($this->archivo), true) as $d) {
                $this->estudiantes[$d['codigo']] = new Estudiante($d['nombre'], $d['apellido'], $d['edad'], $d['codigo'], $d['carrera']);
            }
        }

        $this->agregar(new Estudiante('Juan Antonio', 'Moya Oblitas', 20, '10914005', 'Ingeniería de Sistemas'));
    }

    public function agregar(Estudiante $e): bool
    {
        if (isset($this->estudiantes[$e->getCodigo()])) {
            return false;
        }
        $this->estudiantes[$e->getCodigo()] = $e;
        file_put_contents($this->archivo, json_encode(array_values($this->todos()), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        return true;
    }

    public function obtener(string $codigo): ?Estudiante
    {
        return $this->estudiantes[$codigo] ?? null;
    }

    public function todos(): array
    {
        return array_map(fn($e) => $e->toArray(), $this->estudiantes);
    }
}