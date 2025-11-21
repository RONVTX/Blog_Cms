<?php

class TagController extends BaseController {
    private $tagModel;

    public function __construct() {
        $this->tagModel = new Tag();
    }

    public function show($slug) {
        $posts = $this->tagModel->getPostsByTag($slug);
        
        $this->view('tags/show', [
            'tag' => $slug,
            'posts' => $posts
        ]);
    }
}