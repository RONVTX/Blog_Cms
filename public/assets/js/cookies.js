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