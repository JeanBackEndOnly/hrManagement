const passwordInputs = document.getElementById('passwordInputs');
const showPasswords = document.getElementById('showPasswords');
const hidePasswords = document.getElementById('hidePasswords');

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
    
document.addEventListener('DOMContentLoaded', () => {
        if (signup) {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: 'Sign-up success!.',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                customClass: { popup: 'swal2-row-toast' }
            });
            removeUrlParams(['signup']);
        }else if (passwordChange) {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: 'Password Changed Successfully!.',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                customClass: { popup: 'swal2-row-toast' }
            });
            removeUrlParams(['passwordChange']);
        }else if (username) {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'error',
                title: 'Username not match, Try again!.',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                customClass: { popup: 'swal2-row-toast' }
            });
            removeUrlParams(['username']);
        }else if (passwordLogin) {
            console.log("Showing updateReq toast");
            Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'error',
            title: 'Wrong Password, please try again..!.',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            customClass: { popup: 'swal2-row-toast' }
            });
            removeUrlParams(['passwordLogin']);
        }

        function removeUrlParams(params) {
            const url = new URL(window.location);
            params.forEach(param => url.searchParams.delete(param));
            window.history.replaceState({}, document.title, url.toString());
        }
});