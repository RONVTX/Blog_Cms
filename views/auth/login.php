<?php $pageTitle = 'Iniciar Sesión'; ?>
<?php include __DIR__ . '/../layouts/header.php'; ?>
<link rel="stylesheet" href="/assets/css/auth.css">
<div class="stars-bg" id="stars-container"></div>

<div class="form-container">
    <div class="login-card floating">
        <h1>Iniciar Sesión</h1>
        
        <?php if (isset($error)): ?>
            <div class="alert alert-error">
                <svg class="icon icon-text" aria-hidden="true"><use href="/assets/icons.svg#exclamation-circle"></use></svg>
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="/login" class="form">
            <div class="form-group">
                <label for="email">
                    <svg class="icon icon-text" aria-hidden="true"><use href="/assets/icons.svg#envelope"></use></svg> Correo Electrónico
                </label>
                <input type="email" id="email" name="email" required 
                       placeholder="📧 Ingresa tu correo electrónico">
            </div>

            <div class="form-group">
                <label for="password">
                    <svg class="icon icon-text" aria-hidden="true"><use href="/assets/icons.svg#lock"></use></svg> Contraseña
                </label>
                <input type="password" id="password" name="password" required 
                       placeholder="Ingresa tu contraseña">
            </div>

            <button type="submit" class="btn1 btn-primary1">
                <svg class="icon icon-text" aria-hidden="true"><use href="/assets/icons.svg#sign-in"></use></svg> Iniciar Sesión
            </button>
        </form>

        <p class="form-footer">
            ¿No tienes cuenta? 
            <a href="/register">
                <svg class="icon icon-text" aria-hidden="true"><use href="/assets/icons.svg#user-plus"></use></svg> Regístrate aquí
            </a>
        </p>
    </div>
</div>

<script src="/assets/js/stars.js"></script>

<?php include __DIR__ . '/../layouts/footer.php'; ?>