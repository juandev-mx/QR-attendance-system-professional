<?php

namespace Tests\Services;

use PHPUnit\Framework\TestCase;

use App\Services\AttendanceService;

use App\Repositories\EmployeeRepository;
use App\Repositories\AttendanceRepository;
use App\Repositories\NotificationRepository;

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


}
