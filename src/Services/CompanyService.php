<?php

namespace App\Services;

use App\Repositories\CompanyRepository;
use Exception;

class CompanyService
{
    private CompanyRepository
        $companyRepository;

    public function __construct(
        CompanyRepository $companyRepository
    )
    {
        $this->companyRepository =
            $companyRepository;
    }

    public function listarEmpresas()
    {
        return
            $this->companyRepository
                ->obtenerTodas();
    }

    public function obtenerEmpresa(
        int $id
    )
    {
        $empresa =
            $this->companyRepository
                ->buscarPorId($id);

        if (!$empresa)
        {
            throw new Exception(
                "Empresa no encontrada"
            );
        }

        return $empresa;
    }

    public function obtenerEmpleadosEmpresa(
        int $empresaId
    )
    {
        return
            $this->companyRepository
                ->obtenerEmpleados(
                    $empresaId
                );
    }
}
