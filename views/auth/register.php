<?php $pageTitle = 'Registrarse'; ?>
<?php include __DIR__ . '/../layouts/header.php'; ?>
<link rel="stylesheet" href="/assets/css/auth.css">

<div class="stars-bg" id="stars-container"></div>

<div class="form-container">
    <div class="login-card floating">
        <h1>Registrarse</h1>
        
        <?php if (isset($error)): ?>
            <div class="alert alert-error">
                <svg class="icon icon-text" aria-hidden="true"><use href="/assets/icons.svg#exclamation-circle"></use></svg>
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="/register" class="form">
            <div class="form-group">
                <label for="username">
                    <svg class="icon icon-text" aria-hidden="true"><use href="/assets/icons.svg#user"></use></svg> Nombre de Usuario
                </label>
                <input type="text" id="username" name="username" required 
                       placeholder="👤 Ingresa tu nombre de usuario" minlength="3">
            </div>

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
                       placeholder="Ingresa tu contraseña (mínimo 8 caracteres)" minlength="8">
            </div>

            <button type="submit" class="btn1 btn-primary1">
                <svg class="icon icon-text" aria-hidden="true"><use href="/assets/icons.svg#user-plus"></use></svg> Registrarse
            </button>
        </form>

        <p class="form-footer">
            ¿Ya tienes cuenta? 
            <a href="/login">
                <svg class="icon icon-text" aria-hidden="true"><use href="/assets/icons.svg#sign-in"></use></svg> Inicia sesión aquí
            </a>
        </p>
    </div>
</div>

<script src="/assets/js/stars.js"></script>

<?php include __DIR__ . '/../layouts/footer.php'; ?>