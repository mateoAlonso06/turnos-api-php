<?php
require_once __DIR__ . '/vendor/autoload.php';

// Cargar el router con todas las rutas
$router = require_once __DIR__ . '/App/Routes/api.php';

// Despachar la solicitud
$router->dispatch();
