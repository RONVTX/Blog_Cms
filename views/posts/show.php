<?php $pageTitle = htmlspecialchars($post['title']); ?>
<?php include __DIR__ . '/../layouts/header.php'; ?>

<article class="post-detail">
    <div class="post-header">
        <div class="container" style="max-width: 800px;">
            <?php 
            if (!empty($categories)): 
            ?>
                <div class="post-categories" style="margin-bottom: 1rem;">
                    <?php foreach ($categories as $category): ?>
                        <a href="/category/<?php echo htmlspecialchars($category['slug']); ?>" class="category-tag">
                            <?php echo htmlspecialchars($category['name']); ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            
            <h1 class="post-title"><?php echo htmlspecialchars($post['title']); ?></h1>
            
            <div class="post-meta" style="display: flex; align-items: center; gap: 1.5rem; margin-top: 1.5rem;">
                <a href="/profile/<?php echo htmlspecialchars($post['username']); ?>" style="display: flex; align-items: center; gap: 0.75rem; text-decoration: none; color: white;">
                    <?php if ($post['avatar']): ?>
                        <img src="/<?php echo htmlspecialchars($post['avatar']); ?>" 
                             alt="<?php echo htmlspecialchars($post['username']); ?>" 
                             style="width: 48px; height: 48px; border-radius: 50%; border: 2px solid white;">
                    <?php else: ?>
                        <span style="width: 48px; height: 48px; background: rgba(255,255,255,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 1.25rem;">
                            <?php echo strtoupper(substr($post['username'], 0, 1)); ?>
                        </span>
                    <?php endif; ?>
                    <div>
                            <div style="font-weight: 600;"><?php echo htmlspecialchars($post['username']); ?></div>
                        <div style="font-size: 0.875rem; opacity: 0.9;">
                            <svg class="icon icon-text" aria-hidden="true"><use href="/assets/icons.svg#calendar"></use></svg> <?php echo date('d/m/Y H:i', strtotime($post['created_at'])); ?>
                        </div>
                    </div>
                </a>
                <span><svg class="icon icon-text" aria-hidden="true"><use href="/assets/icons.svg#eye"></use></svg> <?php echo $post['views']; ?> vistas</span>
            </div>
        </div>
    </div>

    <?php if ($post['image']): ?>
        <img src="/<?php echo htmlspecialchars($post['image']); ?>" 
             alt="<?php echo htmlspecialchars($post['title']); ?>" 
             class="post-image">
    <?php endif; ?>
    
    <div class="post-interactions">
        <button 
            class="interaction-btn <?php echo $hasLiked ? 'active' : ''; ?>" 
            onclick="toggleLike(<?php echo $post['id']; ?>, this)">
            <svg class="icon icon-text" aria-hidden="true"><use href="/assets/icons.svg#heart"></use></svg>
            <span class="like-count"><?php echo $post['likes_count']; ?></span> Me gusta
        </button>
        
        <button class="interaction-btn" onclick="document.getElementById('comment-form').scrollIntoView({behavior: 'smooth'})">
            <svg class="icon icon-text" aria-hidden="true"><use href="/assets/icons.svg#comments"></use></svg> <?php echo $post['comments_count']; ?> Comentarios
        </button>
        
        <button 
            class="interaction-btn <?php echo $hasBookmarked ? 'active' : ''; ?>" 
            onclick="toggleBookmark(<?php echo $post['id']; ?>, this)">
            <svg class="icon icon-text" aria-hidden="true"><use href="/assets/icons.svg#bookmark"></use></svg>
            <?php echo $hasBookmarked ? 'Guardado' : 'Guardar'; ?>
        </button>
        
        <button class="interaction-btn" onclick="sharePost('<?php echo addslashes($post['title']); ?>', window.location.href)">
            <svg class="icon icon-text" aria-hidden="true"><use href="/assets/icons.svg#share"></use></svg> Compartir
        </button>
    </div>

    <div class="post-body">
        <div class="post-content" style="max-height: none; overflow: visible;">
            <?php echo nl2br(htmlspecialchars($post['content'])); ?>
        </div>
    </div>

    <?php if (Session::isLoggedIn() && Session::getUserId() == $post['user_id']): ?>
            <div style="padding: 1.5rem 2rem; border-top: 1px solid var(--border); display: flex; gap: 1rem;">
            <a href="/post/edit/<?php echo $post['id']; ?>" class="btn btn-primary"><svg class="icon icon-text" aria-hidden="true"><use href="/assets/icons.svg#edit"></use></svg> Editar</a>
            <form method="POST" action="/post/delete/<?php echo $post['id']; ?>" style="display: inline;" onsubmit="return confirm('¿Estás seguro de eliminar esta publicación?');">
                <button type="submit" class="btn btn-danger-outline btn-sm"><svg class="icon icon-text" aria-hidden="true"><use href="/assets/icons.svg#times-circle"></use></svg> Eliminar</button>
            </form>
        </div>
    <?php endif; ?>
    
    <div class="comments-section">
        <h3><svg class="icon icon-text" aria-hidden="true"><use href="/assets/icons.svg#comments"></use></svg> Comentarios (<?php echo count($comments); ?>)</h3>
        
        <?php if (Session::isLoggedIn()): ?>
            <form id="comment-form" class="comment-form" onsubmit="event.preventDefault(); submitComment(<?php echo $post['id']; ?>);">
                <textarea 
                    name="content" 
                    placeholder="Escribe tu comentario..." 
                    required></textarea>
                <button type="submit" class="btn btn-primary" style="margin-top: 1rem;">
                    <svg class="icon icon-text" aria-hidden="true"><use href="/assets/icons.svg#comments"></use></svg> Comentar
                </button>
            </form>
        <?php else: ?>
            <div style="text-align: center; padding: 2rem; background: var(--light); border-radius: 12px; margin-bottom: 2rem;">
                <p style="margin-bottom: 1rem;">Inicia sesión para comentar</p>
                <a href="/login" class="btn btn-primary">Iniciar Sesión</a>
            </div>
        <?php endif; ?>
        
                <?php if (empty($comments)): ?>
            <div style="text-align: center; padding: 3rem; color: var(--text-light);">
                <p style="font-size: 2rem;"><svg class="icon" aria-hidden="true"><use href="/assets/icons.svg#comments"></use></svg></p>
                <p>Aún no hay comentarios. ¡Sé el primero en comentar!</p>
            </div>
        <?php else: ?>
            <div class="comments-list">
                <?php foreach ($comments as $comment): ?>
                    <div class="comment">
                        <div class="comment-header">
                            <div class="comment-author">
                                <?php if ($comment['avatar']): ?>
                                    <img src="/<?php echo htmlspecialchars($comment['avatar']); ?>" 
                                         alt="<?php echo htmlspecialchars($comment['username']); ?>">
                                <?php else: ?>
                                    <span style="width: 40px; height: 40px; background: var(--gradient); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: 700;">
                                        <?php echo strtoupper(substr($comment['username'], 0, 1)); ?>
                                    </span>
                                <?php endif; ?>
                                <div class="comment-info">
                                    <h4><?php echo htmlspecialchars($comment['username']); ?></h4>
                                    <span class="comment-time">
                                        <?php 
                                        $time = strtotime($comment['created_at']);
                                        $diff = time() - $time;
                                        if ($diff < 60) {
                                            echo 'Hace un momento';
                                        } elseif ($diff < 3600) {
                                            echo 'Hace ' . floor($diff / 60) . ' minutos';
                                        } elseif ($diff < 86400) {
                                            echo 'Hace ' . floor($diff / 3600) . ' horas';
                                        } else {
                                            echo date('d/m/Y H:i', $time);
                                        }
                                        ?>
                                    </span>
                                </div>
                            </div>
                            
                            <div style="display: flex; gap: 0.5rem;">
                                <?php if (Session::isLoggedIn() && Session::getUserId() == $comment['user_id']): ?>
                                    <form method="POST" action="/comment/delete/<?php echo $comment['id']; ?>" style="display: inline;" onsubmit="return confirm('¿Eliminar este comentario?');">
                                        <button type="submit" class="btn btn-danger-outline btn-sm"><svg class="icon icon-text" aria-hidden="true"><use href="/assets/icons.svg#times-circle"></use></svg></button>
                                    </form>
                                <?php endif; ?>
                                <button type="button" class="btn btn-outline btn-sm" onclick="openReportModalPublic('comment', <?php echo $comment['id']; ?>)"><svg class="icon icon-text" aria-hidden="true"><use href="/assets/icons.svg#flag"></use></svg> Reportar</button>
                            </div>
                        </div>
                        <div class="comment-content">
                            <?php echo nl2br(htmlspecialchars($comment['content'])); ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <div style="padding: 2rem; text-align: center;">
        <a href="/" class="btn btn-outline">← Volver al inicio</a>
    </div>
</article>

<script src="/assets/js/main.js"></script>
<!-- Modal público para reportar -->
<div id="reportModalPublic" class="modal">
    <div class="modal-content">
        <button class="modal-close" type="button" onclick="closeReportModalPublic()" title="Cerrar">&times;</button>
        <h2>Reportar contenido</h2>
        <form method="POST" action="/report" id="reportPublicForm">
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
    document.getElementById('reportedType').value = type;
    document.getElementById('reportedId').value = id;
    document.getElementById('reportReason').value = '';
    document.getElementById('reportModalPublic').style.display = 'flex';
}

function closeReportModalPublic() {
    document.getElementById('reportModalPublic').style.display = 'none';
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