<?php

namespace Tests\Services;

use PHPUnit\Framework\TestCase;

use App\Services\CompanyService;
use App\Repositories\CompanyRepository;

use App\Models\Company;
use App\Models\Employee;

class CompanyServiceTest extends TestCase
{
    private $companyRepository;

    private CompanyService $service;

    protected function setUp(): void
    {
        $this->companyRepository =
            $this->createMock(
                CompanyRepository::class
            );

        $this->service =
            new CompanyService(
                $this->companyRepository
            );
}

public function testListarEmpresas()
{
    $empresa1 =
        new Company();

    $empresa1->id = 1;

    $empresa2 =
        new Company();

    $empresa2->id = 2;

    $this->companyRepository
        ->method('obtenerTodas')
        ->willReturn([
            $empresa1,
            $empresa2
        ]);

    $resultado =
        $this->service
            ->listarEmpresas();

    $this->assertCount(
        2,
        $resultado
    );
}

public function testObtenerEmpresa()
{
    $empresa =
        new Company();

    $empresa->id = 1;

    $empresa->nombre =
        "Empresa Demo";

    $this->companyRepository
        ->method('buscarPorId')
        ->willReturn(
            $empresa
        );

    $resultado =
        $this->service
            ->obtenerEmpresa(1);

    $this->assertEquals(
        "Empresa Demo",
        $resultado->nombre
    );
}

public function testObtenerEmpresaNoEncontrada()
{
    $this->companyRepository
        ->method('buscarPorId')
        ->willReturn(null);

    $this->expectException(
        \Exception::class
    );

    $this->expectExceptionMessage(
        "Empresa no encontrada"
    );

    $this->service
        ->obtenerEmpresa(999);
}

public function testObtenerEmpleadosEmpresa()
{
    $empleado1 =
        new Employee();

    $empleado1->id = 1;

    $empleado2 =
        new Employee();

    $empleado2->id = 2;

    $this->companyRepository
        ->method('obtenerEmpleados')
        ->willReturn([
            $empleado1,
            $empleado2
        ]);

    $resultado =
        $this->service
            ->obtenerEmpleadosEmpresa(
                1
            );

    $this->assertCount(
        2,
        $resultado
    );
}

    }
