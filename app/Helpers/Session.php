<?php

class Session {
    public static function set($key, $value) {
        $_SESSION[$key] = $value;
    }

    public static function get($key, $default = null) {
        return $_SESSION[$key] ?? $default;
    }

    public static function has($key) {
        return isset($_SESSION[$key]);
    }

    public static function delete($key) {
        unset($_SESSION[$key]);
    }

    public static function destroy() {
        session_destroy();
    }

    public static function isLoggedIn() {
        return self::has('user_id');
    }

    public static function getUserId() {
        return self::get('user_id');
    }

    public static function getUsername() {
        return self::get('username');
    }

    public static function flash($key, $value = null) {
        if ($value === null) {
            $val = self::get('flash_' . $key);
            self::delete('flash_' . $key);
            return $val;
        }
        self::set('flash_' . $key, $value);
    }
}