<?php

class BaseController {
    protected function view($view, $data = []) {
        extract($data);
        require __DIR__ . '/../../views/' . $view . '.php';
    }

    protected function redirect($url) {
        header("Location: $url");
        exit;
    }

    protected function back() {
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit;
    }
}