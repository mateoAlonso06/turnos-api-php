<?php

namespace App\Utils;

class PasswordEncoder
{
    private const ALGORITHM = PASSWORD_BCRYPT;
    private const COST = 12;

    public static function hash(string $password): string
    {
        return password_hash($password, self::ALGORITHM, ['cost' => self::COST]);
    }

    public static function verify(string $password, string $hash): bool
    {
        return password_verify($password, $hash);
    }

    public static function needsRehash(string $hash): bool
    {
        return password_needs_rehash($hash, self::ALGORITHM, ['cost' => self::COST]);
    }
}
