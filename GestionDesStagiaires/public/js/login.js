
const togglePassword = document.getElementById('togglePasswordVisibility');
const password = document.getElementById('password');

togglePassword.addEventListener('click', function() {
    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
    password.setAttribute('type', type);

    // Change the eye icon based on password visibility
    if (type === 'text') {
        togglePassword.querySelector('#eyeIcon').classList.add('hidden');
        togglePassword.querySelector('#eyeSlashIcon').classList.remove('hidden');
    } else {
        togglePassword.querySelector('#eyeIcon').classList.remove('hidden');
        togglePassword.querySelector('#eyeSlashIcon').classList.add('hidden');
    }
});
