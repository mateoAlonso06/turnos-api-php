<?php

namespace App\Middleware;

class JsonMiddleware
{
    public static function handle(): bool
    {
        header('Content-Type: application/json; charset=utf-8');
        return true;
    }
}
