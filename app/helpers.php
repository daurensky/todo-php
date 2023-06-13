<?php

use App\Lib\Url;
use App\Lib\View;
use App\Lib\Response;

if (!function_exists('root_dir')) {
    function root_dir(string $path = ''): string
    {
        return __DIR__ . '/../' . ltrim($path, '/');
    }
}

if (!function_exists('view')) {
    function view(string $file): View
    {
        return new View($file);
    }
}

if (!function_exists('env')) {
    function env(string $key, ?string $default = null): string
    {
        return $_ENV[$key] ?? $default;
    }
}

if (!function_exists('response')) {
    function response(?string $message = null): Response
    {
        return new Response($message);
    }
}

if (!function_exists('url')) {
    function url(?string $url = null): Url
    {
        return new Url($url);
    }
}

if (!function_exists('old')) {
    function old(string $key): string
    {
        return $_SESSION['flash']['old'][$key] ?? '';
    }
}

if (!function_exists('error')) {
    function error(string $key): string
    {
        return $_SESSION['flash']['errors'][$key] ?? '';
    }
}

if (!function_exists('redirect')) {
    function redirect(string $location): Response
    {
        if (isset(parse_url($location)['host'])) {
            return response()->withHeaders(['Location: ' . $location]);
        }

        $appUrl = rtrim(env('APP_URL', 'http://localhost'), '/');
        $location = ltrim($location, '/');
        return response()->withHeaders(['Location: ' . $appUrl . '/' . $location]);
    }
}

if (!function_exists('back')) {
    function back(): Response
    {
        return redirect($_SERVER['HTTP_REFERER']);
    }
}
