<?php

class Setting {
    private $db;
    private static $cache = [];

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function get($key, $default = null) {
        if (isset(self::$cache[$key])) {
            return self::$cache[$key];
        }

        $sql = "SELECT setting_value, setting_type FROM site_settings WHERE setting_key = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$key]);
        $result = $stmt->fetch();

        if (!$result) {
            return $default;
        }

        $value = $this->castValue($result['setting_value'], $result['setting_type']);
        self::$cache[$key] = $value;
        
        return $value;
    }

    public function set($key, $value) {
        $sql = "UPDATE site_settings SET setting_value = ?, updated_at = NOW() WHERE setting_key = ?";
        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute([$value, $key]);
        
        if ($result) {
            self::$cache[$key] = $value;
        }
        
        return $result;
    }

    public function getByCategory($category) {
        $sql = "SELECT * FROM site_settings WHERE category = ? ORDER BY setting_key";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$category]);
        return $stmt->fetchAll();
    }

    public function getAllCategories() {
        $sql = "SELECT DISTINCT category FROM site_settings ORDER BY category";
        return $this->db->query($sql)->fetchAll(PDO::FETCH_COLUMN);
    }

    public function getAll() {
        $sql = "SELECT * FROM site_settings ORDER BY category, setting_key";
        return $this->db->query($sql)->fetchAll();
    }

    public function updateMultiple($settings) {
        $this->db->beginTransaction();
        
        try {
            foreach ($settings as $key => $value) {
                $this->set($key, $value);
            }
            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }

    private function castValue($value, $type) {
        switch ($type) {
            case 'boolean':
                return (bool)$value;
            case 'number':
                return is_numeric($value) ? (int)$value : $value;
            case 'json':
                return json_decode($value, true);
            default:
                return $value;
        }
    }

    public function clearCache() {
        self::$cache = [];
    }
}
