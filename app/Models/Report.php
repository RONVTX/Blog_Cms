<?php

class Report {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function create($reporterId, $reportedType, $reportedId, $reason) {
        $sql = "INSERT INTO reports (reporter_id, reported_type, reported_id, reason, created_at) 
                VALUES (?, ?, ?, ?, NOW())";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$reporterId, $reportedType, $reportedId, $reason]);
    }

    public function hasReported($reporterId, $reportedType, $reportedId) {
        $sql = "SELECT COUNT(*) FROM reports 
                WHERE reporter_id = ? AND reported_type = ? AND reported_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$reporterId, $reportedType, $reportedId]);
        return $stmt->fetchColumn() > 0;
    }
}