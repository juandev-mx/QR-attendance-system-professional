<?php

namespace App\Repositories;

use App\Models\Attendance;
use PDO;

class AttendanceRepository
{
    private PDO $conexion;

    public function __construct(PDO $conexion)
    {
        $this->conexion = $conexion;
    }

    public function obtenerAsistenciaHoy(
        int $empleadoId,
        string $fecha
    )
    {
        $sql = "
            SELECT *
            FROM asistencias
            WHERE empleado_id = :empleado
            AND fecha = :fecha
        ";

        $stmt =
            $this->conexion
                ->prepare($sql);

        $stmt->execute([
            'empleado' => $empleadoId,
            'fecha' => $fecha
        ]);

require_once __DIR__ . '/../Models/Attendance.php';

$stmt->setFetchMode(PDO::FETCH_CLASS, \App\Models\Attendance::class);


        return $stmt->fetch();
    }

    public function registrarEntrada(
        int $empleadoId,
        string $fecha,
        string $hora,
        int $retardo
    )
    {
        $sql = "
            INSERT INTO asistencias
            (
                empleado_id,
                fecha,
                hora_entrada,
                retardo
            )
            VALUES
            (
                :empleado,
                :fecha,
                :hora,
                :retardo
            )
        ";

        $stmt = $this->conexion->prepare($sql);

        return $stmt->execute([
            'empleado' => $empleadoId,
            'fecha' => $fecha,
            'hora' => $hora,
            'retardo' => $retardo
        ]);
    }

    public function registrarSalida(
        int $id,
        string $hora
    )
    {
        $sql = "
            UPDATE asistencias
            SET hora_salida = :hora
            WHERE id = :id
        ";

        $stmt = $this->conexion->prepare($sql);

        return $stmt->execute([
            'hora' => $hora,
            'id' => $id
        ]);
    }
}
