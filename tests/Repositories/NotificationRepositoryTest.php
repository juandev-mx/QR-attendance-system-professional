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
        // 1. Cargamos el archivo de configuración externa para que inicialice la variable $conexion
        require __DIR__ . '/../../config/database.php';

        // 2. Asignamos la variable real creada por el script en lugar del valor del require
        $this->conexion = $conexion;

        $this->repository =
            new NotificationRepository(
                $this->conexion
            );
    }

    public function testCrearNotificacion()
    {
        // Usamos una transacción para no llenar tu base de datos real de registros de prueba
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

