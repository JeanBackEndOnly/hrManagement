document.addEventListener('DOMContentLoaded', () => {
        if (passwordAuthFailes) {
            console.log("Showing updateReq toast");
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
            removeUrlParams(['passwordAuthFailes']);
        }else if (username) {
            console.log("Showing updateReq toast");
            Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: 'Username matched! Enter the Code and change Password.',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            customClass: { popup: 'swal2-row-toast' }
            });
            removeUrlParams(['username']);
        }else if (code) {
            console.log("Showing updateReq toast");
            Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'error',
            title: 'Code not match!.',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            customClass: { popup: 'swal2-row-toast' }
            });
            removeUrlParams(['code']);
        }if (passwordAuthFailes) {
            console.log("Showing updateReq toast");
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
            removeUrlParams(['passwordAuthFailes']);
        }else if (passwordChange) {
            console.log("Showing updateReq toast");
            Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: 'Password Change Successfully!.',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            customClass: { popup: 'swal2-row-toast' }
            });
            removeUrlParams(['passwordChange']);
        }
        function removeUrlParams(params) {
            const url = new URL(window.location);
            params.forEach(param => url.searchParams.delete(param));
            window.history.replaceState({}, document.title, url.toString());
        }
});
document.addEventListener("DOMContentLoaded", function () {

        const passwordInputCurrents = document.getElementById('passwordInputCurrents');
        const showPasswordCurrents = document.getElementById('showPasswordCurrents');
        const hidePasswordCurrents = document.getElementById('hidePasswordCurrents');

        const passwordInputs = document.getElementById('passwordInputs');
        const showPasswords = document.getElementById('showPasswords');
        const hidePasswords = document.getElementById('hidePasswords');

        const confirmPasswordInputs = document.getElementById('confirmPasswordInputs');
        const showConfirmPasswords = document.getElementById('showConfirmPasswords');
        const hideConfirmPasswords = document.getElementById('hideConfirmPasswords');

        if (showPasswordCurrents && hidePasswordCurrents && passwordInputCurrents) {
            showPasswordCurrents.addEventListener('click', () => {
                passwordInputCurrents.type = 'text';
                showPasswordCurrents.style.display = 'none';
                hidePasswordCurrents.style.display = 'inline';
            });

            hidePasswordCurrents.addEventListener('click', () => {
                passwordInputCurrents.type = 'password';
                showPasswordCurrents.style.display = 'inline';
                hidePasswordCurrents.style.display = 'none';
            });
        }

        if (showPasswords && hidePasswords && passwordInputs) {
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
        }

        if (showConfirmPasswords && hideConfirmPasswords && confirmPasswordInputs) {
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
        }
});
function activateTab(clickedBtn) {
    document.querySelectorAll(".historyPass").forEach(btn => {
        btn.classList.remove("active");
    });
    clickedBtn.classList.add("active");
}
window.addEventListener('DOMContentLoaded', () => {
    changePass(); 
});

function showSection(visibleIds) {
    const allSections = [
        "changePAsswordID",
        "loginHisotryID"  
    ];

    allSections.forEach(id => {
        const el = document.getElementById(id);
        if (el) {
            el.style.display = visibleIds.includes(id) ? 'flex' : 'none';
        }
    });
}

function showLoading() {
    const loading = document.getElementById("loadingAnimation");
    loading.style.display = "flex";
}

function hideLoading() {
    const loading = document.getElementById("loadingAnimation");
    loading.style.display = "none";
}

function changePass() {
    showLoadingAndRun(() => {
        console.log("Change Password tab action triggered.");
        activateTab(document.getElementById("idChangePass")); 
        document.getElementById("idLoginHistory").classList.remove("active");
    }, ["changePAsswordID"]); 
}

function loginHistory() {
    showLoadingAndRun(() => {
        console.log("Login History tab action triggered.");
        activateTab(document.getElementById("idLoginHistory")); 
        document.getElementById("idChangePass").classList.remove("active");
    }, ["loginHisotryID"]);
}

function showLoadingAndRun(callback, visibleIds = []) {
    const loadingEl = document.getElementById("loadingAnimationSettings");
    console.log("Loader shown");

    showSection([]); 
    loadingEl.style.display = "flex"; 

    setTimeout(() => {
        try {
            callback(); 
            console.log("Callback done");
        } catch (err) {
            console.error("Error in callback:", err);
        }

        loadingEl.style.display = "none"; 
        console.log("Loader hidden");

        showSection(visibleIds); 
    }, 500);
}
