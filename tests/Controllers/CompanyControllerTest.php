<?php

namespace Tests\Controllers;

use PHPUnit\Framework\TestCase;

use App\Controllers\CompanyController;

class CompanyControllerTest extends TestCase
{
    public function testControllerClassExists()
    {
        $this->assertTrue(
            class_exists(
                CompanyController::class
            )
        );
    }

    public function testControllerHasListarMethod()
    {
        $this->assertTrue(
            method_exists(
                CompanyController::class,
                'listar'
            )
        );
    }

    public function testControllerHasDetalleMethod()
    {
        $this->assertTrue(
            method_exists(
                CompanyController::class,
                'detalle'
            )
        );
    }

    public function testControllerHasEmpleadosMethod()
    {
        $this->assertTrue(
            method_exists(
                CompanyController::class,
                'empleados'
            )
        );
    }
}
