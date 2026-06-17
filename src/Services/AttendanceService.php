<?php
namespace App\Services;

use App\Repositories\AttendanceRepository;
use App\Repositories\NotificationRepository;
use App\Repositories\EmployeeRepository;
use App\Models\Attendance;
use App\Models\Employee;
use PDO;
use Exception;

class AttendanceService
{
    private AttendanceRepository $attendanceRepository;
    private PDO $conexion;
    private NotificationRepository $notificationRepository;
    private EmployeeRepository $employeeRepository;

public function __construct(
    EmployeeRepository $employeeRepository,
    AttendanceRepository $attendanceRepository,
    NotificationRepository $notificationRepository
)
{
    $this->employeeRepository =
        $employeeRepository;

    $this->attendanceRepository =
        $attendanceRepository;

    $this->notificationRepository =
        $notificationRepository;
}

public function obtenerAsistenciaHoy(
    int $empleadoId,
    string $fecha
)
{
    return $this->attendanceRepository
        ->obtenerAsistenciaHoy(
            $empleadoId,
            $fecha
        );
}

public function procesarAsistencia(
    string $codigo
)
{
    $empleado =
        $this->buscarEmpleado(
            $codigo
        );

    if (!$empleado)
    {
        throw new Exception(
            "Empleado no encontrado"
        );
    }

    $fecha =
        date("Y-m-d");

    $registro =
        $this->attendanceRepository
            ->obtenerAsistenciaHoy(
                $empleado->id,
                $fecha
            );

    if (!$registro)
    {
        return $this
            ->registrarEntrada(
                $empleado
            );
    }

    if ($registro->hora_salida === null)
    {
        return $this
            ->registrarSalida(
                $registro,
                $empleado->nombre
            );
    }

    throw new Exception(
        "Asistencia ya registrada hoy"
    );
}

public function registrarSalida(
    Attendance $registro,
    string $nombre
)
{
    $hora = date("H:i:s");

    $horaEntradaUnix =
        strtotime(
            $registro->hora_entrada
        );

    $horaActualUnix =
        strtotime($hora);

    $diferenciaMinutos =
        (
            $horaActualUnix -
            $horaEntradaUnix
        ) / 60;

    if ($diferenciaMinutos < 5)
    {
        throw new Exception(
            "Espera al menos 5 minutos para marcar salida (Llevas: "
            .
            round($diferenciaMinutos,1)
            .
            " min)"
        );
    }

    $this->attendanceRepository
        ->registrarSalida(
            $registro->id,
            $hora
        );

$this->notificationRepository
    ->crear(
        $nombre
        .
        " registró SALIDA"
    );

    return [
        'hora' => $hora,
        'mensaje' =>
            $nombre .
            " registró SALIDA"
    ];
}

public function registrarSalidaEmpleado(
    Attendance $registro,
    string $nombre
)
{
    return $this->registrarSalida(
        $registro,
        $nombre
    );
}

public function registrarEntradaEmpleado(
    Employee $empleado
)
{
    return $this
        ->registrarEntrada(
            $empleado
        );
}

public function registrarEntrada(
    Employee $empleado
)
{
    $fecha = date("Y-m-d");

    $hora = date("H:i:s");

    $retardo = 0;

    if (
        $hora >
        $empleado->hora_entrada
    ) {
        $retardo = 1;
    }

    $this->attendanceRepository
        ->registrarEntrada(
            $empleado->id,
            $fecha,
            $hora,
            $retardo
        );

$mensaje =
    $empleado->nombre
    .
    (
        $retardo
        ?
        " registró ENTRADA con RETARDO"
        :
        " registró ENTRADA"
    );

$this->notificationRepository
    ->crear($mensaje);

    return [
        'retardo' => $retardo,
        'hora' => $hora
    ];
}

    public function buscarEmpleado(
    string $codigo
)
{
    return
        $this->employeeRepository
            ->buscarPorCodigo(
                $codigo
            );
}


}
