<?php

class BookmarkController extends BaseController {
    private $bookmarkModel;

    public function __construct() {
        $this->bookmarkModel = new Bookmark();
    }

    public function toggle($postId) {
        if (!Session::isLoggedIn()) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Debes iniciar sesión']);
            exit;
        }

        $this->bookmarkModel->toggle($postId, Session::getUserId());
        $hasBookmarked = $this->bookmarkModel->hasBookmarked($postId, Session::getUserId());
        
        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'has_bookmarked' => $hasBookmarked
        ]);
        exit;
    }

    public function index() {
        if (!Session::isLoggedIn()) {
            $this->redirect('/login');
        }

        $posts = $this->bookmarkModel->getByUser(Session::getUserId());
        $this->view('bookmarks/index', ['posts' => $posts]);
    }
}
