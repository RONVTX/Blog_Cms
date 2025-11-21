<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle ?? APP_NAME; ?></title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <a href="/" class="logo"><?php echo APP_NAME; ?></a>
            
            <form action="/search" method="GET" class="search-bar">
                <input type="text" name="q" placeholder="Buscar..." value="<?php echo htmlspecialchars($_GET['q'] ?? ''); ?>">
                <button type="submit">🔍</button>
            </form>
            
            <div class="nav-links">
                <a href="/">Inicio</a>
                
                <?php if (Session::isLoggedIn()): ?>
                    <a href="/post/create" class="btn btn-primary btn-sm">✍️ Crear Post</a>
                    <a href="/bookmarks">📑 Guardados</a>
                    
                    <!-- Notificaciones -->
                    <a href="/notifications" style="position: relative;">
                        🔔
                        <?php 
                        $notifModel = new Notification();
                        $unreadCount = $notifModel->getUnreadCount(Session::getUserId());
                        if ($unreadCount > 0): 
                        ?>
                            <span style="position: absolute; top: -8px; right: -8px; background: #ef4444; color: white; border-radius: 50%; width: 20px; height: 20px; display: flex; align-items: center; justify-content: center; font-size: 0.75rem; font-weight: 700;">
                                <?php echo $unreadCount > 9 ? '9+' : $unreadCount; ?>
                            </span>
                        <?php endif; ?>
                    </a>
                    
                    <?php
                    // Verificar si es admin o moderador - CORREGIDO
                    $userModel = new User();
                    $currentUser = $userModel->findById(Session::getUserId());
                    if ($currentUser && isset($currentUser['role']) && in_array($currentUser['role'], ['admin', 'moderator'])): 
                    ?>
                        <a href="/admin" class="btn btn-sm" style="background: var(--gradient);">⚡ Admin</a>
                    <?php endif; ?>
                    
                    <a href="/profile/<?php echo htmlspecialchars(Session::getUsername()); ?>" class="user-info">
                        <?php 
                        if ($currentUser && isset($currentUser['avatar']) && $currentUser['avatar']): 
                        ?>
                            <img src="/<?php echo htmlspecialchars($currentUser['avatar']); ?>" alt="Avatar" class="user-avatar">
                        <?php else: ?>
                            <span class="user-avatar" style="background: var(--gradient); display: flex; align-items: center; justify-content: center; color: white; font-weight: 700;">
                                <?php echo strtoupper(substr(Session::getUsername(), 0, 1)); ?>
                            </span>
                        <?php endif; ?>
                        <span><?php echo htmlspecialchars(Session::getUsername()); ?></span>
                    </a>
                    <a href="/logout" class="btn btn-danger btn-sm">Salir</a>
                <?php else: ?>
                    <a href="/login" class="btn btn-outline btn-sm">Iniciar Sesión</a>
                    <a href="/register" class="btn btn-primary btn-sm">Registrarse</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>
    <main class="container">