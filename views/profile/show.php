<?php $pageTitle = htmlspecialchars($user['username']) . ' - Perfil'; ?>
<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="profile-header">
    <div class="container">
        <div class="profile-info">
            <?php if ($user['avatar']): ?>
                <img src="/<?php echo htmlspecialchars($user['avatar']); ?>" 
                     alt="<?php echo htmlspecialchars($user['username']); ?>" 
                     class="profile-avatar">
            <?php else: ?>
                <div class="profile-avatar" style="background: rgba(255,255,255,0.2); display: flex; align-items: center; justify-content: center; color: white; font-size: 3rem; font-weight: 700;">
                    <?php echo strtoupper(substr($user['username'], 0, 1)); ?>
                </div>
            <?php endif; ?>
            
            <div class="profile-details">
                <h1><?php echo htmlspecialchars($user['username']); ?></h1>
                <?php if ($user['bio']): ?>
                    <p class="profile-bio"><?php echo nl2br(htmlspecialchars($user['bio'])); ?></p>
                <?php endif; ?>
                
                <div class="profile-stats">
                    <div class="stat">
                        <span class="stat-value"><?php echo $stats['posts']; ?></span>
                        <span class="stat-label">Publicaciones</span>
                    </div>
                    <div class="stat">
                        <span class="stat-value"><?php echo $stats['likes']; ?></span>
                        <span class="stat-label">Likes Recibidos</span>
                    </div>
                    <div class="stat">
                        <span class="stat-value"><?php echo $stats['comments']; ?></span>
                        <span class="stat-label">Comentarios</span>
                    </div>
                </div>
                
                <?php if (Session::isLoggedIn() && Session::getUserId() == $user['id']): ?>
                    <a href="/profile/edit" class="btn" style="margin-top: 1rem; background: rgba(255,255,255,0.2); backdrop-filter: blur(10px);">
                        ✏️ Editar Perfil
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<div class="container" style="margin-top: 3rem;">
    <h2 style="margin-bottom: 2rem;">📝 Publicaciones de <?php echo htmlspecialchars($user['username']); ?></h2>
    
    <?php if (empty($posts)): ?>
        <div class="empty-state" style="text-align: center; padding: 4rem 2rem;">
            <p style="font-size: 3rem;">📝</p>
            <p style="color: var(--text-light);">Este usuario aún no ha publicado nada</p>
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