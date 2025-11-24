<?php $pageTitle = 'Gestión de Reportes'; ?>
<?php include __DIR__ . '/../layouts/admin-header.php'; ?>

<div class="admin-header">
    <h1><svg class="icon icon-header" aria-hidden="true"><use href="/assets/icons.svg#flag"></use></svg> Gestión de Reportes</h1>
    <p>Revisa y gestiona los reportes de usuarios</p>
</div>

<div class="admin-card">
    <div class="table-responsive">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Reportado por</th>
                    <th>Tipo</th>
                    <th>Razón</th>
                    <th>Estado</th>
                    <th>Fecha</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reports as $report): ?>
                <?php
                    $targetLabel = '';
                    $targetLink = '#';

                    if ($report['reported_type'] === 'post') {
                        $postModel = new Post();
                        $target = $postModel->findById($report['reported_id']);
                        if ($target) {
                            $targetLabel = $target['title'];
                            $targetLink = '/blog/' . $target['slug'];
                        } else {
                            $targetLabel = 'Post eliminado';
                        }
                    } elseif ($report['reported_type'] === 'comment') {
                        $commentModel = new Comment();
                        $c = $commentModel->findById($report['reported_id']);
                        if ($c) {
                            $postModel = new Post();
                            $p = $postModel->findById($c['post_id']);
                            $postTitle = $p ? $p['title'] : 'Publicación';
                            $targetLabel = 'Comentario en: ' . $postTitle;
                            $targetLink = $p ? '/blog/' . $p['slug'] . '#comment-' . $c['id'] : '#';
                        } else {
                            $targetLabel = 'Comentario eliminado';
                        }
                    } else {
                        $userModel = new User();
                        $u = $userModel->findById($report['reported_id']);
                        if ($u) {
                            $targetLabel = $u['username'];
                            $targetLink = '/profile/' . $u['username'];
                        } else {
                            $targetLabel = 'Usuario eliminado';
                        }
                    }
                ?>
                <tr>
                    <td><?php echo $report['id']; ?></td>
                    <td><?php echo htmlspecialchars($report['reporter_username']); ?></td>
                    <td>
                        <span class="status-badge">
                            <?php echo $report['reported_type'] === 'post' ? '<svg class="icon icon-text" aria-hidden="true"><use href="/assets/icons.svg#newspaper"></use></svg> Post' : ($report['reported_type'] === 'comment' ? '<svg class="icon icon-text" aria-hidden="true"><use href="/assets/icons.svg#comments"></use></svg> Comentario' : '<svg class="icon icon-text" aria-hidden="true"><use href="/assets/icons.svg#user"></use></svg> Usuario'); ?>
                        </span>
                    </td>
                    <td><?php echo htmlspecialchars(substr($report['reason'], 0, 100)); ?>...</td>
                    <td>
                        <span class="status-badge <?php echo $report['status']; ?>">
                            <?php echo ucfirst($report['status']); ?>
                        </span>
                    </td>
                    <td><?php echo date('d/m/Y H:i', strtotime($report['created_at'])); ?></td>
                    <td>
                        <button 
                            onclick="openReportModal(<?php echo $report['id']; ?>, this)" 
                            class="action-btn action-btn-primary action-btn-sm"
                            data-reason="<?php echo htmlspecialchars($report['reason'], ENT_QUOTES); ?>"
                            data-reported-type="<?php echo $report['reported_type']; ?>"
                            data-reported-id="<?php echo $report['reported_id']; ?>"
                            data-target-label="<?php echo htmlspecialchars($targetLabel, ENT_QUOTES); ?>"
                            data-target-link="<?php echo htmlspecialchars($targetLink, ENT_QUOTES); ?>"
                            data-reporter="<?php echo htmlspecialchars($report['reporter_username'], ENT_QUOTES); ?>"
                            data-status="<?php echo $report['status']; ?>"
                        >
                                <svg class="icon icon-text" aria-hidden="true"><use href="/assets/icons.svg#eye"></use></svg> Ver
                        </button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal para gestionar reporte -->
<div id="reportModal" class="modal" style="display: none;">
    <div class="modal-content">
        <span class="modal-close" onclick="closeReportModal()">&times;</span>
        <h2>Gestionar Reporte</h2>

        <div class="report-details" style="margin-bottom: 1rem;">
            <p><strong>Reportado por:</strong> <span id="modalReporter"></span></p>
            <p><strong>Objetivo:</strong> <a href="#" id="modalTargetLink" target="_blank" rel="noopener noreferrer"><span id="modalTargetLabel"></span></a></p>
            <p><strong>Razón:</strong><br><span id="modalReason" style="white-space: pre-wrap;"></span></p>
        </div>

        <form method="POST" action="/admin/reports/status" id="reportForm">
            <input type="hidden" name="report_id" id="reportId">
            
            <div class="admin-form-group">
                <label>Estado:</label>
                <select name="status" id="reportStatus" required>
                    <option value="pending">Pendiente</option>
                    <option value="reviewing">En revisión</option>
                    <option value="resolved">Resuelto</option>
                    <option value="dismissed">Desestimado</option>
                </select>
            </div>
            
            <div class="admin-form-group">
                <label>Notas del Admin:</label>
                <textarea name="admin_notes" id="adminNotes" rows="4"></textarea>
            </div>
            
            <button type="submit" class="action-btn action-btn-primary">Actualizar</button>
        </form>
    </div>
</div>

<script>
function openReportModal(reportId, btn) {
    document.getElementById('reportId').value = reportId;

    // populate modal fields from button data attributes
    if (btn) {
        var reporter = btn.getAttribute('data-reporter') || '';
        var targetLabel = btn.getAttribute('data-target-label') || '';
        var targetLink = btn.getAttribute('data-target-link') || '#';
        var reason = btn.getAttribute('data-reason') || '';
        var status = btn.getAttribute('data-status') || 'pending';

        document.getElementById('modalReporter').textContent = reporter;
        document.getElementById('modalTargetLabel').textContent = targetLabel;
        var tlink = document.getElementById('modalTargetLink');
        tlink.href = targetLink;
        document.getElementById('modalReason').textContent = reason;
        document.getElementById('reportStatus').value = status;
    }

    document.getElementById('reportModal').style.display = 'flex';
}

function closeReportModal() {
    document.getElementById('reportModal').style.display = 'none';
}
</script>

<style>
.modal {
    display: none !important;
    position: fixed;
    z-index: 2000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    align-items: center;
    justify-content: center;
}

.modal[style*="display: flex"] {
    display: flex !important;
}

.modal-content {
    background: white;
    padding: 2rem;
    border-radius: 12px;
    max-width: 500px;
    width: 90%;
    position: relative;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    max-height: 90vh;
    overflow-y: auto;
}

.modal-close {
    position: absolute;
    top: 1rem;
    right: 1rem;
    font-size: 1.75rem;
    cursor: pointer;
    color: #94a3b8;
    border: none;
    background: none;
    padding: 0.25rem;
    width: 2rem;
    height: 2rem;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s;
}

.modal-close:hover {
    color: #1e293b;
    transform: scale(1.2);
}
</style>

<?php include __DIR__ . '/../layouts/admin-footer.php'; ?>