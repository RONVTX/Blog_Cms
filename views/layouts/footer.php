</main>
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3><?php echo APP_NAME; ?></h3>
                    <p>Plataforma de gestión de contenido con PHP POO, PDO y arquitectura MVC</p>
                </div>
                
                <div class="footer-section">
                    <h4>Enlaces Rápidos</h4>
                    <ul>
                        <li><a href="/">Inicio</a></li>
                        <li><a href="/posts">Publicaciones</a></li>
                        <li><a href="/about">Acerca de</a></li>
                        <li><a href="/contact">Contacto</a></li>
                    </ul>
                </div>
                
                <div class="footer-section">
                    <h4>Síguenos</h4>
                    <div class="social-links">
                        <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                        <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                        <a href="#" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; <?php echo date('Y'); ?> <?php echo APP_NAME; ?>. Todos los derechos reservados.</p>
                <div class="footer-links">
                    <a href="/privacy">Privacidad</a>
                    <a href="/terms">Términos</a>
                    <a href="/cookies">Cookies</a>
                </div>
            </div>
        </div>
    </footer>
    <!-- Cookie consent banner -->
    <div id="cookieBanner" class="cookie-banner" style="display: none;" aria-live="polite">
        <div class="cookie-banner-inner">
            <div class="cookie-text">
                <strong>Usamos cookies</strong>
                <p>Este sitio utiliza cookies para mejorar la experiencia. Puedes aceptar o rechazar su uso.</p>
            </div>
            <div class="cookie-actions">
                <a href="/cookies" class="btn btn-outline">Política</a>
                <button id="cookieDecline" class="btn btn-secondary">Rechazar</button>
                <button id="cookieAccept" class="btn btn-primary">Aceptar</button>
            </div>
        </div>
    </div>

    <script>
    (function() {
        function getCookie(name) {
            const value = `; ${document.cookie}`;
            const parts = value.split(`; ${name}=`);
            if (parts.length === 2) return parts.pop().split(';').shift();
        }

        function setCookie(name, value, days) {
            let expires = '';
            if (days) {
                const date = new Date();
                date.setTime(date.getTime() + (days*24*60*60*1000));
                expires = '; expires=' + date.toUTCString();
            }
            document.cookie = name + '=' + (value || '')  + expires + '; path=/; samesite=Lax';
        }

        var banner = document.getElementById('cookieBanner');
        var accepted = getCookie('cookie_consent');
        if (!accepted) {
            banner.style.display = 'block';
        }

        var acceptBtn = document.getElementById('cookieAccept');
        var declineBtn = document.getElementById('cookieDecline');

        if (acceptBtn) acceptBtn.addEventListener('click', function() {
            setCookie('cookie_consent', 'accepted', 365);
            banner.style.display = 'none';
        });

        if (declineBtn) declineBtn.addEventListener('click', function() {
            setCookie('cookie_consent', 'declined', 365);
            banner.style.display = 'none';
        });
    })();
    </script>

    <script src="/assets/js/main.js"></script>
    <script src="/assets/js/icons-replace.js"></script>
    <!-- Delete confirmation modal (global) -->
    <div id="delete-modal-overlay" class="delete-modal-overlay" role="dialog" aria-modal="true" aria-hidden="true">
        <div class="delete-modal" role="document">
            <div class="delete-modal-icon">
                <svg class="icon" aria-hidden="true"><use href="/assets/icons.svg#times-circle"></use></svg>
            </div>
            <h3>Confirmar eliminación</h3>
            <p id="delete-modal-message">¿Estás seguro de eliminar este elemento?</p>
            <div class="delete-modal-actions">
                <button type="button" class="btn-cancel btn" onclick="closeDeleteModal()">Cancelar</button>
                <button id="delete-modal-confirm" type="button" class="btn-delete btn">Eliminar</button>
            </div>
        </div>
    </div>
</body>
</html>