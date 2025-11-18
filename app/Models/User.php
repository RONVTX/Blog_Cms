<?php

class User {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function create($username, $email, $password) {
        $sql = "INSERT INTO users (username, email, password, created_at) VALUES (?, ?, ?, NOW())";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$username, $email, password_hash($password, PASSWORD_DEFAULT)]);
    }

    public function findByEmail($email) {
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$email]);
        return $stmt->fetch();
    }

    public function findById($id) {
        $sql = "SELECT id, username, email, avatar, bio, created_at FROM users WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function findByUsername($username) {
        $sql = "SELECT id, username, email, avatar, bio, created_at FROM users WHERE username = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$username]);
        return $stmt->fetch();
    }

    public function emailExists($email) {
        return $this->findByEmail($email) !== false;
    }

    public function updateProfile($userId, $username, $bio, $avatar = null) {
        if ($avatar) {
            $sql = "UPDATE users SET username = ?, bio = ?, avatar = ? WHERE id = ?";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([$username, $bio, $avatar, $userId]);
        } else {
            $sql = "UPDATE users SET username = ?, bio = ? WHERE id = ?";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([$username, $bio, $userId]);
        }
    }

    public function getStats($userId) {
        $stats = [];
        
        // Total de posts
        $sql = "SELECT COUNT(*) FROM posts WHERE user_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$userId]);
        $stats['posts'] = $stmt->fetchColumn();
        
        // Total de likes recibidos
        $sql = "SELECT COUNT(*) FROM likes l JOIN posts p ON l.post_id = p.id WHERE p.user_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$userId]);
        $stats['likes'] = $stmt->fetchColumn();
        
        // Total de comentarios recibidos
        $sql = "SELECT COUNT(*) FROM comments c JOIN posts p ON c.post_id = p.id WHERE p.user_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$userId]);
        $stats['comments'] = $stmt->fetchColumn();
        
        return $stats;
    }
}