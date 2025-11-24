<?php $pageTitle = 'Iniciar Sesión'; ?>
<?php include __DIR__ . '/../layouts/header.php'; ?>

<style>
    body, html {
        margin: 0;
        padding: 0;
        height: 100%;
        overflow-x: hidden;
    }

    .stars-bg {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: -1;
        background: linear-gradient(rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.9));
    }

    .star {
        position: absolute;
        background: white;
        border-radius: 50%;
        animation: twinkle var(--duration, 4s) infinite ease-in-out;
        opacity: 0;
    }

    @keyframes twinkle {
        0%, 100% { opacity: 0; }
        50% { opacity: 1; }
    }

    .form-container {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
        position: relative;
        z-index: 1;
    }

    .login-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        padding: 40px;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
        width: 100%;
        max-width: 450px;
        border: 1px solid rgba(255, 255, 255, 0.2);
        transform: translateY(0);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .login-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 45px rgba(0, 0, 0, 0.3);
    }

    .login-card h1 {
        text-align: center;
        color: #7e57c2;
        margin-bottom: 30px;
        font-size: 2.2em;
        font-weight: 600;
        background: linear-gradient(45deg, #7e57c2, #9c27b0);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        text-shadow: 0 0 10px rgba(126, 87, 194, 0.3);
    }

    .alert {
        padding: 15px;
        margin-bottom: 25px;
        border-radius: 10px;
        font-weight: 500;
        text-align: center;
        animation: fadeIn 0.5s ease;
    }

    .alert-error {
        background: linear-gradient(45deg, #ff6b6b, #ee5a52);
        color: white;
        border: 1px solid rgba(255, 255, 255, 0.3);
    }

    .form {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
    }

    .form-group label {
        margin-bottom: 8px;
        font-weight: 500;
        color: #7e57c2;
        font-size: 1.1em;
    }

    .form-group input {
        padding: 15px;
        border: 2px solid #e1e8ed;
        border-radius: 12px;
        font-size: 1em;
        transition: all 0.3s ease;
        background: rgba(255, 255, 255, 0.8);
    }

    .form-group input:focus {
        outline: none;
        border-color: #7e57c2;
        box-shadow: 0 0 0 3px rgba(126, 87, 194, 0.2);
        background: white;
    }

    .btn {
        padding: 15px 30px;
        border: none;
        border-radius: 12px;
        font-size: 1.1em;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .btn-primary {
        background: linear-gradient(45deg, #7e57c2, #9c27b0);
        color: white;
        box-shadow: 0 4px 15px rgba(126, 87, 194, 0.3);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(126, 87, 194, 0.4);
        background: linear-gradient(45deg, #9c27b0, #7e57c2);
    }

    .btn-primary:active {
        transform: translateY(0);
    }

    .form-footer {
        text-align: center;
        margin-top: 25px;
        color: #7f8c8d;
        font-size: 1em;
    }

    .form-footer a {
        color: #7e57c2;
        text-decoration: none;
        font-weight: 600;
        transition: color 0.3s ease;
    }

    .form-footer a:hover {
        color: #9c27b0;
        text-decoration: underline;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .floating {
        animation: floating 6s ease-in-out infinite;
    }

    @keyframes floating {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
    }

    @media (max-width: 768px) {
        .login-card {
            margin: 20px;
            padding: 30px 20px;
        }
        
        .login-card h1 {
            font-size: 1.8em;
        }
    }
</style>

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

            <button type="submit" class="btn btn-primary">
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

<script>
    // Crear estrellas
    function createStars() {
        const starsContainer = document.getElementById('stars-container');
        const starCount = 150;
        
        for (let i = 0; i < starCount; i++) {
            const star = document.createElement('div');
            star.className = 'star';
            
            // Posición aleatoria
            star.style.left = Math.random() * 100 + 'vw';
            star.style.top = Math.random() * 100 + 'vh';
            
            // Tamaño aleatorio
            const size = Math.random() * 3 + 1;
            star.style.width = size + 'px';
            star.style.height = size + 'px';
            
            // Duración aleatoria de la animación
            star.style.setProperty('--duration', (Math.random() * 5 + 2) + 's');
            
            // Retraso aleatorio
            star.style.animationDelay = Math.random() * 5 + 's';
            
            starsContainer.appendChild(star);
        }
    }

    // Inicializar estrellas
    createStars();

    // Añadir efectos de hover a los inputs
    document.querySelectorAll('.form-group input').forEach(input => {
        input.addEventListener('focus', function() {
            this.style.transform = 'scale(1.02)';
        });
        input.addEventListener('blur', function() {
            this.style.transform = 'scale(1)';
        });
    });
</script>

<?php include __DIR__ . '/../layouts/footer.php'; ?>