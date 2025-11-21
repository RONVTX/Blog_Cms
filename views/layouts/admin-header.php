<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle ?? 'Admin Panel'; ?> - <?php echo APP_NAME; ?></title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="stylesheet" href="/assets/css/admin.css">
</head>
<body class="admin-body">
    <div class="admin-layout">
        <aside class="admin-sidebar">
            <div class="admin-logo">
                <h2>⚡ Admin Panel</h2>
            </div>
            
            <nav class="admin-nav">
                <a href="/admin/dashboard" class="admin-nav-item <?php echo strpos($_SERVER['REQUEST_URI'], '/admin/dashboard') !== false || $_SERVER['REQUEST_URI'] === '/admin' ? 'active' : ''; ?>">
                    📊 Dashboard
                </a>
                <a href="/admin/users" class="admin-nav-item <?php echo strpos($_SERVER['REQUEST_URI'], '/admin/users') !== false ? 'active' : ''; ?>">
                    👥 Usuarios
                </a>
                <a href="/admin/posts" class="admin-nav-item <?php echo strpos($_SERVER['REQUEST_URI'], '/admin/posts') !== false ? 'active' : ''; ?>">
                    📝 Publicaciones
                </a>
                <a href="/admin/comments" class="admin-nav-item <?php echo strpos($_SERVER['REQUEST_URI'], '/admin/comments') !== false ? 'active' : ''; ?>">
                    💬 Comentarios
                </a>
                <a href="/admin/categories" class="admin-nav-item <?php echo strpos($_SERVER['REQUEST_URI'], '/admin/categories') !== false ? 'active' : ''; ?>">
                    📚 Categorías
                </a>
                <a href="/admin/reports" class="admin-nav-item <?php echo strpos($_SERVER['REQUEST_URI'], '/admin/reports') !== false ? 'active' : ''; ?>">
                    ⚠️ Reportes
                    <?php 
                    $adminModel = new Admin();
                    $stats = $adminModel->getDashboardStats();
                    if ($stats['pending_reports'] > 0): 
                    ?>
                        <span class="badge badge-danger"><?php echo $stats['pending_reports']; ?></span>
                    <?php endif; ?>
                </a>
                <a href="/admin/settings" class="admin-nav-item <?php echo strpos($_SERVER['REQUEST_URI'], '/admin/settings') !== false ? 'active' : ''; ?>">
                    ⚙️ Configuración
                </a>
                
                <div class="admin-nav-divider"></div>
                
                <a href="/" class="admin-nav-item">
                    🏠 Volver al sitio
                </a>
                <a href="/logout" class="admin-nav-item">
                    🚪 Cerrar sesión
                </a>
            </nav>
        </aside>
        
        <main class="admin-main">
            <div class="admin-topbar">
                <div class="admin-topbar-left">
                    <button class="admin-mobile-toggle" onclick="toggleSidebar()">☰</button>
                </div>
                <div class="admin-topbar-right">
                    <span class="admin-user">
                        Hola, <strong><?php echo htmlspecialchars(Session::getUsername()); ?></strong>
                    </span>
                </div>
            </div>
            
            <div class="admin-content">
                <?php if (Session::flash('success')): ?>
                    <div class="alert alert-success">✅ <?php echo Session::flash('success'); ?></div>
                <?php endif; ?>
                
                <?php if (Session::flash('error')): ?>
                    <div class="alert alert-error">❌ <?php echo Session::flash('error'); ?></div>
                <?php endif; ?>