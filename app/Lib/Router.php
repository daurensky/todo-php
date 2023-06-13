<?php

namespace App\Lib;

use Exception;

class Router
{
    /**
     * @throws Exception
     */
    public static function handle(array $routes): Response|View
    {
        $path = parse_url($_SERVER['REQUEST_URI'])['path'];

        if ($path !== '/') {
            $path = rtrim($path, '/');
        }

        $method = $_SERVER['REQUEST_METHOD'];

        if (!isset($routes[$path])) {
            return response('Page not found')
                ->withCode(405);
        }

        if (!isset($routes[$path][$method])) {
            return response('Method not allowed')
                ->withCode(405);
        }

        return $routes[$path][$method]();
    }
}
