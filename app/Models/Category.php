<?php

class Category {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getAll() {
        $sql = "SELECT c.*, COUNT(pc.post_id) as post_count 
                FROM categories c 
                LEFT JOIN post_categories pc ON c.id = pc.category_id 
                GROUP BY c.id 
                ORDER BY post_count DESC, c.name ASC";
        return $this->db->query($sql)->fetchAll();
    }

    public function findBySlug($slug) {
        $sql = "SELECT * FROM categories WHERE slug = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$slug]);
        return $stmt->fetch();
    }

    public function getPostsByCategory($categoryId) {
        $sql = "SELECT p.*, u.username, u.avatar,
                (SELECT COUNT(*) FROM likes WHERE post_id = p.id) as likes_count,
                (SELECT COUNT(*) FROM comments WHERE post_id = p.id) as comments_count
                FROM posts p 
                JOIN users u ON p.user_id = u.id 
                JOIN post_categories pc ON p.id = pc.post_id
                WHERE pc.category_id = ? AND p.status = 'published'
                ORDER BY p.created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$categoryId]);
        return $stmt->fetchAll();
    }

    public function create($name, $description, $icon, $color) {
        $slug = $this->generateSlug($name);
        
        $sql = "INSERT INTO categories (name, slug, description, icon, color, created_at) 
                VALUES (?, ?, ?, ?, ?, NOW())";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$name, $slug, $description, $icon, $color]);
    }

    public function attachToPost($postId, $categoryIds) {
        // Primero eliminar categorías existentes
        $sql = "DELETE FROM post_categories WHERE post_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$postId]);

        // Insertar nuevas categorías
        if (!empty($categoryIds)) {
            $sql = "INSERT INTO post_categories (post_id, category_id) VALUES (?, ?)";
            $stmt = $this->db->prepare($sql);
            foreach ($categoryIds as $categoryId) {
                $stmt->execute([$postId, $categoryId]);
            }
        }
        return true;
    }

    public function getPostCategories($postId) {
        $sql = "SELECT c.* FROM categories c 
                JOIN post_categories pc ON c.id = pc.category_id 
                WHERE pc.post_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$postId]);
        return $stmt->fetchAll();
    }

    private function generateSlug($name) {
        $slug = strtolower(trim($name));
        $slug = preg_replace('/[^a-z0-9-]/', '-', $slug);
        $slug = preg_replace('/-+/', '-', $slug);
        return $slug;
    }
}