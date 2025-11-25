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

<script src="/assets/js/admin.js"></script>

<link rel="stylesheet" href="/assets/css/reportadmin.css">
<?php include __DIR__ . '/../layouts/admin-footer.php'; ?>