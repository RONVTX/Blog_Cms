<?php

// Configuración básica de la aplicación
// Ajusta estas constantes según tu entorno y despliegue.
define('APP_NAME', 'Bloging');
define('APP_URL', 'http://localhost');

// Entorno de ejecución: 'development' o 'production'
// En 'development' se muestran errores para depuración.
define('APP_ENV', 'development');

if (APP_ENV === 'development') {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}

// Zona horaria por defecto de la aplicación
date_default_timezone_set('Europe/Madrid');

// Rutas para subir archivos y límite por fichero
define('UPLOAD_PATH', __DIR__ . '/../public/uploads/posts/');
define('MAX_FILE_SIZE', 5242880); // 5MB