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

Router::get('/search', 'SearchController', 'index');

// Rutas protegidas
Router::get('/logout', 'AuthController', 'logout', 'AuthMiddleware');
Router::get('/post/create', 'PostController', 'create', 'AuthMiddleware');
Router::post('/post/create', 'PostController', 'store', 'AuthMiddleware');
Router::get('/post/edit/{id}', 'PostController', 'edit', 'AuthMiddleware');
Router::post('/post/edit/{id}', 'PostController', 'update', 'AuthMiddleware');
Router::post('/post/delete/{id}', 'PostController', 'delete', 'AuthMiddleware');

// Rutas de comentarios
Router::post('/comment/{postId}', 'CommentController', 'store', 'AuthMiddleware');
Router::post('/comment/delete/{id}', 'CommentController', 'delete', 'AuthMiddleware');

// Rutas de likes
Router::post('/like/{postId}', 'LikeController', 'toggle', 'AuthMiddleware');

// Rutas de marcadores
Router::post('/bookmark/{postId}', 'BookmarkController', 'toggle', 'AuthMiddleware');
Router::get('/bookmarks', 'BookmarkController', 'index', 'AuthMiddleware');

// Rutas de perfil
// Colocar rutas estáticas antes de la ruta dinámica para evitar colisiones
Router::get('/profile/edit', 'ProfileController', 'edit', 'AuthMiddleware');
Router::post('/profile/update', 'ProfileController', 'update', 'AuthMiddleware');
// Ruta dinámica para mostrar perfil por nombre de usuario (debe quedar al final)
Router::get('/profile/{username}', 'ProfileController', 'show');