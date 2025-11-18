<?php

class Follow {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function toggle($followerId, $followingId) {
        if ($this->isFollowing($followerId, $followingId)) {
            $this->unfollow($followerId, $followingId);
            return false;
        } else {
            $this->follow($followerId, $followingId);
            return true;
        }
    }

    private function follow($followerId, $followingId) {
        $sql = "INSERT INTO followers (follower_id, following_id, created_at) VALUES (?, ?, NOW())";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$followerId, $followingId]);
    }

    private function unfollow($followerId, $followingId) {
        $sql = "DELETE FROM followers WHERE follower_id = ? AND following_id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$followerId, $followingId]);
    }

    public function isFollowing($followerId, $followingId) {
        $sql = "SELECT COUNT(*) FROM followers WHERE follower_id = ? AND following_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$followerId, $followingId]);
        return $stmt->fetchColumn() > 0;
    }

    public function getFollowersCount($userId) {
        $sql = "SELECT COUNT(*) FROM followers WHERE following_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetchColumn();
    }

    public function getFollowingCount($userId) {
        $sql = "SELECT COUNT(*) FROM followers WHERE follower_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetchColumn();
    }

    public function getFollowers($userId) {
        $sql = "SELECT u.* FROM users u
                JOIN followers f ON u.id = f.follower_id
                WHERE f.following_id = ?
                ORDER BY f.created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }

    public function getFollowing($userId) {
        $sql = "SELECT u.* FROM users u
                JOIN followers f ON u.id = f.following_id
                WHERE f.follower_id = ?
                ORDER BY f.created_at DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }
}