function toggleFollow(userId, button) {
    fetch(`/follow/${userId}`, {
        method: 'POST'
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const followersLink = document.querySelector('a[href*="/followers"] .stat-value');
            if (followersLink) {
                followersLink.textContent = data.followers_count;
            }
            
            if (data.is_following) {
                button.innerHTML = '✓ Siguiendo';
            } else {
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
function openReportModalPublic(type, id) {
    // reuse same modal ids as posts view; ensure elements exist
    var rt = document.getElementById('reportedType');
    var rid = document.getElementById('reportedId');
    var rr = document.getElementById('reportReason');
    if (rt && rid && rr) {
        rt.value = type;
        rid.value = id;
        rr.value = '';
    }
    var modal = document.getElementById('reportModalPublic');
    if (modal) modal.style.display = 'flex';
}

function closeReportModalPublic() {
    var modal = document.getElementById('reportModalPublic');
    if (modal) modal.style.display = 'none';
}

// Cerrar modal al hacer clic fuera de él
document.addEventListener('DOMContentLoaded', function() {
    var modal = document.getElementById('reportModalPublic');
    if (modal) {
        modal.addEventListener('click', function(event) {
            if (event.target === modal) {
                closeReportModalPublic();
            }
        });
    }
});