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
        $host = getenv('DB_HOST') ?: '127.0.0.1';
        $dbname = getenv('DB_NAME') ?: 'control_asistencias_qr';
        $user = getenv('DB_USER') ?: 'root';
        $password = getenv('DB_PASSWORD') ?: 'juan123';

        $this->conexion = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
        $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $this->repository = new \App\Repositories\CompanyRepository($this->conexion);
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
