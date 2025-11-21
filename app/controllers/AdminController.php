<?php

class AdminController extends BaseController {
    private $adminModel;

    public function __construct() {
        $this->adminModel = new Admin();
        $this->logActivity('admin_access', 'Accedió al panel de administración');
    }

    public function dashboard() {
        $stats = $this->adminModel->getDashboardStats();
        $recentActivity = $this->adminModel->getRecentActivity(15);
        $popularPosts = $this->adminModel->getPopularPosts(5);
        
        $this->view('admin/dashboard', [
            'stats' => $stats,
            'recentActivity' => $recentActivity,
            'popularPosts' => $popularPosts
        ]);
    }

    public function users() {
        $page = $_GET['page'] ?? 1;
        $users = $this->adminModel->getAllUsers($page, 20);
        
        $this->view('admin/users', ['users' => $users, 'currentPage' => $page]);
    }

    public function updateUserRole() {
        $userId = $_POST['user_id'] ?? 0;
        $role = $_POST['role'] ?? '';
        
        if ($this->adminModel->updateUserRole($userId, $role)) {
            $this->logActivity('user_role_updated', "Rol de usuario #{$userId} actualizado a {$role}");
            Session::flash('success', 'Rol actualizado correctamente');
        } else {
            Session::flash('error', 'Error al actualizar el rol');
        }
        
        $this->redirect('/admin/users');
    }

    public function updateUserStatus() {
        $userId = $_POST['user_id'] ?? 0;
        $status = $_POST['status'] ?? '';
        
        if ($this->adminModel->updateUserStatus($userId, $status)) {
            $this->logActivity('user_status_updated', "Estado de usuario #{$userId} actualizado a {$status}");
            Session::flash('success', 'Estado actualizado correctamente');
        } else {
            Session::flash('error', 'Error al actualizar el estado');
        }
        
        $this->redirect('/admin/users');
    }

    public function deleteUser() {
        $userId = $_POST['user_id'] ?? 0;
        
        if ($userId == Session::getUserId()) {
            Session::flash('error', 'No puedes eliminar tu propia cuenta');
            $this->redirect('/admin/users');
        }
        
        if ($this->adminModel->deleteUser($userId)) {
            $this->logActivity('user_deleted', "Usuario #{$userId} eliminado");
            Session::flash('success', 'Usuario eliminado correctamente');
        } else {
            Session::flash('error', 'Error al eliminar el usuario');
        }
        
        $this->redirect('/admin/users');
    }

    public function posts() {
        $page = $_GET['page'] ?? 1;
        $status = $_GET['status'] ?? null;
        $posts = $this->adminModel->getAllPosts($page, 20, $status);
        
        $this->view('admin/posts', [
            'posts' => $posts,
            'currentPage' => $page,
            'currentStatus' => $status
        ]);
    }

    public function updatePostStatus() {
        $postId = $_POST['post_id'] ?? 0;
        $status = $_POST['status'] ?? '';
        
        if ($this->adminModel->updatePostStatus($postId, $status)) {
            $this->logActivity('post_status_updated', "Estado del post #{$postId} actualizado a {$status}");
            Session::flash('success', 'Estado actualizado correctamente');
        } else {
            Session::flash('error', 'Error al actualizar el estado');
        }
        
        $this->back();
    }

    public function toggleFeatured() {
        $postId = $_POST['post_id'] ?? 0;
        
        if ($this->adminModel->toggleFeaturedPost($postId)) {
            $this->logActivity('post_featured_toggled', "Post #{$postId} destacado cambiado");
            Session::flash('success', 'Post destacado actualizado');
        } else {
            Session::flash('error', 'Error al actualizar');
        }
        
        $this->back();
    }

