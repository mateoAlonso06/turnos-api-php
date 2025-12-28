<?php

namespace App\Middleware;

class CorsMiddleware
{
    public static function handle(): bool
    {
        // Permitir todos los orígenes (cambiar en producción)
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, Authorization');
        header('Access-Control-Max-Age: 3600');

        // Manejar preflight requests
        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS')
        {
            http_response_code(200);
            return false;
        }

        return true;
    }
}
