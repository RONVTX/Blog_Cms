<?php $pageTitle = 'Notificaciones'; ?>
<?php include __DIR__ . '/../layouts/header.php'; ?>

<div style="max-width: 800px; margin: 2rem auto;">
    <div class="hero-section" style="text-align: left; padding: 2rem 1.25rem; margin-bottom: 1.5rem;">
        <div style="display:flex;justify-content:space-between;align-items:center;gap:1rem;position:relative;z-index:2;">
            <div>
                <h1 style="margin:0;"><svg class="icon icon-header" aria-hidden="true"><use href="/assets/icons.svg#bell"></use></svg> Notificaciones</h1>
                <p style="margin:0.35rem 0 0 0; opacity:0.95;">Revisa lo último: seguidores, likes y actividad.</p>
            </div>
            <form method="POST" action="/notifications/read-all">
                <button type="submit" class="btn btn-outline btn-sm">✓ Marcar todas como leídas</button>
            </form>
        </div>
    </div>

    <?php if (empty($notifications)): ?>
        <div class="empty-state" style="text-align: center; padding: 4rem 2rem;">
            <p style="font-size: 3rem;"><svg class="icon" aria-hidden="true"><use href="/assets/icons.svg#bell"></use></svg></p>
            <p style="color: var(--text-light);">No tienes notificaciones</p>
        </div>
    <?php else: ?>
        <div style="display: flex; flex-direction: column; gap: 1rem;">
            <?php foreach ($notifications as $notif): 
                // Intentamos obtener el actor desde el enlace si tiene formato /profile/username
                $actor = null;
                if (!empty($notif['link']) && preg_match('#^/profile/([^/]+)#', $notif['link'], $m)) {
                    $actor = (new User())->findByUsername($m[1]);
                }
            ?>
            <div class="notification-item <?php echo $notif['is_read'] ? '' : 'unread'; ?>" style="background: white; padding: 1.5rem; border-radius: 12px; box-shadow: 0 2px 8px var(--shadow); <?php echo !$notif['is_read'] ? 'border-left: 4px solid var(--primary);' : ''; ?>">
                <div style="display: flex; gap: 0.75rem; justify-content: space-between; align-items: center;">
                    <div style="display:flex;gap:0.75rem;align-items:center;flex:1;">
                        <div style="width:48px;flex:0 0 48px;display:flex;align-items:center;justify-content:center;">
                            <?php if ($actor && isset($actor['avatar']) && $actor['avatar']): ?>
                                <img src="/<?php echo htmlspecialchars($actor['avatar']); ?>" alt="Avatar" style="width:44px;height:44px;border-radius:50%;object-fit:cover;box-shadow:0 2px 6px rgba(0,0,0,0.08);">
                            <?php else: ?>
                                <div style="width:44px;height:44px;border-radius:50%;background:var(--gradient);display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;box-shadow:0 2px 6px rgba(0,0,0,0.08);">
                                    <?php
                                    $initial = '';
                                    if ($actor && isset($actor['username'])) {
                                        $initial = strtoupper(substr($actor['username'], 0, 1));
                                    } else {
                                        // Fallback: intentar extraer nombre desde el contenido
                                        preg_match('/^(\S+)/', $notif['content'], $nameMatch);
                                        $initial = isset($nameMatch[1]) ? strtoupper(substr($nameMatch[1],0,1)) : '?';
                                    }
                                    echo $initial;
                                    ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div style="flex:1;">
                            <p style="margin-bottom: 0.5rem;">
                            <?php 
                     
                            
                            echo htmlspecialchars($notif['content']); 
                            ?>
                            </p>
                            <span style="font-size: 0.875rem; color: var(--text-light);">
                                <?php 
                                $time = strtotime($notif['created_at']);
                                $diff = time() - $time;
                                if ($diff < 60) {
                                    echo 'Hace un momento';
                                } elseif ($diff < 3600) {
                                    echo 'Hace ' . floor($diff / 60) . ' minutos';
                                } elseif ($diff < 86400) {
                                    echo 'Hace ' . floor($diff / 3600) . ' horas';
                                } else {
                                    echo date('d/m/Y H:i', $time);
                                }
                                ?>
                            </span>
                        </div>
                    </div>

                    <div style="display: flex; gap: 0.5rem;">
                        <?php if ($notif['link']): ?>
                            <a href="<?php echo htmlspecialchars($notif['link']); ?>" class="btn btn-sm btn-primary">Ver</a>
                        <?php endif; ?>
                        <?php if (!$notif['is_read']): ?>
                            <button onclick="markAsRead(<?php echo $notif['id']; ?>)" class="btn btn-sm btn-outline">✓</button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<script src="/assets/js/main.js"></script>

<?php include __DIR__ . '/../layouts/footer.php'; ?>