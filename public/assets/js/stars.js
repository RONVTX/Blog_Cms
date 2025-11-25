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