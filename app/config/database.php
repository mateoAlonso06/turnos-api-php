<?php

namespace App\Config;

class Database 
{
    private static \PDO $connection;

    public static function getConnection(): \PDO
    {
        if (!isset(self::$connection))
        {
            self::$connection = new \PDO(
                'mysql:host=localhost;dbname=turnos_db',
                'user',
                'password',
                [
                    \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
                ]
            );
        }
        return self::$connection;
    }
}