<?php

class LikeController extends BaseController {
    private $likeModel;

    public function __construct() {
        $this->likeModel = new Like();
    }

    public function toggle($postId) {
        if (!Session::isLoggedIn()) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Debes iniciar sesión']);
            exit;
        }

        $this->likeModel->toggle($postId, Session::getUserId());
        
        $likesCount = $this->likeModel->getCount($postId);
        $hasLiked = $this->likeModel->hasLiked($postId, Session::getUserId());
        
        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'likes_count' => $likesCount,
            'has_liked' => $hasLiked
        ]);
        exit;
    }
}