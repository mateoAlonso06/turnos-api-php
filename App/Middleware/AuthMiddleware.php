<?php

namespace App\Middleware;

use App\Utils\JwtUtils;
use Exception;

class AuthMiddleware
{
    public static function handle(): bool
    {
        try
        {
            $token = JwtUtils::getTokenFromHeader();

            if (!$token)
            {
                http_response_code(401);
                echo json_encode(['error' => 'Token not provided']);
                return false;
            }

            $decoded = JwtUtils::validateToken($token);

            // Guardar los datos del usuario en $_SERVER para acceso posterior
            $_SERVER['USER_ID'] = $decoded->userId;
            $_SERVER['USER_EMAIL'] = $decoded->email;
            $_SERVER['USER_ROLE'] = $decoded->role;

            return true;
        }
        catch (Exception $e)
        {
            http_response_code(401);
            echo json_encode(['error' => 'Invalid or expired token']);
            return false;
        }
    }
}
