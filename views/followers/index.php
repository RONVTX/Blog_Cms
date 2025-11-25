<?php $pageTitle = ($type === 'followers' ? 'Seguidores' : 'Siguiendo') . ' de ' . htmlspecialchars($user['username']); ?>
<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="container" style="max-width: 800px; margin-top: 2rem;">
    <div class="hero-section" style="text-align: left; padding:1.25rem 1rem; margin-bottom:1.25rem;">
        <div style="position:relative;z-index:2;">
            <h1 style="margin:0 0 0.35rem 0;"><?php echo $type === 'followers' ? '<i class="fas fa-users" aria-hidden="true"></i> Seguidores' : '<i class="fas fa-link" aria-hidden="true"></i> Siguiendo'; ?> de <?php echo htmlspecialchars($user['username']); ?></h1>
            <p style="margin:0; opacity:0.95;">Conoce quién sigue a <?php echo htmlspecialchars($user['username']); ?> y gestiona tus conexiones.</p>
        </div>
    </div>
    
    <?php if (empty($followers)): ?>
        <div class="empty-state" style="text-align: center; padding: 4rem 2rem;">
            <p style="font-size: 3rem;"><i class="fas fa-users" aria-hidden="true"></i></p>
            <p style="color: var(--text-light);">
                <?php echo $type === 'followers' ? 'Este usuario aún no tiene seguidores' : 'Este usuario no sigue a nadie aún'; ?>
            </p>
        </div>
    <?php else: ?>
        <div style="display: grid; gap: 1.5rem;">
            <?php foreach ($followers as $follower): ?>
                <div style="background: white; padding: 1.5rem; border-radius: 12px; box-shadow: 0 2px 8px var(--shadow); display: flex; justify-content: space-between; align-items: center;">
                    <a href="/profile/<?php echo htmlspecialchars($follower['username']); ?>" 
                       style="display: flex; align-items: center; gap: 1rem; text-decoration: none; color: inherit; flex: 1;">
                        <?php if ($follower['avatar']): ?>
                            <img src="/<?php echo htmlspecialchars($follower['avatar']); ?>" 
                                 alt="<?php echo htmlspecialchars($follower['username']); ?>"
                                 style="width: 60px; height: 60px; border-radius: 50%; object-fit: cover; border: 3px solid var(--primary);">
                        <?php else: ?>
                            <div style="width: 60px; height: 60px; border-radius: 50%; background: var(--gradient); display: flex; align-items: center; justify-content: center; color: white; font-size: 1.5rem; font-weight: 700;">
                                <?php echo strtoupper(substr($follower['username'], 0, 1)); ?>
                            </div>
                        <?php endif; ?>
                        
                        <div>
                            <h3 style="margin-bottom: 0.25rem;"><?php echo htmlspecialchars($follower['username']); ?></h3>
                            <?php if ($follower['bio']): ?>
                                <p style="color: var(--text-light); font-size: 0.875rem;">
                                    <?php echo htmlspecialchars(substr($follower['bio'], 0, 100)); ?>
                                    <?php echo strlen($follower['bio']) > 100 ? '...' : ''; ?>
                                </p>
                            <?php endif; ?>
                        </div>
                    </a>
                    
                    <?php if (Session::isLoggedIn() && Session::getUserId() != $follower['id']): ?>
                        <?php 
                        $followerModel = new Follower();
                        $isFollowing = $followerModel->isFollowing(Session::getUserId(), $follower['id']);
                        ?>
                        <button 
                            onclick="toggleFollow(<?php echo $follower['id']; ?>, this)"
                            class="btn <?php echo $isFollowing ? 'btn-outline' : 'btn-primary'; ?>">
                            <?php echo $isFollowing ? '✓ Siguiendo' : '+ Seguir'; ?>
                        </button>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    
    <div style="margin-top: 2rem; text-align: center;">
        <a href="/profile/<?php echo htmlspecialchars($user['username']); ?>" class="btn btn-outline">
            ← Volver al perfil
        </a>
    </div>
</div>

<script src="/assets/js/follower.js"></script>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
