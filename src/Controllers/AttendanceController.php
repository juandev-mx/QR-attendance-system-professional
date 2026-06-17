<?php
namespace App\Controllers;

use App\Services\AttendanceService;

use PDO;

use App\Repositories\EmployeeRepository;
use App\Repositories\AttendanceRepository;
use App\Repositories\NotificationRepository;

use App\Models\Attendance;

class AttendanceController
{
    private AttendanceService $service;

public function __construct(PDO $conexion)
{
    $employeeRepository =
        new EmployeeRepository(
            $conexion
        );

    $attendanceRepository =
        new AttendanceRepository(
            $conexion
        );

    $notificationRepository =
        new NotificationRepository(
            $conexion
        );

    $this->service =
        new AttendanceService(
            $employeeRepository,
            $attendanceRepository,
            $notificationRepository
        );
}

    public function buscarEmpleado(
        string $codigo
    )
    {
        return $this->service
            ->buscarEmpleado($codigo);
    }

public function registrarSalidaEmpleado(
    Attendance $registro,
    string $nombre
)
{
    return $this->service
        ->registrarSalidaEmpleado(
            $registro,
            $nombre
        );
}

public function procesarAsistencia(
    string $codigo
)
{
    return $this->service
        ->procesarAsistencia(
            $codigo
        );
}

}
