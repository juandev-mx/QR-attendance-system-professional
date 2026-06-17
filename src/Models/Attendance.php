<?php

namespace App\Models;


class Attendance
{
    public int $id;

    public int $empleado_id;

    public string $fecha;

    public ?string $hora_entrada;

    public ?string $hora_salida;

    public string $estado;

    public ?string $metodo_registro;

    public ?string $fecha_registro;

    public int $retardo;

}
