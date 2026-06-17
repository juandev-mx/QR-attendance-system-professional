<?php

namespace Tests\Services;

use PHPUnit\Framework\TestCase;

use App\Services\EmployeeService;
use App\Repositories\EmployeeRepository;
use App\Models\Employee;

class EmployeeServiceTest extends TestCase
{
    private $employeeRepository;

    private EmployeeService $service;

    protected function setUp(): void
    {
        $this->employeeRepository =
            $this->createMock(
                EmployeeRepository::class
            );

        $this->service =
            new EmployeeService(
                $this->employeeRepository
            );
    }

    public function testObtenerEmpleado()
    {
        $employee =
            new Employee();

        $employee->id = 1;
        $employee->nombre = "Juan";

        $this->employeeRepository
            ->method('buscarPorId')
            ->willReturn($employee);

        $resultado =
            $this->service
                ->obtenerEmpleado(1);

        $this->assertEquals(
            1,
            $resultado->id
        );
    }

public function testObtenerEmpleadoNoEncontrado()
{
    $this->employeeRepository
        ->method('buscarPorId')
        ->willReturn(null);

    $this->expectException(
        \Exception::class
    );

    $this->expectExceptionMessage(
        "Empleado no encontrado"
    );

    $this->service
        ->obtenerEmpleado(999);
}

public function testBuscarPorCodigo()
{
    $employee =
        new Employee();

    $employee->id = 1;
    $employee->nombre = "Juan";

    $this->employeeRepository
        ->method('buscarPorCodigo')
        ->willReturn($employee);

    $resultado =
        $this->service
            ->buscarPorCodigo(
                "QR123"
            );

    $this->assertEquals(
        "Juan",
        $resultado->nombre
    );
}

}
