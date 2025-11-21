<?php $pageTitle = 'Gestión de Usuarios'; ?>
<?php include __DIR__ . '/../layouts/admin-header.php'; ?>

<div class="admin-header">
    <h1>👥 Gestión de Usuarios</h1>
    <p>Administra todos los usuarios del sistema</p>
</div>

<div class="admin-card">
    <div class="table-responsive">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Usuario</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th>Estado</th>
                    <th>Posts</th>
                    <th>Comentarios</th>
                    <th>Registro</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                <tr>
                    <td><?php echo $user['id']; ?></td>
                    <td>
                        <a href="/profile/<?php echo htmlspecialchars($user['username']); ?>" target="_blank">
                            <?php echo htmlspecialchars($user['username']); ?>
                        </a>
                    </td>
                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                    <td>
                        <form method="POST" action="/admin/users/role" style="display: inline;">
                            <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                            <select name="role" onchange="this.form.submit()" class="status-badge <?php echo $user['role']; ?>">
                                <option value="user" <?php echo $user['role'] === 'user' ? 'selected' : ''; ?>>Usuario</option>
                                <option value="moderator" <?php echo $user['role'] === 'moderator' ? 'selected' : ''; ?>>Moderador</option>
                                <option value="admin" <?php echo $user['role'] === 'admin' ? 'selected' : ''; ?>>Admin</option>
                            </select>
                        </form>
                    </td>
                    <td>
                        <form method="POST" action="/admin/users/status" style="display: inline;">
                            <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                            <select name="status" onchange="this.form.submit()" class="status-badge <?php echo $user['status']; ?>">
                                <option value="active" <?php echo $user['status'] === 'active' ? 'selected' : ''; ?>>Activo</option>
                                <option value="suspended" <?php echo $user['status'] === 'suspended' ? 'selected' : ''; ?>>Suspendido</option>
                                <option value="banned" <?php echo $user['status'] === 'banned' ? 'selected' : ''; ?>>Baneado</option>
                            </select>
                        </form>
                    </td>
                    <td><?php echo $user['post_count']; ?></td>
                    <td><?php echo $user['comment_count']; ?></td>
                    <td><?php echo date('d/m/Y', strtotime($user['created_at'])); ?></td>
                    <td>
                        <?php if ($user['role'] !== 'admin'): ?>
                        <form method="POST" action="/admin/users/delete" style="display: inline;" onsubmit="return confirm('¿Eliminar este usuario?');">
                            <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                            <button type="submit" class="action-btn action-btn-danger action-btn-sm">🗑️</button>
                        </form>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include __DIR__ . '/../layouts/admin-footer.php'; ?>