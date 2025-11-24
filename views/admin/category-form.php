<?php $pageTitle = 'Nueva Categoría'; ?>
<?php include __DIR__ . '/../layouts/admin-header.php'; ?>

<div class="admin-header">
    <div>
        <h1><svg class="icon icon-header" aria-hidden="true"><use href="/assets/icons.svg#folder"></use></svg> Nueva Categoría</h1>
        <p>Crea una nueva categoría para organizar posts</p>
    </div>
</div>

<div class="admin-card" style="max-width: 600px;">
    <form method="POST" action="/admin/categories/store" class="form">
        <div class="form-group">
            <label for="name">Nombre de la categoría:</label>
            <input type="text" id="name" name="name" required placeholder="Ej: Tecnología" value="<?php echo htmlspecialchars($category['name'] ?? ''); ?>">
        </div>

        <div class="form-group">
            <label for="description">Descripción:</label>
            <textarea id="description" name="description" rows="4" placeholder="Describe esta categoría..."></textarea>
        </div>

        <div class="form-group">
            <label for="icon">Icono (emoji):</label>
            <input type="text" id="icon" name="icon" placeholder="Ej: 💻" maxlength="2" value="<?php echo htmlspecialchars($category['icon'] ?? '📁'); ?>">
            <small style="color: var(--text-light);">Puedes usar un emoji o símbolo</small>
        </div>

        <div class="form-group">
            <label for="color">Color:</label>
            <input type="color" id="color" name="color" value="<?php echo htmlspecialchars($category['color'] ?? '#6366f1'); ?>">
        </div>

        <div style="display: flex; gap: 1rem; justify-content: flex-end;">
            <a href="/admin/categories" class="btn btn-outline">Cancelar</a>
            <button type="submit" class="btn btn-primary">Crear Categoría</button>
        </div>
    </form>
</div>

<?php include __DIR__ . '/../layouts/admin-footer.php'; ?>
