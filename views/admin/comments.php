<?php $pageTitle = 'Gestión de Comentarios'; ?>
<?php include __DIR__ . '/../layouts/admin-header.php'; ?>

<div class="admin-header">
    <h1><svg class="icon icon-header" aria-hidden="true"><use href="/assets/icons.svg#comments"></use></svg> Gestión de Comentarios</h1>
    <p>Modera los comentarios del blog</p>
</div>

<div class="admin-filters">
    <a href="/admin/comments" class="filter-btn <?php echo !isset($_GET['status']) ? 'active' : ''; ?>">
        Todos
    </a>
    <a href="/admin/comments?status=approved" class="filter-btn <?php echo ($_GET['status'] ?? '') === 'approved' ? 'active' : ''; ?>">
        Aprobados
    </a>
    <a href="/admin/comments?status=pending" class="filter-btn <?php echo ($_GET['status'] ?? '') === 'pending' ? 'active' : ''; ?>">
        Pendientes
    </a>
    <a href="/admin/comments?status=rejected" class="filter-btn <?php echo ($_GET['status'] ?? '') === 'rejected' ? 'active' : ''; ?>">
        Rechazados
    </a>
</div>

<div class="admin-card">
    <div class="table-responsive">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Usuario</th>
                    <th>Post</th>
                    <th>Comentario</th>
                    <th>Estado</th>
                    <th>Fecha</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($comments as $comment): ?>
                <tr>
                    <td><?php echo $comment['id']; ?></td>
                    <td><?php echo htmlspecialchars($comment['username']); ?></td>
                    <td>
                        <a href="/blog/<?php echo htmlspecialchars($comment['post_slug']); ?>" target="_blank">
                            <?php echo htmlspecialchars(substr($comment['post_title'], 0, 40)); ?>...
                        </a>
                    </td>
                    <td><?php echo htmlspecialchars(substr($comment['content'], 0, 100)); ?>...</td>
                    <td>
                        <form method="POST" action="/admin/comments/status" style="display: inline;">
                            <input type="hidden" name="comment_id" value="<?php echo $comment['id']; ?>">
                            <select name="status" onchange="this.form.submit()" class="status-badge <?php echo $comment['status']; ?>">
                                <option value="pending" <?php echo $comment['status'] === 'pending' ? 'selected' : ''; ?>>Pendiente</option>
                                <option value="approved" <?php echo $comment['status'] === 'approved' ? 'selected' : ''; ?>>Aprobado</option>
                                <option value="rejected" <?php echo $comment['status'] === 'rejected' ? 'selected' : ''; ?>>Rechazado</option>
                            </select>
                        </form>
                    </td>
                    <td><?php echo date('d/m/Y H:i', strtotime($comment['created_at'])); ?></td>
                    <td>
                        <form method="POST" action="/admin/comments/delete" style="display: inline;" onsubmit="return showDeleteConfirm('¿Eliminar este comentario?', this);">
                            <input type="hidden" name="comment_id" value="<?php echo $comment['id']; ?>">
                            <button type="submit" class="action-btn action-btn-danger action-btn-sm"><svg class="icon icon-text" aria-hidden="true"><use href="/assets/icons.svg#times-circle"></use></svg></button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include __DIR__ . '/../layouts/admin-footer.php'; ?>