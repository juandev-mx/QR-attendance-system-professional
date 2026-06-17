<?php
namespace App\Controllers;

use App\Services\CompanyService;
use PDO;

use App\Repositories\CompanyRepository;

class CompanyController
{
    private CompanyService $service;

    public function __construct(PDO $conexion)
    {
$repository =
    new CompanyRepository(
        $conexion
    );	

        $this->service =
            new CompanyService(
                $repository
            );
    }

    public function listar()
    {
        return $this->service
            ->listarEmpresas();
    }

    public function detalle(int $id)
    {
        return $this->service
            ->obtenerEmpresa($id);
    }

    public function empleados(int $empresaId)
    {
        return $this->service
            ->obtenerEmpleadosEmpresa(
                $empresaId
            );
    }
}
