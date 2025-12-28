<?php

namespace App\Model;

final class Professional 
{
    private int $id;
    private int $userId;
    private string $name;
    private string $specialty;
    private string $phone;
    private bool $active;
    private string $createdAt;

    // Constructor privado - usar métodos estáticos para crear instancias
    private function __construct(int $id, int $userId, string $name, string $specialty, string $phone, bool $active, string $createdAt)
    {
        $this->id = $id;
        $this->userId = $userId;
        $this->name = $name;
        $this->specialty = $specialty;
        $this->phone = $phone;
        $this->active = $active;
        $this->createdAt = $createdAt;
    }

    // Named constructor: Crear nuevo profesional (sin id ni createdAt)
    public static function createNew(int $userId, string $name, string $specialty, string $phone, bool $active = true): self
    {
        return new self(0, $userId, $name, $specialty, $phone, $active, '');
    }

    // Named constructor: Crear desde base de datos (con todos los datos)
    public static function fromDatabase(int $id, int $userId, string $name, string $specialty, string $phone, bool $active, string $createdAt): self
    {
        return new self($id, $userId, $name, $specialty, $phone, $active, $createdAt);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getSpecialty(): string
    {
        return $this->specialty;
    }

    public function setSpecialty(string $specialty): void
    {
        $this->specialty = $specialty;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): void
    {
        $this->phone = $phone;
    }

    public function getActive(): bool
    {
        return $this->active;
    }

    public function setActive(bool $active): void
    {
        $this->active = $active;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    public function setCreatedAt(string $createdAt): void
    {
        $this->createdAt = $createdAt;
    }
}
