<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . "/../vendor/autoload.php";

require_once __DIR__ . "/../config/database.php";

use App\Controllers\AttendanceController;
use App\Helpers\ApiResponse;

try {

    $data = json_decode(file_get_contents("php://input"), true);

    $codigo = $data['codigo'] ?? null;

    if (!$codigo)
    {
        throw new Exception("Empleado no encontrado");
    }

    $controller = new AttendanceController($conexion);

    $resultado = $controller->procesarAsistencia($codigo);

    echo json_encode(
        ApiResponse::success(
            $resultado
        )
    );
}
catch(Exception $e)
{
    echo json_encode(
        ApiResponse::error(
            $e->getMessage()
        )
    );
}
