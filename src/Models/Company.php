<?php

namespace App\Models;


class Company
{
    public int $id;

    public string $nombre;

    public ?string $email;

    public ?string $fecha_registro;
}
