<?php $pageTitle = 'Preferencias de Cookies'; ?>
<?php include __DIR__ . '/layouts/header.php'; ?>

<div class="form-container">
    <h1>Preferencias de Cookies</h1>
    <p>Gestiona tu consentimiento para el uso de cookies en este sitio.</p>

    <?php if ($message = Session::flash('success')): ?>
        <div class="alert alert-success"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>

    <form method="POST" action="/cookies">
        <div class="form-group">
            <label>Estado actual: <strong><?php echo htmlspecialchars($consent ?? 'no definido'); ?></strong></label>
        </div>

        <div class="form-group">
            <label>Selecciona tu preferencia:</label>
            <div style="display:flex; gap:0.75rem;">
                <label class="btn btn-outline" style="display:inline-flex; align-items:center;">
                    <input type="radio" name="cookie_consent" value="accepted" style="margin-right:0.5rem;" <?php echo ($consent === 'accepted') ? 'checked' : ''; ?>>Aceptar
                </label>
                <label class="btn btn-secondary" style="display:inline-flex; align-items:center;">
                    <input type="radio" name="cookie_consent" value="declined" style="margin-right:0.5rem;" <?php echo ($consent === 'declined') ? 'checked' : ''; ?>>Rechazar
                </label>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Guardar preferencia</button>
            <a href="/" class="btn btn-outline">Cancelar</a>
        </div>
    </form>
</div>

<?php include __DIR__ . '/layouts/footer.php'; ?>
