<?php

class SettingsController extends BaseController {
    private $settingModel;

    public function __construct() {
        $this->settingModel = new Setting();
    }

    public function index() {
        if (!$this->isAdmin()) {
            $this->redirect('/');
        }

        $categories = $this->settingModel->getAllCategories();
        $currentCategory = $_GET['category'] ?? 'general';
        $settings = $this->settingModel->getByCategory($currentCategory);

        $this->view('admin/settings/index', [
            'categories' => $categories,
            'currentCategory' => $currentCategory,
            'settings' => $settings
        ]);
    }

    public function update() {
        if (!$this->isAdmin()) {
            $this->redirect('/');
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/admin/settings');
        }

        $settings = $_POST;
        unset($settings['csrf_token']); // Si implementas CSRF

        if ($this->settingModel->updateMultiple($settings)) {
            Session::flash('success', 'Configuración actualizada correctamente');
        } else {
            Session::flash('error', 'Error al actualizar la configuración');
        }

        $category = $_POST['category'] ?? 'general';
        $this->redirect('/admin/settings?category=' . $category);
    }

    private function isAdmin() {
        if (!Session::isLoggedIn()) {
            return false;
        }
        
        $userModel = new User();
        $user = $userModel->findById(Session::getUserId());
        return $user && $user['role'] === 'admin';
    }
}