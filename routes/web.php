<?php

class Router {
    private static $routes = [];

    public static function get($uri, $controller, $method, $middleware = null) {
        self::$routes['GET'][$uri] = [
            'controller' => $controller,
            'method' => $method,
            'middleware' => $middleware
        ];
    }

    public static function post($uri, $controller, $method, $middleware = null) {
        self::$routes['POST'][$uri] = [
            'controller' => $controller,
            'method' => $method,
            'middleware' => $middleware
        ];
    }

    public static function dispatch($uri) {
        $method = $_SERVER['REQUEST_METHOD'];
        
        foreach (self::$routes[$method] ?? [] as $route => $action) {
            $pattern = preg_replace('/\{[a-zA-Z]+\}/', '([a-zA-Z0-9\-]+)', $route);
            $pattern = '#^' . $pattern . '$#';
            
            if (preg_match($pattern, $uri, $matches)) {
                array_shift($matches);
                
                if ($action['middleware']) {
                    $middleware = new $action['middleware']();
                    $middleware->handle();
                }
                
                $controller = new $action['controller']();
                return call_user_func_array([$controller, $action['method']], $matches);
            }
        }
        
        http_response_code(404);
        require __DIR__ . '/../views/errors/404.php';
    }
}

// Rutas públicas
Router::get('/', 'HomeController', 'index');
Router::get('/login', 'AuthController', 'showLogin', 'GuestMiddleware');
Router::post('/login', 'AuthController', 'login', 'GuestMiddleware');
Router::get('/register', 'AuthController', 'showRegister', 'GuestMiddleware');
Router::post('/register', 'AuthController', 'register', 'GuestMiddleware');
Router::get('/blog/{slug}', 'PostController', 'show');
Router::get('/category/{slug}', 'CategoryController', 'show');
Router::get('/tag/{slug}', 'TagController', 'show');
Router::get('/search', 'SearchController', 'index');
// Cookies preferences
Router::get('/cookies', 'CookieController', 'show');
Router::post('/cookies', 'CookieController', 'update');

// Rutas protegidas
Router::get('/logout', 'AuthController', 'logout', 'AuthMiddleware');
Router::get('/post/create', 'PostController', 'create', 'AuthMiddleware');
Router::post('/post/create', 'PostController', 'store', 'AuthMiddleware');
Router::get('/post/edit/{id}', 'PostController', 'edit', 'AuthMiddleware');
Router::post('/post/edit/{id}', 'PostController', 'update', 'AuthMiddleware');
Router::post('/post/delete/{id}', 'PostController', 'delete', 'AuthMiddleware');

// Comentarios
Router::post('/comment/{postId}', 'CommentController', 'store', 'AuthMiddleware');
Router::post('/comment/delete/{id}', 'CommentController', 'delete', 'AuthMiddleware');

// Likes
Router::post('/like/{postId}', 'LikeController', 'toggle', 'AuthMiddleware');

// Marcadores
Router::post('/bookmark/{postId}', 'BookmarkController', 'toggle', 'AuthMiddleware');
Router::get('/bookmarks', 'BookmarkController', 'index', 'AuthMiddleware');

// Perfil - Rutas específicas ANTES de rutas parametrizadas
Router::get('/profile/edit', 'ProfileController', 'edit', 'AuthMiddleware');
Router::post('/profile/update', 'ProfileController', 'update', 'AuthMiddleware');
Router::get('/profile/{username}', 'ProfileController', 'show');

// Seguidores
Router::post('/follow/{userId}', 'FollowerController', 'toggle', 'AuthMiddleware');
Router::get('/profile/{username}/followers', 'FollowerController', 'followers');
Router::get('/profile/{username}/following', 'FollowerController', 'following');

// Notificaciones
Router::get('/notifications', 'NotificationController', 'index', 'AuthMiddleware');
Router::post('/notifications/{id}/read', 'NotificationController', 'markAsRead', 'AuthMiddleware');
Router::post('/notifications/read-all', 'NotificationController', 'markAllAsRead', 'AuthMiddleware');
Router::get('/notifications/unread-count', 'NotificationController', 'getUnreadCount', 'AuthMiddleware');

// Reportes
Router::post('/report', 'ReportController', 'store', 'AuthMiddleware');

// PANEL DE ADMINISTRACIÓN
Router::get('/admin', 'AdminController', 'dashboard', 'AdminMiddleware');
Router::get('/admin/dashboard', 'AdminController', 'dashboard', 'AdminMiddleware');

// Admin - Usuarios
Router::get('/admin/users', 'AdminController', 'users', 'AdminMiddleware');
Router::post('/admin/users/role', 'AdminController', 'updateUserRole', 'AdminMiddleware');
Router::post('/admin/users/status', 'AdminController', 'updateUserStatus', 'AdminMiddleware');
Router::post('/admin/users/delete', 'AdminController', 'deleteUser', 'AdminMiddleware');

// Admin - Posts
Router::get('/admin/posts', 'AdminController', 'posts', 'AdminMiddleware');
Router::post('/admin/posts/status', 'AdminController', 'updatePostStatus', 'AdminMiddleware');
Router::post('/admin/posts/featured', 'AdminController', 'toggleFeatured', 'AdminMiddleware');
Router::post('/admin/posts/delete', 'AdminController', 'deletePost', 'AdminMiddleware');

// Admin - Comentarios
Router::get('/admin/comments', 'AdminController', 'comments', 'AdminMiddleware');
Router::post('/admin/comments/status', 'AdminController', 'updateCommentStatus', 'AdminMiddleware');
Router::post('/admin/comments/delete', 'AdminController', 'deleteComment', 'AdminMiddleware');

// Admin - Reportes
Router::get('/admin/reports', 'AdminController', 'reports', 'AdminMiddleware');
Router::post('/admin/reports/status', 'AdminController', 'updateReportStatus', 'AdminMiddleware');

// Admin - Categorías
Router::get('/admin/categories', 'AdminController', 'categories', 'AdminMiddleware');
Router::get('/admin/categories/create', 'AdminController', 'createCategory', 'AdminMiddleware');
Router::post('/admin/categories/store', 'AdminController', 'storeCategory', 'AdminMiddleware');

// Admin - Configuración
Router::get('/admin/settings', 'AdminController', 'settings', 'AdminMiddleware');
Router::post('/admin/settings/update', 'AdminController', 'updateSettings', 'AdminMiddleware');