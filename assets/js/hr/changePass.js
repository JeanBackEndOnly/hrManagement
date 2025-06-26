


const passwordInputs = document.getElementById('passInput');
const showPasswords = document.getElementById('showPasswords');
const hidePasswords = document.getElementById('hidePasswords');

const confirmPasswordInputs = document.getElementById('chInput');
const showConfirmPasswords = document.getElementById('showConfirmPasswords');
const hideConfirmPasswords = document.getElementById('hideConfirmPasswords');

    showPasswords.addEventListener('click', () => {
        passwordInputs.type = 'text';
        showPasswords.style.display = 'none';
        hidePasswords.style.display = 'inline';
    });

    hidePasswords.addEventListener('click', () => {
        passwordInputs.type = 'password';
        showPasswords.style.display = 'inline';
        hidePasswords.style.display = 'none';
    });

    showConfirmPasswords.addEventListener('click', () => {
        confirmPasswordInputs.type = 'text';
        showConfirmPasswords.style.display = 'none';
        hideConfirmPasswords.style.display = 'inline';
    });

    hideConfirmPasswords.addEventListener('click', () => {
        confirmPasswordInputs.type = 'password';
        showConfirmPasswords.style.display = 'inline';
        hideConfirmPasswords.style.display = 'none';
    });

