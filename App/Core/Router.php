<?php

namespace App\Core;

class Router
{
    private array $routes = [];
    private array $middlewares = [];

    public function get(string $path, callable|array $handler, array $middlewares = []): void
    {
        $this->addRoute('GET', $path, $handler, $middlewares);
    }

    public function post(string $path, callable|array $handler, array $middlewares = []): void
    {
        $this->addRoute('POST', $path, $handler, $middlewares);
    }

    public function put(string $path, callable|array $handler, array $middlewares = []): void
    {
        $this->addRoute('PUT', $path, $handler, $middlewares);
    }

    public function delete(string $path, callable|array $handler, array $middlewares = []): void
    {
        $this->addRoute('DELETE', $path, $handler, $middlewares);
    }

    private function addRoute(string $method, string $path, callable|array $handler, array $middlewares): void
    {
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'handler' => $handler,
            'middlewares' => $middlewares
        ];
    }

    public function addGlobalMiddleware(callable $middleware): void
    {
        $this->middlewares[] = $middleware;
    }

    public function dispatch(): void
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        // Ejecutar middlewares globales
        foreach ($this->middlewares as $middleware)
        {
            $result = $middleware();
            if ($result === false)
            {
                return;
            }
        }

        // Buscar la ruta
        foreach ($this->routes as $route)
        {
            if ($route['method'] === $method && $this->matchPath($route['path'], $uri))
            {
                // Ejecutar middlewares específicos de la ruta
                foreach ($route['middlewares'] as $middleware)
                {
                    $result = $middleware();
                    if ($result === false)
                    {
                        return;
                    }
                }

                // Ejecutar el handler
                $handler = $route['handler'];
                if (is_array($handler))
                {
                    [$controller, $method] = $handler;
                    $controller->$method();
                }
                else
                {
                    $handler();
                }
                return;
            }
        }

        // Ruta no encontrada
        http_response_code(404);
        echo json_encode(['error' => 'Route not found']);
    }

    private function matchPath(string $pattern, string $uri): bool
    {
        return $pattern === $uri;
    }
}
