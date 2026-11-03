<?php
declare(strict_types=1);

require_once __DIR__ . '/src/MapaEstudiantes.php';

header('Content-Type: application/json; charset=utf-8');

function responder(int $codigo, array $datos): void
{
    http_response_code($codigo);
    echo json_encode($datos, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    exit;
}

$mapa = new MapaEstudiantes();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $d = json_decode(file_get_contents('php://input'), true) ?? $_POST;

    foreach (['codigo', 'nombre', 'apellido', 'edad', 'carrera'] as $campo) {
        if (trim((string) ($d[$campo] ?? '')) === '') {
            responder(400, ['exito' => false, 'mensaje' => "Falta el campo $campo."]);
        }
    }

    foreach (['nombre', 'apellido'] as $campo) {
        if (!preg_match("/^[\p{L}\s]+$/u", (string) $d[$campo])) {
            responder(400, ['exito' => false, 'mensaje' => "El $campo solo puede tener letras."]);
        }
    }

    if (!ctype_digit((string) $d['edad'])) {
        responder(400, ['exito' => false, 'mensaje' => 'La edad debe ser un número entero.']);
    }

    $e = new Estudiante((string) $d['nombre'], (string) $d['apellido'], (int) $d['edad'], (string) $d['codigo'], (string) $d['carrera']);

    if (!$mapa->agregar($e)) {
        responder(409, ['exito' => false, 'mensaje' => 'Ya existe un estudiante con ese código.']);
    }
    responder(201, ['exito' => true, 'mensaje' => 'Estudiante registrado correctamente.', 'estudiante' => $e->toArray()]);
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $codigo = $_GET['codigo'] ?? '';

    if ($codigo === '') {
        $lista = $mapa->todos();
        responder(200, ['exito' => true, 'total' => count($lista), 'estudiantes' => $lista]);
    }

    $e = $mapa->obtener($codigo);
    if ($e === null) {
        responder(404, ['exito' => false, 'mensaje' => "No existe un estudiante con el código $codigo."]);
    }
    responder(200, ['exito' => true, 'estudiante' => $e->toArray()]);
}

responder(405, ['exito' => false, 'mensaje' => 'Método no permitido. Use GET o POST.']);