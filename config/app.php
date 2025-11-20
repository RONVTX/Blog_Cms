<?php

define('APP_NAME', 'Bloging');
define('APP_URL', 'http://localhost');
define('APP_ENV', 'development');

if (APP_ENV === 'development') {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}

date_default_timezone_set('Europe/Madrid');

define('UPLOAD_PATH', __DIR__ . '/../public/uploads/posts/');
define('MAX_FILE_SIZE', 5242880); // 5MB