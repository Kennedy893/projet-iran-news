document.addEventListener('DOMContentLoaded', function () {
    var toggleButton = document.getElementById('toggle-password');
    var passwordInput = document.getElementById('password');

    if (!toggleButton || !passwordInput) {
        return;
    }

    toggleButton.addEventListener('click', function () {
        var shouldShow = passwordInput.type === 'password';
        passwordInput.type = shouldShow ? 'text' : 'password';
        toggleButton.textContent = shouldShow ? 'Masquer' : 'Afficher';
    });
});
