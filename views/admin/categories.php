<?php $pageTitle = 'Gestión de Categorías'; ?>
<?php include __DIR__ . '/../layouts/admin-header.php'; ?>

<div class="admin-header">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h1>📚 Gestión de Categorías</h1>
            <p>Organiza el contenido del blog</p>
        </div>
        <a href="/admin/categories/create" class="action-btn action-btn-primary">➕ Nueva Categoría</a>
    </div>
</div>

<div class="admin-card">
    <div class="table-responsive">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Icono</th>
                    <th>Nombre</th>
                    <th>Slug</th>
                    <th>Descripción</th>
                    <th>Posts</th>
                    <th>Color</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categories as $category): ?>
                <tr>
                    <td><?php echo $category['id']; ?></td>
                    <td style="font-size: 1.5rem;"><?php echo htmlspecialchars($category['icon'] ?? '📁'); ?></td>
                    <td><?php echo htmlspecialchars($category['name']); ?></td>
                    <td><?php echo htmlspecialchars($category['slug']); ?></td>
                    <td><?php echo htmlspecialchars(substr($category['description'] ?? '', 0, 50)); ?>...</td>
                    <td><?php echo $category['post_count']; ?></td>
                    <td>
                        <span style="display: inline-block; width: 30px; height: 30px; background: <?php echo htmlspecialchars($category['color']); ?>; border-radius: 50%;"></span>
                    </td>
                    <td>
                        <div class="admin-actions">
                            <a href="/category/<?php echo htmlspecialchars($category['slug']); ?>" target="_blank" class="action-btn action-btn-primary action-btn-sm">👁️</a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include __DIR__ . '/../layouts/admin-footer.php'; ?>