<?php $pageTitle = 'Inicio - ' . APP_NAME; ?>
<?php include __DIR__ . '/layouts/header.php'; ?>

<div class="layout-with-sidebar">
    <aside class="sidebar">
        <div class="sidebar-section">
            <h3>Categorías</h3>
            <div class="category-list">
                <?php foreach ($categories as $category): ?>
                    <a href="/category/<?php echo htmlspecialchars($category['slug']); ?>" class="category-item">
                        <span><?php echo htmlspecialchars($category['name']); ?></span>
                        <span class="category-badge"><?php echo $category['post_count']; ?></span>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
        
        <?php if (!empty($trending)): ?>
        <div class="sidebar-section">
            <h3>Tendencias</h3>
            <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                <?php foreach ($trending as $index => $post): ?>
                    <a href="/blog/<?php echo htmlspecialchars($post['slug']); ?>" class="trending-post">
                        <div class="trending-number"><?php echo $index + 1; ?></div>
                        <div class="trending-info">
                            <h4><?php echo htmlspecialchars($post['title']); ?></h4>
                            <div class="trending-meta">
                                <svg class="icon icon-text" aria-hidden="true"><use href="/assets/icons.svg#heart"></use></svg> <?php echo $post['likes_count']; ?> · 
                                <svg class="icon icon-text" aria-hidden="true"><use href="/assets/icons.svg#comments"></use></svg> <?php echo $post['comments_count']; ?> · 
                                <svg class="icon icon-text" aria-hidden="true"><use href="/assets/icons.svg#eye"></use></svg> <?php echo $post['views']; ?>
                            </div>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
    </aside>
    
    <div>
            <h1 style="margin-bottom: 2rem; font-size: 2.5rem; background: var(--gradient); background-clip: text; -webkit-background-clip: text; -webkit-text-fill-color: transparent;">
            <svg class="icon icon-header" aria-hidden="true"><use href="/assets/icons.svg#star"></use></svg> Últimas Publicaciones
        </h1>
        
        <?php if (empty($posts)): ?>
            <div class="empty-state" style="text-align: center; padding: 4rem 2rem;">
                <h2 style="font-size: 3rem; margin-bottom: 1rem;"><i class="fas fa-newspaper" aria-hidden="true"></i></h2>
                    <h2 style="font-size: 3rem; margin-bottom: 1rem;"><svg class="icon" aria-hidden="true"><use href="/assets/icons.svg#newspaper"></use></svg></h2>
                <p style="font-size: 1.25rem; color: var(--text-light); margin-bottom: 1.5rem;">
                    No hay publicaciones todavía.
                </p>
                <?php if (Session::isLoggedIn()): ?>
                    <a href="/post/create" class="btn btn-primary">¡Crea la primera!</a>
                <?php endif; ?>
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
                            <?php 
                            $categoryModel = new Category();
                            $postCategories = $categoryModel->getPostCategories($post['id']);
                            if (!empty($postCategories)): 
                            ?>
                                <div class="post-categories">
                                    <?php foreach ($postCategories as $category): ?>
                                        <a href="/category/<?php echo htmlspecialchars($category['slug']); ?>" class="category-tag">
                                            <?php echo htmlspecialchars($category['name']); ?>
                                        </a>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                            
                            <h2 class="post-title">
                                <a href="/blog/<?php echo htmlspecialchars($post['slug']); ?>">
                                    <?php echo htmlspecialchars($post['title']); ?>
                                </a>
                            </h2>
                            
                            <div class="post-meta">
                                <a href="/profile/<?php echo htmlspecialchars($post['username']); ?>" class="post-author">
                                    <?php if ($post['avatar']): ?>
                                        <img src="/<?php echo htmlspecialchars($post['avatar']); ?>" alt="<?php echo htmlspecialchars($post['username']); ?>">
                                    <?php else: ?>
                                        <span style="width: 24px; height: 24px; background: var(--gradient); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 0.75rem;">
                                            <?php echo strtoupper(substr($post['username'], 0, 1)); ?>
                                        </span>
                                    <?php endif; ?>
                                    <span><?php echo htmlspecialchars($post['username']); ?></span>
                                </a>
                                <span><svg class="icon icon-text" aria-hidden="true"><use href="/assets/icons.svg#calendar"></use></svg> <?php echo date('d/m/Y', strtotime($post['created_at'])); ?></span>
                            </div>
                            
                            <p class="post-excerpt">
                                <?php echo htmlspecialchars(substr($post['content'], 0, 300)); ?>...
                            </p>
                            
                            <div class="post-footer">
                                <div class="post-stats">
                                    <span class="post-stat"><svg class="icon icon-text" aria-hidden="true"><use href="/assets/icons.svg#heart"></use></svg> <?php echo $post['likes_count']; ?></span>
                                        <span class="post-stat"><svg class="icon icon-text" aria-hidden="true"><use href="/assets/icons.svg#comments"></use></svg> <?php echo $post['comments_count']; ?></span>
                                        <span class="post-stat"><svg class="icon icon-text" aria-hidden="true"><use href="/assets/icons.svg#eye"></use></svg> <?php echo $post['views']; ?></span>
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
</div>
<?php include __DIR__ . '/layouts/footer.php'; ?>