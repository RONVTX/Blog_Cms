<?php

class ProfileController extends BaseController {
    private $userModel;
    private $postModel;

    public function __construct() {
        $this->userModel = new User();
        $this->postModel = new Post();
    }

    public function show($username) {
        $user = $this->userModel->findByUsername($username);
        
        if (!$user) {
            http_response_code(404);
            require __DIR__ . '/../../views/errors/404.php';
            exit;
        }

        $posts = $this->postModel->getByUser($user['id']);
        $stats = $this->userModel->getStats($user['id']);
        
        $this->view('profile/show', [
            'user' => $user,
            'posts' => $posts,
            'stats' => $stats
        ]);
    }

    public function edit() {
        if (!Session::isLoggedIn()) {
            $this->redirect('/login');
        }

        $user = $this->userModel->findById(Session::getUserId());
        $this->view('profile/edit', ['user' => $user]);
    }

    public function update() {
        if (!Session::isLoggedIn()) {
            $this->redirect('/login');
        }

        $username = trim($_POST['username'] ?? '');
        $bio = trim($_POST['bio'] ?? '');

        $validator = new Validator();
        if (!$validator->validate($_POST, [
            'username' => 'required|min:3|max:50'
        ])) {
            $user = $this->userModel->findById(Session::getUserId());
            return $this->view('profile/edit', [
                'user' => $user,
                'error' => $validator->getFirstError()
            ]);
        }

        $avatarPath = null;
        if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] !== UPLOAD_ERR_NO_FILE) {
            $uploader = new FileUploader();
            $upload = $uploader->upload($_FILES['avatar']);
            
            if (!$upload['success']) {
                $user = $this->userModel->findById(Session::getUserId());
                return $this->view('profile/edit', [
                    'user' => $user,
                    'error' => $upload['error']
                ]);
            }
            $avatarPath = $upload['path'];
        }

        if ($this->userModel->updateProfile(Session::getUserId(), $username, $bio, $avatarPath)) {
            Session::set('username', $username);
            $this->redirect('/profile/' . $username);
        }

        $user = $this->userModel->findById(Session::getUserId());
        $this->view('profile/edit', [
            'user' => $user,
            'error' => 'Error al actualizar perfil'
        ]);
    }
}