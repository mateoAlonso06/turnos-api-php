<?php

namespace App\Config;

class Database 
{
    private static \PDO $connection;

    public static function getConnection(): \PDO
    {
        if (!isset(self::$connection))
        {
            $host = getenv('DB_HOST') ?: 'db';
            $dbname = getenv('MYSQL_DATABASE') ?: 'turnos_db';
            $user = getenv('MYSQL_USER') ?: 'user';
            $password = getenv('MYSQL_PASSWORD') ?: 'password';

            self::$connection = new \PDO(
                "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
                $user,
                $password,
                [
                    \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                    \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                    \PDO::ATTR_EMULATE_PREPARES => false
                ]
            );
        }
        return self::$connection;
    }
}