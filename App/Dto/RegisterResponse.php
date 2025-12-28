<?php

namespace App\Dto;

class RegisterResponse
{
    public readonly int $id;
    public readonly string $name;
    public readonly string $email;
    public readonly string $role;

    public function __construct(int $id, string $name, string $email, string $role)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->role = $role;
    }
}