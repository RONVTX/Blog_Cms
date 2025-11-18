<?php

class CommentController extends BaseController {
    private $commentModel;

    public function __construct() {
        $this->commentModel = new Comment();
    }

    public function store($postId) {
        if (!Session::isLoggedIn()) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Debes iniciar sesión']);
            exit;
        }

        $content = trim($_POST['content'] ?? '');
        
        if (empty($content)) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'El comentario no puede estar vacío']);
            exit;
        }

        if ($this->commentModel->create($postId, Session::getUserId(), $content)) {
            header('Content-Type: application/json');
            echo json_encode(['success' => true, 'message' => 'Comentario agregado']);
        } else {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Error al agregar comentario']);
        }
        exit;
    }

    public function delete($id) {
        if (!Session::isLoggedIn()) {
            $this->redirect('/login');
        }

        if ($this->commentModel->delete($id, Session::getUserId())) {
            $this->back();
        }
    }
}
