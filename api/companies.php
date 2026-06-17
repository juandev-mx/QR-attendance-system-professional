<?php

header(
    'Content-Type: application/json; charset=utf-8'
);

require_once __DIR__ . "/../vendor/autoload.php";

require_once __DIR__ . "/../config/database.php";

use App\Controllers\CompanyController;
use App\Helpers\ApiResponse;

try {

    $controller =
        new CompanyController(
            $conexion
        );

    $resultado =
        $controller->listar();

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
