<?php
session_start();

// Autoloader
spl_autoload_register(function ($class) {
    $paths = [
        __DIR__ . '/../app/Controllers/',
        __DIR__ . '/../app/Models/',
        __DIR__ . '/../app/Helpers/',
        __DIR__ . '/../app/Middleware/',
    ];
    
    foreach ($paths as $path) {
        $file = $path . $class . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

// Archivos base del sistema
require_once __DIR__ . '/../config/app.php';
require_once __DIR__ . '/../routes/web.php';

// Obtener URL limpia
$url = $_SERVER['REQUEST_URI'];
$url = parse_url($url, PHP_URL_PATH);
$url = rtrim($url, '/');
$url = $url ?: '/';

// Despachar la ruta
Router::dispatch($url);
