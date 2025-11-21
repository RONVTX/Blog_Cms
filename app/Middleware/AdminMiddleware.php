<?php

class AdminMiddleware {
    public function handle() {
        if (!Session::isLoggedIn()) {
            header('Location: /login');
            exit;
        }

        $userModel = new User();
        $user = $userModel->findById(Session::getUserId());
        
        if (!$user || ($user['role'] !== 'admin' && $user['role'] !== 'moderator')) {
            header('Location: /');
            exit;
        }
    }
}