<?php $pageTitle = 'Editar Publicación'; ?>
<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="form-container" style="max-width: 900px;">
    <h1 style="margin-bottom: 0.5rem;"><svg class="icon icon-header" aria-hidden="true"><use href="/assets/icons.svg#edit"></use></svg> Editar Publicación</h1>
    <p style="color: var(--text-light); margin-bottom: 2rem;">Actualiza el contenido de tu publicación</p>
    
    <?php if (isset($error)): ?>
        <div class="alert alert-error"><svg class="icon" aria-hidden="true"><use href="/assets/icons.svg#times-circle"></use></svg> <?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form method="POST" action="/post/edit/<?php echo $post['id']; ?>" enctype="multipart/form-data" class="form">
        <div class="form-group">
            <label for="title"><svg class="icon icon-text" aria-hidden="true"><use href="/assets/icons.svg#newspaper"></use></svg> Título:</label>
            <input type="text" 
                   id="title" 
                   name="title" 
                   value="<?php echo htmlspecialchars($post['title']); ?>" 
                   required 
                   maxlength="200">
        </div>

        <div class="form-group">
            <label for="content">📄 Contenido:</label>
            <textarea id="content" 
                      name="content" 
                      required 
                      rows="15"><?php echo htmlspecialchars($post['content']); ?></textarea>
        </div>

        <div class="form-group">
            <label><svg class="icon icon-text" aria-hidden="true"><use href="/assets/icons.svg#folder"></use></svg> Categorías:</label>
            <div class="checkbox-group">
                <?php foreach ($categories as $category): ?>
                    <label class="checkbox-item">
                        <input type="checkbox" 
                               name="categories[]" 
                               value="<?php echo $category['id']; ?>"
                               <?php echo in_array($category['id'], $selectedCategories) ? 'checked' : ''; ?>>
                        <?php echo htmlspecialchars($category['name']); ?>
                    </label>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="form-group">
            <label for="image">Cambiar imagen (opcional, máx. 5MB):</label>
            <?php if ($post['image']): ?>
                <img src="/<?php echo htmlspecialchars($post['image']); ?>" 
                     alt="Imagen actual" 
                     class="current-image">
            <?php endif; ?>
            <input type="file" 
                   id="image" 
                   name="image" 
                   accept="image/jpeg,image/png,image/gif,image/webp">
        </div>

        <div class="form-actions" style="display: flex; gap: 1rem; margin-top: 2rem;">
            <button type="submit" class="btn btn-primary">💾 Actualizar</button>
            <a href="/blog/<?php echo htmlspecialchars($post['slug']); ?>" class="btn btn-secondary"><svg class="icon" aria-hidden="true"><use href="/assets/icons.svg#times-circle"></use></svg> Cancelar</a>
        </div>
    </form>
</div>

<script src="/assets/js/main.js"></script>
<?php include __DIR__ . '/../layouts/footer.php'; ?>