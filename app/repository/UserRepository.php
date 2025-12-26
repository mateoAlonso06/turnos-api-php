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
            $data['name'],
            $data['email'],
            $data['password'],
            $data['role']
        );
    }
}