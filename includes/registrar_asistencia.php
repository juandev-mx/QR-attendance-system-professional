<?php
date_default_timezone_set('America/Mexico_City');

require "../config/database.php";
require_once "../src/Controllers/AttendanceController.php";

$controller = new AttendanceController($conexion);

$codigo = $_REQUEST['codigo'] ?? current($_REQUEST) ?? null;

if (!$codigo) {
    echo "Error: No se recibió ningún dato.";
    exit;
}

$empleado = $controller->buscarEmpleado($codigo);

if (!$empleado) {
    echo "Empleado no encontrado";
    exit;
}

$empleado_id = $empleado['id'];
$nombre = $empleado['nombre']; 
$fecha = date("Y-m-d");
$hora = date("H:i:s");

$registro =
    $controller
        ->obtenerAsistenciaHoy(
            $empleado_id,
            $fecha
        );

if (!$registro) {
    $resultado =
    $controller
        ->registrarEntradaEmpleado(
            $empleado
        );

$retardo =
    $resultado['retardo'];

echo $retardo
?
"Entrada registrada con retardo"
:
"Entrada registrada";

} 
else {
    if ($registro['hora_salida'] == NULL)
{
    try {

        $controller
            ->registrarSalidaEmpleado(
                $registro,
                $nombre
            );

        echo "Salida registrada";

    }
    catch(Exception $e)
    {
        echo $e->getMessage();
    }
}
}
