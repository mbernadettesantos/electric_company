document.addEventListener('DOMContentLoaded', function () {
    const toggle = document.getElementById('togglePassword');
    const password = document.getElementById('password');

    if (toggle && password) {
        toggle.addEventListener('click', function () {
            const visible = password.type === 'text';
            password.type = visible ? 'password' : 'text';
            toggle.innerHTML = visible
                ? '<i class="fas fa-eye"></i>'
                : '<i class="fas fa-eye-slash"></i>';
        });
    }
});
