<?php

namespace Tests\Controllers;

use PHPUnit\Framework\TestCase;
use App\Controllers\CompanyController;
use PDO;

/**
 * @covers \App\Controllers\CompanyController
 */
class CompanyControllerTest extends TestCase
{
    private PDO $conexion;

    protected function setUp(): void
    {
        require __DIR__ . '/../../config/database.php';
        
        $this->conexion = $conexion;
    }

    public function testControllerClassExists()
    {
        $this->assertTrue(class_exists(CompanyController::class));
    }

    public function testControllerHasListarMethod()
    {
        $this->assertTrue(method_exists(CompanyController::class, 'listar'));
    }

    public function testControllerHasDetalleMethod()
    {
        $this->assertTrue(method_exists(CompanyController::class, 'detalle'));
    }

    public function testControllerHasEmpleadosMethod()
    {
        $this->assertTrue(method_exists(CompanyController::class, 'empleados'));
    }

    public function testEjecucionListarEmpresas()
    {
        $controller = new CompanyController($this->conexion);
        $resultado = $controller->listar();
        
        $this->assertIsArray($resultado);
    }

    public function testEjecucionDetalleEmpresa()
    {
        $controller = new CompanyController($this->conexion);
        $resultado = $controller->detalle(1);
        
        $this->assertNotNull($resultado);
    }

    public function testEjecucionEmpleadosEmpresa()
    {
        $controller = new CompanyController($this->conexion);
        $resultado = $controller->empleados(1);
        
        $this->assertNotNull($resultado);
    }
}

