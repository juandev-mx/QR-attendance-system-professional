<?php

namespace Tests\Controllers;

use PHPUnit\Framework\TestCase;

use App\Controllers\EmployeeController;

class EmployeeControllerTest extends TestCase
{
    public function testControllerClassExists()
    {
        $this->assertTrue(
            class_exists(
                EmployeeController::class
            )
        );
    }

    public function testControllerHasDetalleMethod()
    {
        $this->assertTrue(
            method_exists(
                EmployeeController::class,
                'detalle'
            )
        );
    }
}
