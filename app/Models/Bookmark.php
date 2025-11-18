<?php

class Bookmark {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function toggle($postId, $userId) {
        if ($this->hasBookmarked($postId, $userId)) {
            return $this->remove($postId, $userId);
        }
        return $this->add($postId, $userId);
    }

    private function add($postId, $userId) {
        $sql = "INSERT INTO bookmarks (user_id, post_id, created_at) VALUES (?, ?, NOW())";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$userId, $postId]);
    }

    private function remove($postId, $userId) {
        $sql = "DELETE FROM bookmarks WHERE post_id = ? AND user_id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$postId, $userId]);
    }

    public function hasBookmarked($postId, $userId) {
        $sql = "SELECT COUNT(*) FROM bookmarks WHERE post_id = ? AND user_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$postId, $userId]);
        return $stmt->fetchColumn() > 0;
    }

    public function getByUser($userId) {
        $sql = "SELECT p.*, u.username,
                (SELECT COUNT(*) FROM likes WHERE post_id = p.id) as likes_count,
                (SELECT COUNT(*) FROM comments WHERE post_id = p.id) as comments_count
                FROM posts p 
                JOIN users u ON p.user_id = u.id 
                JOIN bookmarks b ON p.id = b.post_id
                WHERE b.user_id = ?
                ORDER BY b.created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }
}