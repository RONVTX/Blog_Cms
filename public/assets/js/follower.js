function toggleFollow(userId, button) {
    fetch(`/follow/${userId}`, {
        method: 'POST'
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            if (data.is_following) {
                button.className = 'btn btn-outline';
                button.innerHTML = '✓ Siguiendo';
            } else {
                button.className = 'btn btn-primary';
                button.innerHTML = '+ Seguir';
            }
        } else {
            alert(data.message || 'Error');
            if (data.message && data.message.includes('iniciar sesión')) {
                window.location.href = '/login';
            }
        }
    })
    .catch(error => console.error('Error:', error));
}