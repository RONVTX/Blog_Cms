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
                <h2><svg class="icon icon-header" aria-hidden="true"><use href="/assets/icons.svg#home"></use></svg> Admin Panel</h2>
            </div>
            
            <nav class="admin-nav">
                <a href="/admin/dashboard" class="admin-nav-item <?php echo strpos($_SERVER['REQUEST_URI'], '/admin/dashboard') !== false || $_SERVER['REQUEST_URI'] === '/admin' ? 'active' : ''; ?>">
                    <svg class="icon icon-text" aria-hidden="true"><use href="/assets/icons.svg#home"></use></svg> Dashboard
                </a>
                <a href="/admin/users" class="admin-nav-item <?php echo strpos($_SERVER['REQUEST_URI'], '/admin/users') !== false ? 'active' : ''; ?>">
                    <svg class="icon icon-text" aria-hidden="true"><use href="/assets/icons.svg#users"></use></svg> Usuarios
                </a>
                <a href="/admin/posts" class="admin-nav-item <?php echo strpos($_SERVER['REQUEST_URI'], '/admin/posts') !== false ? 'active' : ''; ?>">
                    <svg class="icon icon-text" aria-hidden="true"><use href="/assets/icons.svg#newspaper"></use></svg> Publicaciones
                </a>
                <a href="/admin/comments" class="admin-nav-item <?php echo strpos($_SERVER['REQUEST_URI'], '/admin/comments') !== false ? 'active' : ''; ?>">
                    <svg class="icon icon-text" aria-hidden="true"><use href="/assets/icons.svg#comments"></use></svg> Comentarios
                </a>
                <a href="/admin/categories" class="admin-nav-item <?php echo strpos($_SERVER['REQUEST_URI'], '/admin/categories') !== false ? 'active' : ''; ?>">
                    <svg class="icon icon-text" aria-hidden="true"><use href="/assets/icons.svg#folder"></use></svg> Categorías
                </a>
                <a href="/admin/reports" class="admin-nav-item <?php echo strpos($_SERVER['REQUEST_URI'], '/admin/reports') !== false ? 'active' : ''; ?>">
                    <svg class="icon icon-text" aria-hidden="true"><use href="/assets/icons.svg#flag"></use></svg> Reportes
                    <?php 
                    $adminModel = new Admin();
                    $stats = $adminModel->getDashboardStats();
                    if ($stats['pending_reports'] > 0): 
                    ?>
                        <span class="badge badge-danger"><?php echo $stats['pending_reports']; ?></span>
                    <?php endif; ?>
                </a>
                <a href="/admin/settings" class="admin-nav-item <?php echo strpos($_SERVER['REQUEST_URI'], '/admin/settings') !== false ? 'active' : ''; ?>">
                    <svg class="icon icon-text" aria-hidden="true"><use href="/assets/icons.svg#cog"></use></svg> Configuración
                </a>
                
                <div class="admin-nav-divider"></div>
                
                <a href="/" class="admin-nav-item">
                    <svg class="icon icon-text" aria-hidden="true"><use href="/assets/icons.svg#home"></use></svg> Volver al sitio
                </a>
                <a href="/logout" class="admin-nav-item">
                    <svg class="icon icon-text" aria-hidden="true"><use href="/assets/icons.svg#sign-out"></use></svg> Cerrar sesión
                </a>
            </nav>
        </aside>
        
        <main class="admin-main">
            <div class="admin-topbar">
                <div class="admin-topbar-left">
                    <button class="admin-mobile-toggle" onclick="toggleSidebar()"><svg class="icon icon-text" aria-hidden="true"><use href="/assets/icons.svg#menu"></use></svg><span class="sr-only">Abrir menú</span></button>
                </div>
                <div class="admin-topbar-right">
                    <?php if (Session::isLoggedIn()):
                        $userModel = new User();
                        $currentUser = $userModel->findById(Session::getUserId());
                    ?>
                        <a href="/profile/<?php echo htmlspecialchars(Session::getUsername()); ?>" class="admin-user user-info" style="display:flex;align-items:center;gap:0.75rem;text-decoration:none;color:inherit;">
                            <?php if ($currentUser && isset($currentUser['avatar']) && $currentUser['avatar']): ?>
                                <img src="/<?php echo htmlspecialchars($currentUser['avatar']); ?>" alt="Avatar" class="user-avatar" style="width:44px;height:44px;border-radius:50%;object-fit:cover;">
                            <?php else: ?>
                                <span class="user-avatar" style="width:44px;height:44px;border-radius:50%;background:var(--gradient);display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;">
                                    <?php echo strtoupper(substr(Session::getUsername(), 0, 1)); ?>
                                </span>
                            <?php endif; ?>
                            <span>Hola, <strong><?php echo htmlspecialchars(Session::getUsername()); ?></strong></span>
                        </a>
                    <?php else: ?>
                        <span class="admin-user">Hola, <strong><?php echo htmlspecialchars(Session::getUsername() ?? 'Invitado'); ?></strong></span>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="admin-content">
                <?php if (Session::flash('success')): ?>
                    <div class="alert alert-success"><svg class="icon icon-text" aria-hidden="true"><use href="/assets/icons.svg#check-circle"></use></svg> <?php echo Session::flash('success'); ?></div>
                <?php endif; ?>
                
                <?php if (Session::flash('error')): ?>
                    <div class="alert alert-error"><svg class="icon icon-text" aria-hidden="true"><use href="/assets/icons.svg#times-circle"></use></svg> <?php echo Session::flash('error'); ?></div>
                <?php endif; ?>