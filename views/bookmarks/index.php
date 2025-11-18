<?php $pageTitle = 'Mis Marcadores'; ?>
<?php include __DIR__ . '/../layouts/header.php'; ?>

<div style="background: var(--gradient); color: white; padding: 3rem 0; border-radius: 16px; margin-bottom: 3rem;">
    <div class="container">
        <h1 style="font-size: 2.5rem; margin-bottom: 0.5rem;">
            🔖 Mis Marcadores
        </h1>
        <p style="opacity: 0.9; font-size: 1.125rem;">
            Publicaciones que has guardado para leer más tarde
        </p>
    </div>
</div>

<div class="container">
    <?php if (empty($posts)): ?>
        <div class="empty-state" style="text-align: center; padding: 4rem 2rem;">
            <p style="font-size: 3rem;">📑</p>
            <p style="color: var(--text-light); margin-bottom: 1.5rem;">
                No has guardado ninguna publicación todavía
            </p>
            <a href="/" class="btn btn-primary">Explorar Publicaciones</a>
        </div>
    <?php else: ?>
        <div class="posts-grid">
            <?php foreach ($posts as $post): ?>
                <article class="post-card">
                    <?php if ($post['image']): ?>
                        <img src="/<?php echo htmlspecialchars($post['image']); ?>" 
                             alt="<?php echo htmlspecialchars($post['title']); ?>" 
                             class="post-image">
                    <?php endif; ?>
                    
                    <div class="post-content">
                        <h2 class="post-title">
                            <a href="/blog/<?php echo htmlspecialchars($post['slug']); ?>">
                                <?php echo htmlspecialchars($post['title']); ?>
                            </a>
                        </h2>
                        
                        <div class="post-meta">
                            <a href="/profile/<?php echo htmlspecialchars($post['username']); ?>" class="post-author">
                                <span><?php echo htmlspecialchars($post['username']); ?></span>
                            </a>
                            <span>📅 <?php echo date('d/m/Y', strtotime($post['created_at'])); ?></span>
                        </div>
                        
                        <p class="post-excerpt">
                            <?php echo htmlspecialchars(substr($post['content'], 0, 150)); ?>...
                        </p>
                        
                        <div class="post-footer">
                            <div class="post-stats">
                                <span class="post-stat">❤️ <?php echo $post['likes_count']; ?></span>
                                <span class="post-stat">💬 <?php echo $post['comments_count']; ?></span>
                            </div>
                            <a href="/blog/<?php echo htmlspecialchars($post['slug']); ?>" class="btn btn-sm btn-primary">
                                Leer más →
                            </a>
                        </div>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>