<?php

namespace Tests\Services;

use PHPUnit\Framework\TestCase;

use App\Services\AttendanceService;

use App\Repositories\EmployeeRepository;
use App\Repositories\AttendanceRepository;
use App\Repositories\NotificationRepository;

use App\Models\Attendance;
use App\Models\Employee;

use PDO;

class AttendanceServiceTest extends TestCase
{
    private $employeeRepository;

    private $attendanceRepository;

    private $notificationRepository;

    private AttendanceService $service;

    protected function setUp(): void
    {
        $this->employeeRepository =
            $this->createMock(
                EmployeeRepository::class
            );

        $this->attendanceRepository =
            $this->createMock(
                AttendanceRepository::class
            );

        $this->notificationRepository =
            $this->createMock(
                NotificationRepository::class
            );

        $this->service =
            new AttendanceService(
                $this->employeeRepository,
                $this->attendanceRepository,
                $this->notificationRepository
            );
    }

    public function testServiceCanBeCreated()
    {
        $this->assertInstanceOf(
            AttendanceService::class,
            $this->service
        );
    }

public function testRegistrarEntrada()
{
    $employee =
        new Employee();

    $employee->id = 1;
    $employee->nombre = "Juan";
    $employee->hora_entrada = "08:00:00";

    $employeeRepository =
        $this->createMock(
            EmployeeRepository::class
        );

    $attendanceRepository =
        $this->createMock(
            AttendanceRepository::class
        );

    $notificationRepository =
        $this->createMock(
            NotificationRepository::class
        );

    $attendanceRepository
        ->expects($this->once())
        ->method('registrarEntrada');

    $notificationRepository
        ->expects($this->once())
        ->method('crear');

    $service =
        new AttendanceService(
            $employeeRepository,
            $attendanceRepository,
            $notificationRepository
        );

    $resultado =
        $service->registrarEntrada(
            $employee
        );

    $this->assertArrayHasKey(
        'hora',
        $resultado
    );
}

public function testProcesarAsistenciaEmpleadoNoEncontrado()
{
    $this->employeeRepository
        ->method('buscarPorCodigo')
        ->willReturn(null);

    $this->expectException(
        \Exception::class
    );

    $this->expectExceptionMessage(
        "Empleado no encontrado"
    );

    $this->service
        ->procesarAsistencia(
            "QR123"
        );
}

public function testProcesarAsistenciaRegistrarEntrada()
{
    $employee =
        new Employee();

    $employee->id = 1;
    $employee->nombre = "Juan";
    $employee->hora_entrada = "08:00:00";

    $this->employeeRepository
        ->method('buscarPorCodigo')
        ->willReturn($employee);

    $this->attendanceRepository
        ->method('obtenerAsistenciaHoy')
        ->willReturn(null);

    $this->attendanceRepository
        ->expects($this->once())
        ->method('registrarEntrada');

    $this->notificationRepository
        ->expects($this->once())
        ->method('crear');

    $resultado =
        $this->service
            ->procesarAsistencia(
                "QR123"
            );

    $this->assertArrayHasKey(
        'hora',
        $resultado
    );
}

public function testRegistrarSalidaLanzaExcepcionSiMenorA5Minutos()
{
    $attendance =
        new Attendance();

    $attendance->id = 1;

    $attendance->hora_entrada =
        date("H:i:s");

    $this->expectException(
        \Exception::class
    );

    $this->expectExceptionMessage(
        "Espera al menos 5 minutos"
    );

    $this->service
        ->registrarSalida(
            $attendance,
            "Juan"
        );
}

public function testRegistrarSalidaCorrectamente()
{
    $attendance =
        new Attendance();

    $attendance->id = 1;

    $attendance->hora_entrada =
        date(
            "H:i:s",
            strtotime("-10 minutes")
        );

    $this->attendanceRepository
        ->expects($this->once())
        ->method('registrarSalida');

    $this->notificationRepository
        ->expects($this->once())
        ->method('crear');

    $resultado =
        $this->service
            ->registrarSalida(
                $attendance,
                "Juan"
            );

    $this->assertArrayHasKey(
        'hora',
        $resultado
    );

    $this->assertArrayHasKey(
        'mensaje',
        $resultado
    );
}

public function testProcesarAsistenciaRegistrarSalida()
{
    $employee =
        new Employee();

    $employee->id = 1;
    $employee->nombre = "Juan";

    $attendance =
        new Attendance();

    $attendance->id = 10;

    $attendance->hora_entrada =
        date(
            "H:i:s",
            strtotime("-10 minutes")
        );

    $attendance->hora_salida =
        null;

    $this->employeeRepository
        ->method('buscarPorCodigo')
        ->willReturn($employee);

    $this->attendanceRepository
        ->method('obtenerAsistenciaHoy')
        ->willReturn($attendance);

    $this->attendanceRepository
        ->expects($this->once())
        ->method('registrarSalida');

    $this->notificationRepository
        ->expects($this->once())
        ->method('crear');

    $resultado =
        $this->service
            ->procesarAsistencia(
                "QR123"
            );

    $this->assertArrayHasKey(
        'hora',
        $resultado
    );

    $this->assertArrayHasKey(
        'mensaje',
        $resultado
    );
}

public function testProcesarAsistenciaYaRegistrada()
{
    $employee =
        new Employee();

    $employee->id = 1;
    $employee->nombre = "Juan";

    $attendance =
        new Attendance();

    $attendance->id = 10;

    $attendance->hora_entrada =
        "08:00:00";

    $attendance->hora_salida =
        "17:00:00";

    $this->employeeRepository
        ->method('buscarPorCodigo')
        ->willReturn($employee);

    $this->attendanceRepository
        ->method('obtenerAsistenciaHoy')
        ->willReturn($attendance);

    $this->expectException(
        \Exception::class
    );

    $this->expectExceptionMessage(
        "Asistencia ya registrada hoy"
    );

    $this->service
        ->procesarAsistencia(
            "QR123"
        );
}

}
