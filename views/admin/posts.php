<?php $pageTitle = 'Gestión de Publicaciones'; ?>
<?php include __DIR__ . '/../layouts/admin-header.php'; ?>

<div class="admin-header">
    <h1>📝 Gestión de Publicaciones</h1>
    <p>Administra todas las publicaciones del blog</p>
</div>

<div class="admin-filters">
    <a href="/admin/posts" class="filter-btn <?php echo !isset($_GET['status']) ? 'active' : ''; ?>">
        Todas
    </a>
    <a href="/admin/posts?status=published" class="filter-btn <?php echo ($_GET['status'] ?? '') === 'published' ? 'active' : ''; ?>">
        Publicadas
    </a>
    <a href="/admin/posts?status=draft" class="filter-btn <?php echo ($_GET['status'] ?? '') === 'draft' ? 'active' : ''; ?>">
        Borradores
    </a>
    <a href="/admin/posts?status=archived" class="filter-btn <?php echo ($_GET['status'] ?? '') === 'archived' ? 'active' : ''; ?>">
        Archivadas
    </a>
</div>

<div class="admin-card">
    <div class="table-responsive">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Autor</th>
                    <th>Estado</th>
                    <th>Destacado</th>
                    <th>Vistas</th>
                    <th>Likes</th>
                    <th>Comentarios</th>
                    <th>Fecha</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($posts as $post): ?>
                <tr>
                    <td><?php echo $post['id']; ?></td>
                    <td>
                        <a href="/blog/<?php echo htmlspecialchars($post['slug']); ?>" target="_blank">
                            <?php echo htmlspecialchars($post['title']); ?>
                        </a>
                    </td>
                    <td><?php echo htmlspecialchars($post['username']); ?></td>
                    <td>
                        <form method="POST" action="/admin/posts/status" style="display: inline;">
                            <input type="hidden" name="post_id" value="<?php echo $post['id']; ?>">
                            <select name="status" onchange="this.form.submit()" class="status-badge <?php echo $post['status']; ?>">
                                <option value="draft" <?php echo $post['status'] === 'draft' ? 'selected' : ''; ?>>Borrador</option>
                                <option value="published" <?php echo $post['status'] === 'published' ? 'selected' : ''; ?>>Publicado</option>
                                <option value="archived" <?php echo $post['status'] === 'archived' ? 'selected' : ''; ?>>Archivado</option>
                            </select>
                        </form>
                    </td>
                    <td>
                        <form method="POST" action="/admin/posts/featured" style="display: inline;">
                            <input type="hidden" name="post_id" value="<?php echo $post['id']; ?>">
                            <button type="submit" class="action-btn-sm <?php echo $post['featured'] ? 'action-btn-success' : ''; ?>">
                                <?php echo $post['featured'] ? '⭐' : '☆'; ?>
                            </button>
                        </form>
                    </td>
                    <td><?php echo number_format($post['views']); ?></td>
                    <td><?php echo number_format($post['likes_count']); ?></td>
                    <td><?php echo number_format($post['comments_count']); ?></td>
                    <td><?php echo date('d/m/Y', strtotime($post['created_at'])); ?></td>
                    <td>
                        <div class="admin-actions">
                            <a href="/post/edit/<?php echo $post['id']; ?>" class="action-btn action-btn-primary action-btn-sm">✏️</a>
                            <form method="POST" action="/admin/posts/delete" style="display: inline;" onsubmit="return confirm('¿Eliminar esta publicación?');">
                                <input type="hidden" name="post_id" value="<?php echo $post['id']; ?>">
                                <button type="submit" class="action-btn action-btn-danger action-btn-sm">🗑️</button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include __DIR__ . '/../layouts/admin-footer.php'; ?>