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

document.addEventListener('DOMContentLoaded', updateNavbar);

window.updateNavbar = updateNavbar;
window.logout = logout;