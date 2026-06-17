<?php

namespace Tests\Repositories;

use PHPUnit\Framework\TestCase;

use App\Repositories\EmployeeRepository;

use PDO;

class EmployeeRepositoryTest extends TestCase
{
    private PDO $conexion;

    private EmployeeRepository $repository;

    
        protected function setUp(): void
    {
        $host = getenv('DB_HOST') ?: '127.0.0.1';
        $dbname = getenv('DB_NAME') ?: 'control_asistencias_qr';
        $user = getenv('DB_USER') ?: 'root';
        $password = getenv('DB_PASSWORD') ?: 'juan123';

        $this->conexion = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
        $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $this->repository = new \App\Repositories\EmployeeRepository($this->conexion);
    }


    public function testBuscarPorId()
    {
        $empleado =
            $this->repository
                ->buscarPorId(1);

        $this->assertNotNull(
            $empleado
        );

        $this->assertEquals(
            1,
            $empleado->id
        );
    }

    public function testBuscarPorCodigo()
    {
        $stmt =
            $this->conexion->query(
                "
                SELECT qr_token
                FROM empleados
                LIMIT 1
                "
            );

        $token =
            $stmt->fetchColumn();

        $empleado =
            $this->repository
                ->buscarPorCodigo(
                    $token
                );

        $this->assertNotNull(
            $empleado
        );
    }
}
