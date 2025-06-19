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
function PasswordForgot(){
    
}