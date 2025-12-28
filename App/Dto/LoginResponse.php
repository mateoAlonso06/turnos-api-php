<?php

namespace App\Dto;

class LoginResponse
{
    public readonly int $id;
    public readonly string $nombre;
    public readonly string $email;
    public readonly string $rol;
    public readonly string $jwtToken;

    public function __construct(
        int $id,
        string $nombre,
        string $email,
        string $rol,
        string $jwtToken
    ) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->email = $email;
        $this->rol = $rol;
        $this->jwtToken = $jwtToken;
    }
}