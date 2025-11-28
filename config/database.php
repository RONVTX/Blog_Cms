<?php

// Archivo de configuración de la base de datos.
// Para entornos de producción se recomienda cargar estas opciones desde
// variables de entorno (.env) y no versionarlas en el repositorio.

return [
    'host' => 'localhost',
    'dbname' => 'blog_cms',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8mb4',
    'options' => [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]
];