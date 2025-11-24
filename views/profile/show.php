<?php $pageTitle = htmlspecialchars($user['username']) . ' - Perfil'; ?>
<?php include __DIR__ . '/../layouts/header.php'; ?>

<?php 
$followerModel = new Follower();
$followersCount = $followerModel->getFollowersCount($user['id']);
$followingCount = $followerModel->getFollowingCount($user['id']);
$isFollowing = false;

if (Session::isLoggedIn()) {
    $isFollowing = $followerModel->isFollowing(Session::getUserId(), $user['id']);
}
?>

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
                    <a href="/profile/<?php echo htmlspecialchars($user['username']); ?>/followers" class="stat" style="text-decoration: none; color: inherit;">
                        <span class="stat-value"><?php echo $followersCount; ?></span>
                        <span class="stat-label">Seguidores</span>
                    </a>
                    <a href="/profile/<?php echo htmlspecialchars($user['username']); ?>/following" class="stat" style="text-decoration: none; color: inherit;">
                        <span class="stat-value"><?php echo $followingCount; ?></span>
                        <span class="stat-label">Siguiendo</span>
                    </a>
                    <div class="stat">
                        <span class="stat-value"><?php echo $stats['likes']; ?></span>
                        <span class="stat-label">Likes Recibidos</span>
                    </div>
                </div>
                
                <div style="display: flex; gap: 1rem; margin-top: 1.5rem;">
                    <?php if (Session::isLoggedIn() && Session::getUserId() == $user['id']): ?>
                        <a href="/profile/edit" class="btn" style="background: rgba(255,255,255,0.2); backdrop-filter: blur(10px);">
                            <svg class="icon icon-text" aria-hidden="true"><use href="/assets/icons.svg#edit"></use></svg> Editar Perfil
                        </a>
                    <?php elseif (Session::isLoggedIn()): ?>
                        <button 
                            onclick="toggleFollow(<?php echo $user['id']; ?>, this)"
                            class="btn"
                            id="followBtn"
                            style="background: rgba(255,255,255,0.2); backdrop-filter: blur(10px);">
                            <?php echo $isFollowing ? '✓ Siguiendo' : '+ Seguir'; ?>
                        </button>
                        <button class="btn" onclick="openReportModalPublic('user', <?php echo $user['id']; ?>)" style="background: rgba(255,255,255,0.2); backdrop-filter: blur(10px);">
                            <svg class="icon icon-text" aria-hidden="true"><use href="/assets/icons.svg#flag"></use></svg> Reportar
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container" style="margin-top: 3rem;">
    <h2 style="margin-bottom: 2rem;"><svg class="icon icon-header" aria-hidden="true"><use href="/assets/icons.svg#newspaper"></use></svg> Publicaciones de <?php echo htmlspecialchars($user['username']); ?></h2>
    
    <?php if (empty($posts)): ?>
        <div class="empty-state" style="text-align: center; padding: 4rem 2rem;">
            <p style="font-size: 3rem;"><svg class="icon" aria-hidden="true"><use href="/assets/icons.svg#newspaper"></use></svg></p>
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
                                <span class="post-stat"><svg class="icon icon-text" aria-hidden="true"><use href="/assets/icons.svg#heart"></use></svg> <?php echo $post['likes_count']; ?></span>
                                <span class="post-stat"><svg class="icon icon-text" aria-hidden="true"><use href="/assets/icons.svg#comments"></use></svg> <?php echo $post['comments_count']; ?></span>
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

<script>
function toggleFollow(userId, button) {
    fetch(`/follow/${userId}`, {
        method: 'POST'
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const followersLink = document.querySelector('a[href*="/followers"] .stat-value');
            if (followersLink) {
                followersLink.textContent = data.followers_count;
            }
            
            if (data.is_following) {
                button.innerHTML = '✓ Siguiendo';
            } else {
                button.innerHTML = '+ Seguir';
            }
        } else {
            alert(data.message || 'Error');
            if (data.message && data.message.includes('iniciar sesión')) {
                window.location.href = '/login';
            }
        }
    })
    .catch(error => console.error('Error:', error));
}
</script>

<!-- Modal público para reportar usuario -->
<div id="reportModalPublic" class="modal">
    <div class="modal-content">
        <button class="modal-close" type="button" onclick="closeReportModalPublic()" title="Cerrar">&times;</button>
        <h2>Reportar usuario</h2>
        <form method="POST" action="/report" id="reportPublicFormProfile">
            <input type="hidden" name="reported_type" id="reportedType">
            <input type="hidden" name="reported_id" id="reportedId">
            <div class="form-group">
                <label for="reason">Razón:</label>
                <textarea name="reason" id="reportReason" rows="5" required></textarea>
            </div>
            <div style="display:flex; gap:1rem; margin-top:1rem;">
                <button type="submit" class="btn btn-primary">Enviar reporte</button>
                <button type="button" class="btn btn-secondary" onclick="closeReportModalPublic()">Cancelar</button>
            </div>
        </form>
    </div>
</div>

<script>
function openReportModalPublic(type, id) {
    // reuse same modal ids as posts view; ensure elements exist
    var rt = document.getElementById('reportedType');
    var rid = document.getElementById('reportedId');
    var rr = document.getElementById('reportReason');
    if (rt && rid && rr) {
        rt.value = type;
        rid.value = id;
        rr.value = '';
    }
    var modal = document.getElementById('reportModalPublic');
    if (modal) modal.style.display = 'flex';
}

function closeReportModalPublic() {
    var modal = document.getElementById('reportModalPublic');
    if (modal) modal.style.display = 'none';
}

// Cerrar modal al hacer clic fuera de él
document.addEventListener('DOMContentLoaded', function() {
    var modal = document.getElementById('reportModalPublic');
    if (modal) {
        modal.addEventListener('click', function(event) {
            if (event.target === modal) {
                closeReportModalPublic();
            }
        });
    }
});
</script>

<?php include __DIR__ . '/../layouts/footer.php'; ?>