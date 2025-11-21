<?php

class Admin {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getDashboardStats() {
        $stats = [];
        
        // Total usuarios
        $sql = "SELECT COUNT(*) FROM users";
        $stats['total_users'] = $this->db->query($sql)->fetchColumn();
        
        // Usuarios nuevos hoy
        $sql = "SELECT COUNT(*) FROM users WHERE DATE(created_at) = CURDATE()";
        $stats['new_users_today'] = $this->db->query($sql)->fetchColumn();
        
        // Total posts
        $sql = "SELECT COUNT(*) FROM posts";
        $stats['total_posts'] = $this->db->query($sql)->fetchColumn();
        
        // Posts publicados
        $sql = "SELECT COUNT(*) FROM posts WHERE status = 'published'";
        $stats['published_posts'] = $this->db->query($sql)->fetchColumn();
        
        // Posts borradores
        $sql = "SELECT COUNT(*) FROM posts WHERE status = 'draft'";
        $stats['draft_posts'] = $this->db->query($sql)->fetchColumn();
        
        // Total comentarios
        $sql = "SELECT COUNT(*) FROM comments";
        $stats['total_comments'] = $this->db->query($sql)->fetchColumn();
        
        // Comentarios pendientes
        $sql = "SELECT COUNT(*) FROM comments WHERE status = 'pending'";
        $stats['pending_comments'] = $this->db->query($sql)->fetchColumn();
        
        // Reportes pendientes
        $sql = "SELECT COUNT(*) FROM reports WHERE status = 'pending'";
        $stats['pending_reports'] = $this->db->query($sql)->fetchColumn();
        
        // Total vistas
        $sql = "SELECT SUM(views) FROM posts";
        $stats['total_views'] = $this->db->query($sql)->fetchColumn() ?: 0;
        
        return $stats;
    }

    public function getRecentActivity($limit = 10) {
        $sql = "SELECT * FROM activity_logs ORDER BY created_at DESC LIMIT ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$limit]);
        return $stmt->fetchAll();
    }

    public function getAllUsers($page = 1, $perPage = 20) {
        $offset = ($page - 1) * $perPage;
        $sql = "SELECT u.*, 
                (SELECT COUNT(*) FROM posts WHERE user_id = u.id) as post_count,
                (SELECT COUNT(*) FROM comments WHERE user_id = u.id) as comment_count
                FROM users u 
                ORDER BY u.created_at DESC 
                LIMIT ? OFFSET ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$perPage, $offset]);
        return $stmt->fetchAll();
    }

    public function updateUserRole($userId, $role) {
        $sql = "UPDATE users SET role = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$role, $userId]);
    }

    public function updateUserStatus($userId, $status) {
        $sql = "UPDATE users SET status = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$status, $userId]);
    }

    public function deleteUser($userId) {
        $sql = "DELETE FROM users WHERE id = ? AND role != 'admin'";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$userId]);
    }

    public function getAllPosts($page = 1, $perPage = 20, $status = null) {
        $offset = ($page - 1) * $perPage;
        
        $sql = "SELECT p.*, u.username,
                (SELECT COUNT(*) FROM likes WHERE post_id = p.id) as likes_count,
                (SELECT COUNT(*) FROM comments WHERE post_id = p.id) as comments_count
                FROM posts p 
                JOIN users u ON p.user_id = u.id";
        
        if ($status) {
            $sql .= " WHERE p.status = ?";
        }
        
        $sql .= " ORDER BY p.created_at DESC LIMIT ? OFFSET ?";
        
        $stmt = $this->db->prepare($sql);
        
        if ($status) {
            $stmt->execute([$status, $perPage, $offset]);
        } else {
            $stmt->execute([$perPage, $offset]);
        }
        
        return $stmt->fetchAll();
    }

    public function updatePostStatus($postId, $status) {
        $sql = "UPDATE posts SET status = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$status, $postId]);
    }

    public function toggleFeaturedPost($postId) {
        $sql = "UPDATE posts SET featured = NOT featured WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$postId]);
    }

    public function deletePost($postId) {
        $sql = "DELETE FROM posts WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$postId]);
    }

    public function getAllComments($page = 1, $perPage = 20, $status = null) {
        $offset = ($page - 1) * $perPage;
        
        $sql = "SELECT c.*, u.username, p.title as post_title, p.slug as post_slug
                FROM comments c 
                JOIN users u ON c.user_id = u.id 
                JOIN posts p ON c.post_id = p.id";
        
        if ($status) {
            $sql .= " WHERE c.status = ?";
        }
        
        $sql .= " ORDER BY c.created_at DESC LIMIT ? OFFSET ?";
        
        $stmt = $this->db->prepare($sql);
        
        if ($status) {
            $stmt->execute([$status, $perPage, $offset]);
        } else {
            $stmt->execute([$perPage, $offset]);
        }
        
        return $stmt->fetchAll();
    }

    public function updateCommentStatus($commentId, $status) {
        $sql = "UPDATE comments SET status = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$status, $commentId]);
    }

    public function deleteComment($commentId) {
        $sql = "DELETE FROM comments WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$commentId]);
    }

    public function getAllReports($page = 1, $perPage = 20) {
        $offset = ($page - 1) * $perPage;
        
        $sql = "SELECT r.*, u.username as reporter_username
                FROM reports r 
                JOIN users u ON r.reporter_id = u.id 
                ORDER BY r.created_at DESC 
                LIMIT ? OFFSET ?";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$perPage, $offset]);
        return $stmt->fetchAll();
    }

    public function updateReportStatus($reportId, $status, $adminNotes = null) {
        $sql = "UPDATE reports SET status = ?, admin_notes = ?, resolved_at = NOW() WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$status, $adminNotes, $reportId]);
    }

    public function getSettings() {
        $sql = "SELECT * FROM site_settings";
        $result = $this->db->query($sql)->fetchAll();
        
        $settings = [];
        foreach ($result as $row) {
            $settings[$row['setting_key']] = $row['setting_value'];
        }
        
        return $settings;
    }

    public function updateSetting($key, $value) {
        $sql = "UPDATE site_settings SET setting_value = ? WHERE setting_key = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$value, $key]);
    }

    public function logActivity($userId, $action, $description, $ipAddress, $userAgent) {
        $sql = "INSERT INTO activity_logs (user_id, action, description, ip_address, user_agent, created_at) 
                VALUES (?, ?, ?, ?, ?, NOW())";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$userId, $action, $description, $ipAddress, $userAgent]);
    }

    public function getPopularPosts($limit = 10) {
        $sql = "SELECT p.*, u.username,
                (SELECT COUNT(*) FROM likes WHERE post_id = p.id) as likes_count,
                (SELECT COUNT(*) FROM comments WHERE post_id = p.id) as comments_count
                FROM posts p 
                JOIN users u ON p.user_id = u.id 
                WHERE p.status = 'published'
                ORDER BY p.views DESC, likes_count DESC 
                LIMIT ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$limit]);
        return $stmt->fetchAll();
    }
}