<?php

namespace Tests\Repositories;

use PHPUnit\Framework\TestCase;

use App\Repositories\AttendanceRepository;

use App\Models\Attendance;

use PDO;

class AttendanceRepositoryTest extends TestCase
{
    private PDO $conexion;

    private AttendanceRepository $repository;


    protected function setUp(): void
    {

    
        $host = getenv('DB_HOST') ?: '127.0.0.1'; 
        $dbname = getenv('DB_NAME') ?: 'control_asistencias_qr';
        $user = getenv('DB_USER') ?: 'root';
        $password = getenv('DB_PASSWORD') ?: 'juan123';  

        $this->conexion = new PDO(
            "mysql:host=$host;dbname=$dbname", 
            $user, 
            $password);

        $this->conexion->setAttribute(
            PDO::ATTR_ERRMODE,
            PDO::ERRMODE_EXCEPTION
        );

        $this->repository =
            new AttendanceRepository(
                $this->conexion
            );
    }

    public function testObtenerAsistenciaHoy()
    {
        $stmt = $this->conexion->query(
            "SELECT empleado_id, fecha FROM asistencias LIMIT 1"
        );

        $fila = $stmt->fetch(PDO::FETCH_ASSOC);

        $asistencia = $this->repository
            ->obtenerAsistenciaHoy(
                $fila['empleado_id'],
                $fila['fecha'] 
            );

        $this->assertNotNull($asistencia);

        $this->assertEquals(
            $fila['empleado_id'],
            $asistencia->empleado_id
        );
    }


    public function testRegistrarEntrada()
    {
        $this->conexion
            ->beginTransaction();

        try {

            $resultado =
                $this->repository
                    ->registrarEntrada(
                        1,
                        date('Y-m-d'),
                        date('H:i:s'),
                        0
                    );

            $this->assertTrue(
                $resultado
            );

            $this->conexion
                ->rollBack();

        } catch (\Exception $e)
        {
            $this->conexion
                ->rollBack();

            throw $e;
        }
    }

    public function testRegistrarSalida()
    {
        $this->conexion
            ->beginTransaction();

        try {

            $stmt =
                $this->conexion->query(
                    "
                    SELECT id
                    FROM asistencias
                    LIMIT 1
                    "
                );

            $id =
                $stmt->fetchColumn();

            $resultado =
                $this->repository
                    ->registrarSalida(
                        $id,
                        '23:59:59'
                    );

            $this->assertTrue(
                $resultado
            );

            $this->conexion
                ->rollBack();

        } catch (\Exception $e)
        {
            $this->conexion
                ->rollBack();

            throw $e;
        }
    }
}
