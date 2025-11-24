// Delete confirmation modal
function showDeleteConfirm(message, form) {
    const overlay = document.getElementById('delete-modal-overlay');
    const modalMessage = document.getElementById('delete-modal-message');
    const deleteBtn = document.getElementById('delete-modal-confirm');
    
    if (!overlay) {
        console.error('Modal overlay not found');
        return confirm(message);
    }
    
    modalMessage.textContent = message;
    overlay.classList.add('active');
    
    deleteBtn.onclick = () => {
        overlay.classList.remove('active');
        form.submit();
    };
    
    return false;
}

function closeDeleteModal() {
    const overlay = document.getElementById('delete-modal-overlay');
    overlay.classList.remove('active');
}

// Confirmación de eliminación
document.addEventListener('DOMContentLoaded', function() {
    // Auto-hide alerts después de 5 segundos
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.opacity = '0';
            alert.style.transform = 'translateY(-10px)';
            setTimeout(() => alert.remove(), 300);
        }, 5000);
    });

    // Preview de imagen antes de subir
    const imageInputs = document.querySelectorAll('input[type="file"][accept*="image"]');
    imageInputs.forEach(input => {
        input.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    let preview = document.querySelector('.image-preview');
                    if (!preview) {
                        preview = document.createElement('img');
                        preview.className = 'image-preview current-image';
                        input.parentElement.appendChild(preview);
                    }
                    preview.src = event.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    });
});
// Auto-hide alerts
document.addEventListener('DOMContentLoaded', function() {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.opacity = '0';
            alert.style.transform = 'translateY(-10px)';
            setTimeout(() => alert.remove(), 300);
        }, 5000);
    });

    // Preview de imagen
    const imageInputs = document.querySelectorAll('input[type="file"][accept*="image"]');
    imageInputs.forEach(input => {
        input.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    let preview = document.querySelector('.image-preview');
                    if (!preview) {
                        preview = document.createElement('img');
                        preview.className = 'image-preview current-image';
                        input.parentElement.appendChild(preview);
                    }
                    preview.src = event.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    });
});

// Like functionality
function toggleLike(postId, button) {
    fetch(`/like/${postId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const countSpan = button.querySelector('.like-count');
            if (countSpan) {
                countSpan.textContent = data.likes_count;
            }
            
            if (data.has_liked) {
                button.classList.add('active');
                button.innerHTML = `<i class="fas fa-heart"></i> <span class="like-count">${data.likes_count}</span> Me gusta`;
            } else {
                button.classList.remove('active');
                button.innerHTML = `<i class="far fa-heart"></i> <span class="like-count">${data.likes_count}</span> Me gusta`;
            }
            // Replace any <i class="fa-..."> placeholders with inline SVG and animate
            if (window.replaceIcons) {
                window.replaceIcons(button);
                // add a pulse animation to the heart svg when liked
                const svg = button.querySelector('svg.icon');
                if (svg) {
                    svg.classList.remove('pulse');
                    // trigger reflow
                    void svg.offsetWidth;
                    if (data.has_liked) svg.classList.add('pulse');
                }
            }
        } else {
            if (data.message) {
                alert(data.message);
                window.location.href = '/login';
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

// Bookmark functionality
function toggleBookmark(postId, button) {
    fetch(`/bookmark/${postId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            if (data.has_bookmarked) {
                button.classList.add('active');
                button.innerHTML = '<i class="fas fa-bookmark"></i> Guardado';
            } else {
                button.classList.remove('active');
                button.innerHTML = '<i class="far fa-bookmark"></i> Guardar';
            }
            if (window.replaceIcons) {
                window.replaceIcons(button);
                const svg = button.querySelector('svg.icon');
                if (svg) {
                    svg.classList.remove('pulse');
                    void svg.offsetWidth;
                    if (data.has_bookmarked) svg.classList.add('pulse');
                }
            }
        } else {
            if (data.message) {
                alert(data.message);
                window.location.href = '/login';
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

// Comment functionality
function submitComment(postId) {
    const form = document.getElementById('comment-form');
    const textarea = form.querySelector('textarea');
    const content = textarea.value.trim();
    
    if (!content) {
        alert('Por favor escribe un comentario');
        return;
    }
    
    const formData = new FormData();
    formData.append('content', content);
    
    fetch(`/comment/${postId}`, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Recargar la página para mostrar el nuevo comentario
            window.location.reload();
        } else {
            alert(data.message || 'Error al agregar comentario');
            if (data.message && data.message.includes('iniciar sesión')) {
                window.location.href = '/login';
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al enviar el comentario');
    });
}

// Share functionality
function sharePost(title, url) {
    if (navigator.share) {
        navigator.share({
            title: title,
            url: url
        }).catch(error => console.log('Error sharing:', error));
    } else {
        // Fallback: copiar al portapapeles
        navigator.clipboard.writeText(url).then(() => {
            alert('¡Enlace copiado al portapapeles!');
        });
    }
}



