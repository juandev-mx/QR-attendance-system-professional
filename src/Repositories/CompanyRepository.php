<?php

namespace App\Repositories;

use App\Models\Company;
use App\Models\Employee;
use PDO;

class CompanyRepository
{
    private PDO $conexion;

    public function __construct(
        PDO $conexion
    )
    {
        $this->conexion = $conexion;
    }

    public function obtenerTodas()
    {
        $sql = "
            SELECT *
            FROM empresas
            ORDER BY nombre ASC
        ";

        $stmt =
            $this->conexion->prepare($sql);

        $stmt->execute();

        return $stmt->fetchAll(
            PDO::FETCH_CLASS,
            Company::class
        );
    }

    public function buscarPorId(
        int $id
    )
    {
        $sql = "
            SELECT *
            FROM empresas
            WHERE id = :id
        ";

        $stmt =
            $this->conexion
                ->prepare($sql);

        $stmt->execute([
            'id' => $id
        ]);

        $stmt->setFetchMode(PDO::FETCH_CLASS, 'App\Models\Company');


        return $stmt->fetch();
    }

    public function obtenerEmpleados(
        int $empresaId
    )
    {
        $sql = "
            SELECT *
            FROM empleados
            WHERE empresa_id = :empresa
            ORDER BY nombre ASC
        ";

        $stmt =
            $this->conexion
                ->prepare($sql);

        $stmt->execute([
            'empresa' => $empresaId
        ]);

        return $stmt->fetchAll(
            PDO::FETCH_CLASS,
            Employee::class
        );
    }
}

