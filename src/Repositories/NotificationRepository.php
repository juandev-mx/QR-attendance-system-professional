<?php

namespace App\Repositories;

use PDO;

class NotificationRepository
{
    private PDO $conexion;

    public function __construct(
        PDO $conexion
    )
    {
        $this->conexion =
            $conexion;
    }

    public function crear(
        string $mensaje
    )
    {
        $stmt =
            $this->conexion
                ->prepare(
                    "
                    INSERT INTO notificaciones
                    (
                        mensaje
                    )
                    VALUES
                    (
                        ?
                    )
                    "
                );

        return $stmt->execute([
            $mensaje
        ]);
    }
}
