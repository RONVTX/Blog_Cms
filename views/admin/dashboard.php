<?php $pageTitle = 'Panel de Administración'; ?>
<?php include __DIR__ . '/../layouts/admin-header.php'; ?>

<div class="admin-header">
    <h1>📊 Dashboard</h1>
    <p>Resumen general del sistema</p>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
            👥
        </div>
        <div class="stat-info">
            <h3><?php echo number_format($stats['total_users']); ?></h3>
            <p>Usuarios Totales</p>
            <span class="stat-badge success">+<?php echo $stats['new_users_today']; ?> hoy</span>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
            📝
        </div>
        <div class="stat-info">
            <h3><?php echo number_format($stats['total_posts']); ?></h3>
            <p>Publicaciones</p>
            <span class="stat-badge info"><?php echo $stats['published_posts']; ?> publicadas</span>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
            💬
        </div>
        <div class="stat-info">
            <h3><?php echo number_format($stats['total_comments']); ?></h3>
            <p>Comentarios</p>
            <?php if ($stats['pending_comments'] > 0): ?>
                <span class="stat-badge warning"><?php echo $stats['pending_comments']; ?> pendientes</span>
            <?php endif; ?>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
            👁️
        </div>
        <div class="stat-info">
            <h3><?php echo number_format($stats['total_views']); ?></h3>
            <p>Vistas Totales</p>
        </div>
    </div>

    <?php if ($stats['pending_reports'] > 0): ?>
    <div class="stat-card alert">
        <div class="stat-icon" style="background: linear-gradient(135deg, #ff6b6b 0%, #ee5a6f 100%);">
            ⚠️
        </div>
        <div class="stat-info">
            <h3><?php echo $stats['pending_reports']; ?></h3>
            <p>Reportes Pendientes</p>
            <a href="/admin/reports" class="stat-link">Ver reportes →</a>
        </div>
    </div>
    <?php endif; ?>

    <div class="stat-card">
        <div class="stat-icon" style="background: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);">
            📄
        </div>
        <div class="stat-info">
            <h3><?php echo $stats['draft_posts']; ?></h3>
            <p>Borradores</p>
        </div>
    </div>
</div>

<div class="admin-row">
    <div class="admin-col-8">
        <div class="admin-card">
            <h2>🔥 Posts Más Populares</h2>
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Título</th>
                            <th>Autor</th>
                            <th>Vistas</th>
                            <th>Likes</th>
                            <th>Comentarios</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($popularPosts as $post): ?>
                        <tr>
                            <td>
                                <a href="/blog/<?php echo htmlspecialchars($post['slug']); ?>" target="_blank">
                                    <?php echo htmlspecialchars($post['title']); ?>
                                </a>
                            </td>
                            <td><?php echo htmlspecialchars($post['username']); ?></td>
                            <td><?php echo number_format($post['views']); ?></td>
                            <td><?php echo number_format($post['likes_count']); ?></td>
                            <td><?php echo number_format($post['comments_count']); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="admin-col-4">
        <div class="admin-card">
            <h2>📋 Actividad Reciente</h2>
            <div class="activity-list">
                <?php foreach ($recentActivity as $activity): ?>
                <div class="activity-item">
                    <div class="activity-icon">📌</div>
                    <div class="activity-content">
                        <p><?php echo htmlspecialchars($activity['description']); ?></p>
                        <span class="activity-time">
                            <?php 
                            $time = strtotime($activity['created_at']);
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
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/admin-footer.php'; ?>