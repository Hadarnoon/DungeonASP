function updateNavbar() {
    try {
        const currentUser = JSON.parse(localStorage.getItem('currentUser'));
        const authLinks = document.getElementById('authLinks');
        const userInfo = document.getElementById('userInfo');

        if (currentUser) {
            if (authLinks) authLinks.style.display = 'none';
            if (userInfo) {
                userInfo.style.display = 'flex';
                document.getElementById('loggedInUser').textContent = currentUser.username;
            }
        } else {
            if (authLinks) authLinks.style.display = 'flex';
            if (userInfo) userInfo.style.display = 'none';
        }
    } catch (error) {
        console.error('Navbar update error:', error);
    }
}

function logout() {
    localStorage.removeItem('currentUser');
    window.location.href = 'index.html';
}

function checkAuth() {
    const currentUser = JSON.parse(localStorage.getItem('currentUser'));
    const isProfilePage = window.location.pathname.includes('profile.html');

    if (isProfilePage && !currentUser) {
        window.location.href = 'login.html';
    }
}

document.addEventListener('DOMContentLoaded', () => {
    updateNavbar();
    checkAuth();

    if (!window.location.pathname.includes('login.html') &&
        !window.location.pathname.includes('register.html')) {
        const scoreboardLink = document.querySelector('a[href="scoreboard.html"]');
        if (scoreboardLink) scoreboardLink.style.display = 'block';
    }
});


window.updateNavbar = updateNavbar;
window.logout = logout;