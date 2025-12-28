<?php

namespace App\Dto;

class LoginRequest
{
    public readonly string $email;
    public readonly string $password;

    public function __construct(string $email, string $password)
    {
        $this->email = $email;
        $this->password = $password;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public static function fromArray(array $data): self
    {   
        // Basic validation for required fields
        if (!isset($data['email'], $data['password'])) {
            throw new \InvalidArgumentException('Email and password required');
        }

        return new self(
            $data['email'],
            $data['password']
        );
    }
}