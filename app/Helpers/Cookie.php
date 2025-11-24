<?php

class Cookie {
    // Set a cookie with options
    public static function set($name, $value, $days = 365, $path = '/', $secure = false, $httpOnly = false) {
        $expire = time() + ($days * 24 * 60 * 60);
        // Use setcookie with same-site Lax by default
        if (PHP_VERSION_ID >= 70300) {
            setcookie($name, $value, [
                'expires' => $expire,
                'path' => $path,
                'secure' => $secure,
                'httponly' => $httpOnly,
                'samesite' => 'Lax'
            ]);
        } else {
            setcookie($name, $value, $expire, $path, '', $secure, $httpOnly);
        }
        $_COOKIE[$name] = $value;
        return true;
    }

    public static function get($name, $default = null) {
        return isset($_COOKIE[$name]) ? $_COOKIE[$name] : $default;
    }

    public static function delete($name, $path = '/') {
        if (PHP_VERSION_ID >= 70300) {
            setcookie($name, '', [
                'expires' => time() - 3600,
                'path' => $path,
                'samesite' => 'Lax'
            ]);
        } else {
            setcookie($name, '', time() - 3600, $path);
        }
        unset($_COOKIE[$name]);
        return true;
    }
}
