<?php

class Database 
{
    private static ?PDO $connection = null;

    public static function getConnection(): PDO
    {
        if (self::$connection === null)
        {
            self::$connection = new PDO(
                'mysql:host=localhost;dbname=turnos_db',
                'user',
                'password'
            );
        }
        return self::$connection;
    }
}