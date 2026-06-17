<?php

namespace Tests\Repositories;

use PHPUnit\Framework\TestCase;
use App\Repositories\NotificationRepository;
use PDO;

class NotificationRepositoryTest extends TestCase
{
    private PDO $conexion;
    private NotificationRepository $repository;

    protected function setUp(): void
    {
       
        require __DIR__ . '/../../config/database.php';

       $host = getenv('DB_HOST') ?: '127.0.0.1';
        $dbname = getenv('DB_NAME') ?: 'control_asistencias_qr';
        $user = getenv('DB_USER') ?: 'root';
        $password = getenv('DB_PASSWORD') ?: 'juan123';

        $this->conexion = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
        $this->repository = new \App\Repositories\NotificationRepository($this->conexion);
    } 

    public function testCrearNotificacion()
    {
       
        $this->conexion->beginTransaction();

        try {
            $resultado = $this->repository->crear(
                'Notificación PHPUnit'
            );

            $this->assertTrue($resultado);

            // Borramos el cambio para mantener tu base de datos limpia
            $this->conexion->rollBack();

        } catch (\Exception $e) {
            $this->conexion->rollBack();
            throw $e;
        }
    }
}

