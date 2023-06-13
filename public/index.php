<?php

session_start();

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../routes.php';

Dotenv\Dotenv::createImmutable(root_dir())
    ->load();

\App\Lib\Model::setPDO(new PDO(
    dsn: sprintf(
        '%s:host=%s;dbname=%s;port=%s;charset=utf8',
        env('DB_TYPE', 'mysql'),
        env('DB_HOST', '127.0.0.1'),
        env('DB_NAME', 'todo'),
        env('DB_PORT', '3306'),
    ),
    username: env('DB_USERNAME', 'root'),
    password: env('DB_PASSWORD', 'root'),
    options: [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ]
));

try {
    $response = App\Lib\Router::handle(App\Lib\Route::getRoutes());

    if ($response instanceof \App\Lib\Response) {
        $response->handle();
    }

    if ($response instanceof \App\Lib\View) {
        $response->render();
        unset($_SESSION['flash']);
    }
} catch (Throwable $exception) {
    echo $exception->getMessage();
}
