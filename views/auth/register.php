<?php $pageTitle = 'Registrarse'; ?>
<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="form-container">
    <h1>Registrarse</h1>
    
    <?php if (isset($error)): ?>
        <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form method="POST" action="/register" class="form">
        <div class="form-group">
            <label for="username">Nombre de Usuario:</label>
            <input type="text" id="username" name="username" required minlength="3">
        </div>

        <div class="form-group">
            <label for="email">Correo Electrónico:</label>
            <input type="email" id="email" name="email" required>
        </div>

        <div class="form-group">
            <label for="password">Contraseña (mínimo 8 caracteres):</label>
            <input type="password" id="password" name="password" required minlength="8">
        </div>

        <button type="submit" class="btn btn-primary">Registrarse</button>
    </form>

    <p class="form-footer">¿Ya tienes cuenta? <a href="/login">Inicia sesión aquí</a></p>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>