    public function deletePost() {
        $postId = $_POST['post_id'] ?? 0;
        
        if ($this->adminModel->deletePost($postId)) {
            $this->logActivity('post_deleted', "Post #{$postId} eliminado");
            Session::flash('success', 'Post eliminado correctamente');
        } else {
            Session::flash('error', 'Error al eliminar el post');
        }
        
        $this->redirect('/admin/posts');
    }

    public function comments() {
        $page = $_GET['page'] ?? 1;
        $status = $_GET['status'] ?? null;
        $comments = $this->adminModel->getAllComments($page, 20, $status);
        
        $this->view('admin/comments', [
            'comments' => $comments,
            'currentPage' => $page,
            'currentStatus' => $status
        ]);
    }

    public function updateCommentStatus() {
        $commentId = $_POST['comment_id'] ?? 0;
        $status = $_POST['status'] ?? '';
        
        if ($this->adminModel->updateCommentStatus($commentId, $status)) {
            $this->logActivity('comment_status_updated', "Comentario #{$commentId} actualizado a {$status}");
            Session::flash('success', 'Comentario actualizado');
        } else {
            Session::flash('error', 'Error al actualizar');
        }
        
        $this->back();
    }

    public function deleteComment() {
        $commentId = $_POST['comment_id'] ?? 0;
        
        if ($this->adminModel->deleteComment($commentId)) {
            $this->logActivity('comment_deleted', "Comentario #{$commentId} eliminado");
            Session::flash('success', 'Comentario eliminado');
        } else {
            Session::flash('error', 'Error al eliminar');
        }
        
        $this->back();
    }

    public function reports() {
        $page = $_GET['page'] ?? 1;
        $reports = $this->adminModel->getAllReports($page, 20);
        
        $this->view('admin/reports', ['reports' => $reports, 'currentPage' => $page]);
    }

    public function updateReportStatus() {
        $reportId = $_POST['report_id'] ?? 0;
        $status = $_POST['status'] ?? '';
        $adminNotes = $_POST['admin_notes'] ?? '';
        
        if ($this->adminModel->updateReportStatus($reportId, $status, $adminNotes)) {
            $this->logActivity('report_updated', "Reporte #{$reportId} actualizado a {$status}");
            Session::flash('success', 'Reporte actualizado');
        } else {
            Session::flash('error', 'Error al actualizar');
        }
        
        $this->redirect('/admin/reports');
    }

    public function settings() {
        $settings = $this->adminModel->getSettings();
        $this->view('admin/settings', ['settings' => $settings]);
    }

    public function updateSettings() {
        $settings = $_POST['settings'] ?? [];
        
        foreach ($settings as $key => $value) {
            $this->adminModel->updateSetting($key, $value);
        }
        
        $this->logActivity('settings_updated', 'Configuración del sitio actualizada');
        Session::flash('success', 'Configuración actualizada correctamente');
        $this->redirect('/admin/settings');
    }

    public function categories() {
        $categoryModel = new Category();
        $categories = $categoryModel->getAll();
        
        $this->view('admin/categories', ['categories' => $categories]);
    }

    public function createCategory() {
        // Vista para crear categoría
        $this->view('admin/category-form', ['category' => null]);
    }

    public function storeCategory() {
        $name = $_POST['name'] ?? '';
        $description = $_POST['description'] ?? '';
        $icon = $_POST['icon'] ?? '';
        $color = $_POST['color'] ?? '#6366f1';
        
        $categoryModel = new Category();
        if ($categoryModel->create($name, $description, $icon, $color)) {
            $this->logActivity('category_created', "Categoría '{$name}' creada");
            Session::flash('success', 'Categoría creada correctamente');
            $this->redirect('/admin/categories');
        } else {
            Session::flash('error', 'Error al crear la categoría');
            $this->back();
        }
    }

    private function logActivity($action, $description) {
        $this->adminModel->logActivity(
            Session::getUserId(),
            $action,
            $description,
            $_SERVER['REMOTE_ADDR'] ?? '',
            $_SERVER['HTTP_USER_AGENT'] ?? ''
        );
    }
}