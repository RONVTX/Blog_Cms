<?php $pageTitle = 'Crear Publicación'; ?>
<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="form-container" style="max-width: 900px;">
    <h1 style="margin-bottom: 0.5rem;">✨ Crear Nueva Publicación</h1>
    <p style="color: var(--text-light); margin-bottom: 2rem;">Comparte tus ideas con la comunidad</p>
    
    <?php if (isset($error)): ?>
        <div class="alert alert-error">❌ <?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form method="POST" action="/post/create" enctype="multipart/form-data" class="form">
        <div class="form-group">
            <label for="title">📝 Título:</label>
            <input type="text" 
                   id="title" 
                   name="title" 
                   placeholder="Escribe un título atractivo..." 
                   required 
                   maxlength="200">
        </div>

        <div class="form-group">
            <label for="content">📄 Contenido:</label>
            <textarea id="content" 
                      name="content" 
                      placeholder="Escribe el contenido de tu publicación..." 
                      required 
                      rows="15"></textarea>
        </div>

        <div class="form-group">
            <label>📚 Categorías:</label>
            <div class="checkbox-group">
                <?php foreach ($categories as $category): ?>
                    <label class="checkbox-item">
                        <input type="checkbox" 
                               name="categories[]" 
                               value="<?php echo $category['id']; ?>">
                        <?php echo htmlspecialchars($category['name']); ?>
                    </label>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="form-group">
            <label for="image">🖼️ Imagen de portada (opcional, máx. 5MB):</label>
            <input type="file" 
                   id="image" 
                   name="image" 
                   accept="image/jpeg,image/png,image/gif,image/webp">
        </div>

        <div class="form-actions" style="display: flex; gap: 1rem; margin-top: 2rem;">
            <button type="submit" class="btn btn-primary">🚀 Publicar</button>
            <a href="/" class="btn btn-secondary">❌ Cancelar</a>
        </div>
    </form>
</div>

<script src="/assets/js/main.js"></script>
<?php include __DIR__ . '/../layouts/footer.php'; ?>