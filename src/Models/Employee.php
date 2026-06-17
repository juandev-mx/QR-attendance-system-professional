<?php

namespace App\Models;


class Employee
{
    public int $id;

    public string $numero_empleado;

    public string $nombre;

    public string $apellido_paterno;

    public ?string $apellido_materno;

    public ?string $puesto;

    public ?int $departamento_id;

    public ?string $email;

    public ?string $qr_codigo;

    public bool $activo;

    public ?string $fecha_registro;

    public ?string $qr_token;

    public ?int $empresa_id;

    public ?string $hora_entrada;
}
