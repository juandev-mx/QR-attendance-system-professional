<?php

namespace App\Services;

use App\Repositories\EmployeeRepository;
use Exception;

class EmployeeService
{
    private EmployeeRepository $employeeRepository;

    public function __construct(
        EmployeeRepository $employeeRepository
    )
    {
        $this->employeeRepository =
            $employeeRepository;
    }

    public function obtenerEmpleado(
        int $id
    )
    {
        $empleado =
            $this->employeeRepository
                ->buscarPorId($id);

        if (!$empleado)
        {
            throw new Exception(
                "Empleado no encontrado"
            );
        }

        return $empleado;
    }

    public function buscarPorCodigo(
        string $codigo
    )
    {
        return
            $this->employeeRepository
                ->buscarPorCodigo(
                    $codigo
                );
    }
}
