<?php $pageTitle = 'Editar Perfil'; ?>
<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="form-container">
    <h1 style="margin-bottom: 0.5rem;"><svg class="icon icon-header" aria-hidden="true"><use href="/assets/icons.svg#edit"></use></svg> Editar Perfil</h1>
    <p style="color: var(--text-light); margin-bottom: 2rem;">Actualiza tu información personal</p>
    
    <?php if (isset($error)): ?>
        <div class="alert alert-error"><svg class="icon" aria-hidden="true"><use href="/assets/icons.svg#times-circle"></use></svg> <?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form method="POST" action="/profile/update" enctype="multipart/form-data" class="form">
        <div class="form-group">
            <label for="username">👤 Nombre de Usuario:</label>
            <input type="text" 
                   id="username" 
                   name="username" 
                   value="<?php echo htmlspecialchars($user['username']); ?>" 
                   required 
                   minlength="3">
        </div>

        <div class="form-group">
            <label for="bio"><svg class="icon icon-text" aria-hidden="true"><use href="/assets/icons.svg#newspaper"></use></svg> Biografía:</label>
            <textarea id="bio" 
                      name="bio" 
                      rows="4" 
                      placeholder="Cuéntanos sobre ti..."><?php echo htmlspecialchars($user['bio'] ?? ''); ?></textarea>
        </div>

        <div class="form-group">
            <label for="avatar">🖼️ Avatar (opcional, máx. 5MB):</label>
            <?php if ($user['avatar']): ?>
                <img src="/<?php echo htmlspecialchars($user['avatar']); ?>" 
                     alt="Avatar actual" 
                     class="current-image">
            <?php endif; ?>
            <input type="file" 
                   id="avatar" 
                   name="avatar" 
                   accept="image/jpeg,image/png,image/gif,image/webp">
        </div>

        <div class="form-actions" style="display: flex; gap: 1rem; margin-top: 2rem;">
            <button type="submit" class="btn btn-primary">💾 Guardar Cambios</button>
            <a href="/profile/<?php echo htmlspecialchars($user['username']); ?>" class="btn btn-secondary"><svg class="icon" aria-hidden="true"><use href="/assets/icons.svg#times-circle"></use></svg> Cancelar</a>
        </div>
    </form>
</div>

<script src="/assets/js/main.js"></script>
<?php include __DIR__ . '/../layouts/footer.php'; ?>