<?php

class SearchController extends BaseController {
    private $postModel;

    public function __construct() {
        $this->postModel = new Post();
    }

    public function index() {
        $query = $_GET['q'] ?? '';
        $posts = [];
        
        if (!empty($query)) {
            $posts = $this->postModel->getAll(null, null, $query);
        }
        
        $this->view('search/index', [
            'query' => $query,
            'posts' => $posts
        ]);
    }
}