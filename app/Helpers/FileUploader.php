<?php

class FileUploader {
    private $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    private $maxSize = MAX_FILE_SIZE;

    public function upload($file) {
        if (!isset($file) || $file['error'] === UPLOAD_ERR_NO_FILE) {
            return ['success' => true, 'path' => null];
        }

        if ($file['error'] !== UPLOAD_ERR_OK) {
            return ['success' => false, 'error' => 'Error al subir el archivo'];
        }

        if (!in_array($file['type'], $this->allowedTypes)) {
            return ['success' => false, 'error' => 'Tipo de archivo no permitido'];
        }

        if ($file['size'] > $this->maxSize) {
            return ['success' => false, 'error' => 'El archivo es demasiado grande (máx. 5MB)'];
        }

        if (!is_dir(UPLOAD_PATH)) {
            mkdir(UPLOAD_PATH, 0755, true);
        }

        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = uniqid() . '_' . time() . '.' . $extension;
        $destination = UPLOAD_PATH . $filename;

        if (move_uploaded_file($file['tmp_name'], $destination)) {
            return ['success' => true, 'path' => 'uploads/posts/' . $filename];
        }

        return ['success' => false, 'error' => 'No se pudo guardar el archivo'];
    }

    public function delete($path) {
        if (empty($path)) return false;
        
        $fullPath = __DIR__ . '/../../public/' . $path;
        if (file_exists($fullPath)) {
            return unlink($fullPath);
        }
        return false;
    }
}