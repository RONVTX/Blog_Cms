<?php

class Tag {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getAll() {
        $sql = "SELECT t.*, COUNT(pt.post_id) as post_count 
                FROM tags t 
                LEFT JOIN post_tags pt ON t.id = pt.tag_id 
                GROUP BY t.id 
                ORDER BY post_count DESC, t.name ASC";
        return $this->db->query($sql)->fetchAll();
    }

    public function findOrCreate($name) {
        $slug = $this->generateSlug($name);
        
        // Buscar tag existente
        $sql = "SELECT * FROM tags WHERE slug = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$slug]);
        $tag = $stmt->fetch();
        
        if ($tag) {
            return $tag['id'];
        }
        
        // Crear nuevo tag
        $sql = "INSERT INTO tags (name, slug, created_at) VALUES (?, ?, NOW())";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$name, $slug]);
        return $this->db->lastInsertId();
    }

    public function attachToPost($postId, $tagNames) {
        // Eliminar tags existentes
        $sql = "DELETE FROM post_tags WHERE post_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$postId]);
        
        // Agregar nuevos tags
        if (!empty($tagNames)) {
            foreach ($tagNames as $tagName) {
                $tagName = trim($tagName);
                if (!empty($tagName)) {
                    $tagId = $this->findOrCreate($tagName);
                    $sql = "INSERT INTO post_tags (post_id, tag_id) VALUES (?, ?)";
                    $stmt = $this->db->prepare($sql);
                    $stmt->execute([$postId, $tagId]);
                }
            }
        }
    }

    public function getPostTags($postId) {
        $sql = "SELECT t.* FROM tags t 
                JOIN post_tags pt ON t.id = pt.tag_id 
                WHERE pt.post_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$postId]);
        return $stmt->fetchAll();
    }

    public function getPostsByTag($slug) {
        $sql = "SELECT p.*, u.username,
                (SELECT COUNT(*) FROM likes WHERE post_id = p.id) as likes_count,
                (SELECT COUNT(*) FROM comments WHERE post_id = p.id) as comments_count
                FROM posts p 
                JOIN users u ON p.user_id = u.id 
                JOIN post_tags pt ON p.id = pt.post_id
                JOIN tags t ON pt.tag_id = t.id
                WHERE t.slug = ? AND p.status = 'published'
                ORDER BY p.created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$slug]);
        return $stmt->fetchAll();
    }

    private function generateSlug($name) {
        $slug = strtolower(trim($name));
        $slug = preg_replace('/[^a-z0-9-]/', '-', $slug);
        $slug = preg_replace('/-+/', '-', $slug);
        return $slug;
    }
}