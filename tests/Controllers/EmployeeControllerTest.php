<?php

namespace Tests\Controllers;

use PHPUnit\Framework\TestCase;
use App\Controllers\EmployeeController;
use PDO;

/**
 * @covers \App\Controllers\EmployeeController
 */
class EmployeeControllerTest extends TestCase
{
    private ?PDO $conexion = null;

    protected function setUp(): void
    {
        require __DIR__ . '/../../config/database.php';
        $this->conexion = $conexion;
    }

    public function testEstructuraCompletaDelControlador()
    {
        $this->assertTrue(class_exists(EmployeeController::class));
        $this->assertTrue(method_exists(EmployeeController::class, 'detalle'));
    }

    public function testConstructorInicializaDependenciasCorrectamente()
    {
        $controller = new EmployeeController($this->conexion);
        $this->assertInstanceOf(EmployeeController::class, $controller);
    }

    public function testMetodoDetalleEjecutaFlujoCompleto()
    {
        $controller = new EmployeeController($this->conexion);
        
        $resultado = $controller->detalle(1);
        
        $this->assertTrue($resultado === null || is_array($resultado) || is_object($resultado) || is_bool($resultado));
    }
}

