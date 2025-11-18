<?php

class PostController extends BaseController {
    private $postModel;
    private $fileUploader;
    private $commentModel;
    private $likeModel;
    private $bookmarkModel;
    private $categoryModel;

    public function __construct() {
        $this->postModel = new Post();
        $this->fileUploader = new FileUploader();
        $this->commentModel = new Comment();
        $this->likeModel = new Like();
        $this->bookmarkModel = new Bookmark();
        $this->categoryModel = new Category();
    }

    public function create() {
        $categories = $this->categoryModel->getAll();
        $this->view('posts/create', ['categories' => $categories]);
    }

    public function store() {
        $title = $_POST['title'] ?? '';
        $content = $_POST['content'] ?? '';
        $categoryIds = $_POST['categories'] ?? [];

        $validator = new Validator();
        if (!$validator->validate($_POST, [
            'title' => 'required|min:5|max:200',
            'content' => 'required|min:50'
        ])) {
            $categories = $this->categoryModel->getAll();
            return $this->view('posts/create', [
                'error' => $validator->getFirstError(),
                'categories' => $categories
            ]);
        }

        $upload = $this->fileUploader->upload($_FILES['image'] ?? null);
        if (!$upload['success'] && $upload['path'] !== null) {
            $categories = $this->categoryModel->getAll();
            return $this->view('posts/create', [
                'error' => $upload['error'],
                'categories' => $categories
            ]);
        }

        $slug = $this->postModel->generateSlug($title);
        $postId = $this->postModel->create(Session::getUserId(), $title, $slug, $content, $upload['path']);
        
        if ($postId) {
            $this->categoryModel->attachToPost($postId, $categoryIds);
            $this->redirect('/blog/' . $slug);
        }

        $categories = $this->categoryModel->getAll();
        $this->view('posts/create', [
            'error' => 'Error al crear la publicación',
            'categories' => $categories
        ]);
    }

    public function show($slug) {
        $post = $this->postModel->findBySlug($slug);
        
        if (!$post) {
            http_response_code(404);
            require __DIR__ . '/../../views/errors/404.php';
            exit;
        }

        // Incrementar vistas
        $this->postModel->incrementViews($post['id']);

        // Obtener datos adicionales
        $comments = $this->commentModel->getByPost($post['id']);
        $categories = $this->categoryModel->getPostCategories($post['id']);
        
        $hasLiked = false;
        $hasBookmarked = false;
        
        if (Session::isLoggedIn()) {
            $hasLiked = $this->likeModel->hasLiked($post['id'], Session::getUserId());
            $hasBookmarked = $this->bookmarkModel->hasBookmarked($post['id'], Session::getUserId());
        }

        $this->view('posts/show', [
            'post' => $post,
            'comments' => $comments,
            'categories' => $categories,
            'hasLiked' => $hasLiked,
            'hasBookmarked' => $hasBookmarked
        ]);
    }

    public function edit($id) {
        $post = $this->postModel->findById($id);
        
        if (!$post || $post['user_id'] != Session::getUserId()) {
            $this->redirect('/');
        }

        $categories = $this->categoryModel->getAll();
        $postCategories = $this->categoryModel->getPostCategories($id);
        $selectedCategories = array_column($postCategories, 'id');

        $this->view('posts/edit', [
            'post' => $post,
            'categories' => $categories,
            'selectedCategories' => $selectedCategories
        ]);
    }

    public function update($id) {
        $post = $this->postModel->findById($id);
        
        if (!$post || $post['user_id'] != Session::getUserId()) {
            $this->redirect('/');
        }

        $title = $_POST['title'] ?? '';
        $content = $_POST['content'] ?? '';
        $categoryIds = $_POST['categories'] ?? [];

        $validator = new Validator();
        if (!$validator->validate($_POST, [
            'title' => 'required|min:5|max:200',
            'content' => 'required|min:50'
        ])) {
            $categories = $this->categoryModel->getAll();
            return $this->view('posts/edit', [
                'post' => $post,
                'categories' => $categories,
                'error' => $validator->getFirstError()
            ]);
        }

        $imagePath = $post['image'];
        
        if (isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
            $upload = $this->fileUploader->upload($_FILES['image']);
            
            if (!$upload['success']) {
                $categories = $this->categoryModel->getAll();
                return $this->view('posts/edit', [
                    'post' => $post,
                    'categories' => $categories,
                    'error' => $upload['error']
                ]);
            }
            
            if ($upload['path']) {
                $this->fileUploader->delete($post['image']);
                $imagePath = $upload['path'];
            }
        }

        $slug = $this->postModel->generateSlug($title);
        
        if ($this->postModel->update($id, $title, $slug, $content, $imagePath)) {
            $this->categoryModel->attachToPost($id, $categoryIds);
            $this->redirect('/blog/' . $slug);
        }

        $categories = $this->categoryModel->getAll();
        $this->view('posts/edit', [
            'post' => $post,
            'categories' => $categories,
            'error' => 'Error al actualizar'
        ]);
    }

    public function delete($id) {
        $post = $this->postModel->findById($id);
        
        if (!$post || $post['user_id'] != Session::getUserId()) {
            $this->redirect('/');
        }

        if ($post['image']) {
            $this->fileUploader->delete($post['image']);
        }

        $this->postModel->delete($id);
        $this->redirect('/');
    }
}
