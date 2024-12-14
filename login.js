document.addEventListener('DOMContentLoaded', () => {
    const loginForm = document.getElementById('login-form');
    const errorMessage = document.getElementById('error-message');

    loginForm.addEventListener('submit', async (event) => {
        event.preventDefault();

        const email = document.getElementById('email').value.trim();
        const password = document.getElementById('password').value.trim();

        if (!email || !password) {
            errorMessage.textContent = 'Please fill in both email and password.';
            errorMessage.style.display = 'block';
            return;
        }

        try {
            const response = await fetch('login.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `email=${encodeURIComponent(email)}&password=${encodeURIComponent(password)}`,
            });

            const data = await response.json();

            if (data.success) {
                window.location.href = 'dashboard.php'; // Redirect on successful login
            } else {
                errorMessage.textContent = data.error || 'Login failed. Please try again.';
                errorMessage.style.display = 'block';
            }
        } catch (error) {
            console.error('Error during login:', error);
            errorMessage.textContent = 'An unexpected error occurred. Please try again.';
            errorMessage.style.display = 'block';
        }
    });
});
