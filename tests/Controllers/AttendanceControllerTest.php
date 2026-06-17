<?php

namespace Tests\Controllers;

use PHPUnit\Framework\TestCase;

use App\Controllers\AttendanceController;

class AttendanceControllerTest extends TestCase
{
    public function testControllerClassExists()
    {
        $this->assertTrue(
            class_exists(
                AttendanceController::class
            )
        );
    }

    public function testControllerHasBuscarEmpleadoMethod()
    {
        $this->assertTrue(
            method_exists(
                AttendanceController::class,
                'buscarEmpleado'
            )
        );
    }

    public function testControllerHasProcesarAsistenciaMethod()
    {
        $this->assertTrue(
            method_exists(
                AttendanceController::class,
                'procesarAsistencia'
            )
        );
    }
}
