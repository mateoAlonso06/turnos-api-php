<?php

namespace App\Repository;

use App\Model\User;
use App\Config\Database;

class UserRepository
{
    private \PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    public function getByEmail(string $email): ?User
    {
        $stmt = $this->db->prepare('SELECT * FROM users WHERE email = ?');
        $stmt->execute([$email]);
        $data = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!$data)
            return null;

        return new User(
            $data['id'],
            $data['email'],
            $data['password_hash'],
            $data['role']
        );
    }

    public function create(string $email, string $passwordHash): User
    {
        $stmt = $this->db->prepare('INSERT INTO users (email, password_hash) VALUES (?, ?)');
        $stmt->execute([$email, $passwordHash]);

        $id = (int)$this->db->lastInsertId();

        return new User($id, $email, $passwordHash, 'PROFESSIONAL');
    }
}