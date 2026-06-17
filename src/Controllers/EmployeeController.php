<?php

namespace App\Controllers;

use App\Services\EmployeeService;
use App\Repositories\EmployeeRepository;

use PDO;

class EmployeeController
{
    private EmployeeService $service;

    public function __construct(
        PDO $conexion
    )
    {
        $repository =
            new EmployeeRepository(
                $conexion
            );

        $this->service =
            new EmployeeService(
                $repository
            );
    }

    public function detalle(
        int $id
    )
    {
        return $this->service
            ->obtenerEmpleado(
                $id
            );
    }
}
