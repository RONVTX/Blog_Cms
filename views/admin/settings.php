<?php $pageTitle = 'Configuración del Sitio'; ?>
<?php include __DIR__ . '/../layouts/admin-header.php'; ?>

<div class="admin-header">
    <h1><svg class="icon icon-header" aria-hidden="true"><use href="/assets/icons.svg#cog"></use></svg> Configuración del Sitio</h1>
    <p>Ajusta la configuración general del blog</p>
</div>

<div class="admin-card">
    <form method="POST" action="/admin/settings/update">
        <div class="admin-form-group">
            <label>Nombre del Sitio:</label>
            <input type="text" name="settings[site_name]" value="<?php echo htmlspecialchars($settings['site_name'] ?? ''); ?>" required>
        </div>

        <div class="admin-form-group">
            <label>Descripción del Sitio:</label>
            <textarea name="settings[site_description]" rows="3"><?php echo htmlspecialchars($settings['site_description'] ?? ''); ?></textarea>
        </div>

        <div class="admin-form-group">
            <label>Posts por página:</label>
            <input type="number" name="settings[posts_per_page]" value="<?php echo htmlspecialchars($settings['posts_per_page'] ?? '12'); ?>" min="1" max="100">
        </div>

        <div class="admin-form-group">
            <label>
                <input type="checkbox" name="settings[comments_enabled]" value="1" <?php echo ($settings['comments_enabled'] ?? '1') == '1' ? 'checked' : ''; ?>>
                Habilitar comentarios
            </label>
        </div>

        <div class="admin-form-group">
            <label>
                <input type="checkbox" name="settings[registration_enabled]" value="1" <?php echo ($settings['registration_enabled'] ?? '1') == '1' ? 'checked' : ''; ?>>
                Habilitar registro de usuarios
            </label>
        </div>

        <div class="admin-form-group">
            <label>
                <input type="checkbox" name="settings[moderate_comments]" value="1" <?php echo ($settings['moderate_comments'] ?? '0') == '1' ? 'checked' : ''; ?>>
                Moderar comentarios antes de publicar
            </label>
        </div>

        <div class="admin-form-group">
            <label>
                <input type="checkbox" name="settings[maintenance_mode]" value="1" <?php echo ($settings['maintenance_mode'] ?? '0') == '1' ? 'checked' : ''; ?>>
                Modo mantenimiento
            </label>
        </div>

        <button type="submit" class="action-btn action-btn-primary">💾 Guardar Cambios</button>
    </form>
</div>

<?php include __DIR__ . '/../layouts/admin-footer.php'; ?>