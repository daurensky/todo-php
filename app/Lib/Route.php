<?php

namespace App\Lib;

class Route
{
    private static array $routes = [];

    public static function get(string $url, array $controller): void
    {
        self::request($url, $controller, 'GET');
    }

    public static function post(string $url, array $controller): void
    {
        self::request($url, $controller, 'POST');
    }

    private static function request(string $url, callable $callback, string $method): void
    {
        $url = '/' . ltrim($url, '/');
        static::$routes[$url][$method] = $callback;
    }

    public static function getRoutes(): array
    {
        return static::$routes;
    }
}
