<?php

class AuthController extends BaseController {
    private $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    public function showLogin() {
        $this->view('auth/login');
    }

    public function login() {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        $user = $this->userModel->findByEmail($email);

        if ($user && password_verify($password, $user['password'])) {
            Session::set('user_id', $user['id']);
            Session::set('username', $user['username']);
            $this->redirect('/');
        }

        $this->view('auth/login', ['error' => 'Credenciales incorrectas']);
    }

    public function showRegister() {
        $this->view('auth/register');
    }

    public function register() {
        $username = $_POST['username'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        $validator = new Validator();
        if (!$validator->validate($_POST, [
            'username' => 'required|min:3|max:50',
            'email' => 'required|email',
            'password' => 'required|min:8'
        ])) {
            return $this->view('auth/register', ['error' => $validator->getFirstError()]);
        }

        if ($this->userModel->emailExists($email)) {
            return $this->view('auth/register', ['error' => 'El email ya está registrado']);
        }

        if ($this->userModel->create($username, $email, $password)) {
            $this->redirect('/login');
        }

        $this->view('auth/register', ['error' => 'Error al registrar usuario']);
    }

    public function logout() {
        Session::destroy();
        $this->redirect('/');
    }
}