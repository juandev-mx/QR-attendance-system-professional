<?php

namespace App\Repositories;

use App\Models\Employee;
use PDO;

class EmployeeRepository
{
    private PDO $conexion;

    public function __construct(PDO $conexion)
    {
        $this->conexion = $conexion;
    }

    public function buscarPorCodigo(string $codigo)
    {
        $sql = "
            SELECT *
            FROM empleados
            WHERE TRIM(qr_token)=:codigo
            OR id=:codigo
        ";

        $stmt =
            $this->conexion
                ->prepare($sql);

        $stmt->execute([
            'codigo' =>
                trim($codigo)
        ]);

        $stmt->setFetchMode(
            PDO::FETCH_CLASS,
            Employee::class
        );

        return $stmt->fetch();
    }

    public function buscarPorId(int $id)
    {
        $sql = "
            SELECT *
            FROM empleados
            WHERE id = :id
        ";

        $stmt =
            $this->conexion
                ->prepare($sql);

        $stmt->execute([
            'id' => $id
        ]);

        $stmt->setFetchMode(
            PDO::FETCH_CLASS,
            Employee::class
        );

        return $stmt->fetch();
    }
}
