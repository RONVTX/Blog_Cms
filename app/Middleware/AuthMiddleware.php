<?php

class AuthMiddleware {
    public function handle() {
        if (!Session::isLoggedIn()) {
            header('Location: /login');
            exit;
        }
    }
}
