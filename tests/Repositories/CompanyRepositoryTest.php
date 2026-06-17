<?php

namespace Tests\Repositories;

use PHPUnit\Framework\TestCase;

use App\Repositories\CompanyRepository;

use PDO;

class CompanyRepositoryTest extends TestCase
{
    private PDO $conexion;

    private CompanyRepository $repository;

    protected function setUp(): void
    {
        $this->conexion = new PDO(
            "mysql:host=localhost;dbname=control_asistencias_qr",
            "root",
            "juan123"
        );

        $this->conexion->setAttribute(
            PDO::ATTR_ERRMODE,
            PDO::ERRMODE_EXCEPTION
        );

        $this->repository =
            new CompanyRepository(
                $this->conexion
            );
    }

    public function testObtenerTodas()
    {
        $empresas =
            $this->repository
                ->obtenerTodas();

        $this->assertIsArray(
            $empresas
        );
    }

    public function testBuscarPorId()
    {
        $empresa =
            $this->repository
                ->buscarPorId(1);

        $this->assertNotNull(
            $empresa
        );
    }

    public function testObtenerEmpleados()
    {
        $empleados =
            $this->repository
                ->obtenerEmpleados(1);

        $this->assertIsArray(
            $empleados
        );
    }
}
