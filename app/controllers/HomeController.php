<?php

class HomeController extends BaseController {
    public function index() {
        $postModel = new Post();
        $categoryModel = new Category();
        
        $posts = $postModel->getAll();
        $categories = $categoryModel->getAll();
        $trending = $postModel->getTrending();
        
        $this->view('home', [
            'posts' => $posts,
            'categories' => $categories,
            'trending' => $trending
        ]);
    }
}