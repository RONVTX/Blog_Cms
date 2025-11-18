<?php $pageTitle = 'Iniciar Sesión'; ?>
<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="form-container">
    <h1>Iniciar Sesión</h1>
    
    <?php if (isset($error)): ?>
        <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form method="POST" action="/login" class="form">
        <div class="form-group">
            <label for="email">Correo Electrónico:</label>
            <input type="email" id="email" name="email" required>
        </div>

        <div class="form-group">
            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" required>
        </div>

        <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
    </form>

    <p class="form-footer">¿No tienes cuenta? <a href="/register">Regístrate aquí</a></p>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>