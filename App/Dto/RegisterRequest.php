<?php

namespace App\Dto;

class RegisterRequest
{
    public readonly string $name;
    public readonly string $email;
    public readonly string $password;
    public readonly string $specialty;
    public readonly string $phone;
    
    public function __construct(string $name, string $email, string $password, string $specialty, string $phone)
    {
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->specialty = $specialty;
        $this->phone = $phone;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getSpecialty(): string
    {
        return $this->specialty;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public static function fromArray(array $data): self
    {
        if (!isset($data['name'], $data['email'], $data['password'], $data['specialty'], $data['phone'])) 
            throw new \InvalidArgumentException('Name, email, password, specialty, and phone are required');

        return new self(
            $data['name'],
            $data['email'],
            $data['password'],
            $data['specialty'],
            $data['phone']
        );
    }
}