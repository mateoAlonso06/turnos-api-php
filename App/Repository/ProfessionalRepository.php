<?php

namespace App\Repository;

use App\Model\Professional;
use App\Config\Database;

class ProfessionalRepository
{
    private \PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function create(Professional $professional): int
    {
        $stmt = $this->db->prepare('INSERT INTO professionals (user_id, name, specialty, phone, active) VALUES (?, ?, ?, ?, ?)');
        $stmt->execute([
            $professional->getUserId(),
            $professional->getName(),
            $professional->getSpecialty(),
            $professional->getPhone(),
            $professional->getActive()
        ]);

        return (int) $this->db->lastInsertId();
    }

    public function getById(int $id): ?Professional
    {
        $stmt = $this->db->prepare('SELECT * FROM professionals WHERE id = ?');
        $stmt->execute([$id]);
        $data = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($data)
        {
            return Professional::fromDatabase(
                $data['id'],
                $data['user_id'],
                $data['name'],
                $data['specialty'],
                $data['phone'],
                (bool)$data['active'],
                $data['created_at']
            );
        }

        return null;
    }

    public function getByUserId(int $userId): ?Professional
    {
        $stmt = $this->db->prepare('SELECT * FROM professionals WHERE user_id = ?');
        $stmt->execute([$userId]);
        $data = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($data)
        {
            return Professional::fromDatabase(
                $data['id'],
                $data['user_id'],
                $data['name'],
                $data['specialty'],
                $data['phone'],
                (bool)$data['active'],
                $data['created_at']
            );
        }

        return null;
    }

    public function getAll(): array
    {
        $stmt = $this->db->prepare('SELECT * FROM professionals WHERE active = 1');
        $stmt->execute();
        $data = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $professionals = [];
        foreach ($data as $row)
        {
            $professionals[] = Professional::fromDatabase(
                $row['id'],
                $row['user_id'],
                $row['name'],
                $row['specialty'],
                $row['phone'],
                (bool)$row['active'],
                $row['created_at']
            );
        }

        return $professionals;
    }
}
