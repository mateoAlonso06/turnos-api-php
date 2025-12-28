<?php

use App\Core\Router;
use App\Middleware\CorsMiddleware;
use App\Middleware\JsonMiddleware;

$router = new Router();

// Middlewares globales
$router->addGlobalMiddleware(fn() => CorsMiddleware::handle());
$router->addGlobalMiddleware(fn() => JsonMiddleware::handle());

// Cargar rutas específicas
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/professionals.php';

return $router;
