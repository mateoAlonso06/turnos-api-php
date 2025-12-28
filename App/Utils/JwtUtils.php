<?php

namespace App\Utils;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Exception;

class JwtUtils
{
    private const SECRET_KEY = 'secret_key_example';
    private const ALGORITHM = 'HS256';
    private const EXPIRATION_TIME = 3600; // 1 hora en segundos

    public static function generateToken(int $userId, string $email, string $role): string
    {
        $issuedAt = time();
        $expirationTime = $issuedAt + self::EXPIRATION_TIME;

        $payload = [
            'iat' => $issuedAt,
            'exp' => $expirationTime,
            'userId' => $userId,
            'email' => $email,
            'role' => $role
        ];

        return JWT::encode($payload, self::SECRET_KEY, self::ALGORITHM);
    }

    public static function validateToken(string $token): object
    {
        try
        {
            return JWT::decode($token, new Key(self::SECRET_KEY, self::ALGORITHM));
        }
        catch (Exception $e)
        {
            throw new Exception('Invalid or expired token: ' . $e->getMessage());
        }
    }

    public static function getTokenFromHeader(): ?string
    {
        $headers = getallheaders();
        
        if (isset($headers['Authorization']))
        {
            $authHeader = $headers['Authorization'];
            
            if (preg_match('/Bearer\s+(.*)$/i', $authHeader, $matches))
            {
                return $matches[1];
            }
        }
        
        return null;
    }
}
