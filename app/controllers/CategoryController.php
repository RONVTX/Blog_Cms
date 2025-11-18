<?php

class CategoryController extends BaseController {
    private $categoryModel;

    public function __construct() {
        $this->categoryModel = new Category();
    }

    public function show($slug) {
        $category = $this->categoryModel->findBySlug($slug);
        
        if (!$category) {
            http_response_code(404);
            require __DIR__ . '/../../views/errors/404.php';
            exit;
        }

        $posts = $this->categoryModel->getPostsByCategory($category['id']);
        
        $this->view('categories/show', [
            'category' => $category,
            'posts' => $posts
        ]);
    }
}