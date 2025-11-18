<?php

class Like {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function toggle($postId, $userId) {
        if ($this->hasLiked($postId, $userId)) {
            return $this->unlike($postId, $userId);
        }
        return $this->like($postId, $userId);
    }

    private function like($postId, $userId) {
        $sql = "INSERT INTO likes (post_id, user_id, created_at) VALUES (?, ?, NOW())";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$postId, $userId]);
    }

    private function unlike($postId, $userId) {
        $sql = "DELETE FROM likes WHERE post_id = ? AND user_id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$postId, $userId]);
    }

    public function hasLiked($postId, $userId) {
        $sql = "SELECT COUNT(*) FROM likes WHERE post_id = ? AND user_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$postId, $userId]);
        return $stmt->fetchColumn() > 0;
    }

    public function getCount($postId) {
        $sql = "SELECT COUNT(*) FROM likes WHERE post_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$postId]);
        return $stmt->fetchColumn();
    }

    public function getLikedPosts($userId) {
        $sql = "SELECT p.*, u.username, 
                (SELECT COUNT(*) FROM likes WHERE post_id = p.id) as likes_count,
                (SELECT COUNT(*) FROM comments WHERE post_id = p.id) as comments_count
                FROM posts p 
                JOIN users u ON p.user_id = u.id 
                JOIN likes l ON p.id = l.post_id
                WHERE l.user_id = ?
                ORDER BY l.created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }
}