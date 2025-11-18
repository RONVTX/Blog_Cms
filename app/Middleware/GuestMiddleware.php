<?php

class GuestMiddleware {
    public function handle() {
        if (Session::isLoggedIn()) {
            header('Location: /');
            exit;
        }
    }
}
