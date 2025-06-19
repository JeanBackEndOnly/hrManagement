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
        "changePAsswordID", // content div
        "loginHisotryID"    // content div
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
        activateTab(document.getElementById("idChangePass")); // ✅ correct tab
        document.getElementById("idLoginHistory").classList.remove("active");
    }, ["changePAsswordID"]); // ✅ show password section
}

function loginHistory() {
    showLoadingAndRun(() => {
        console.log("Login History tab action triggered.");
        activateTab(document.getElementById("idLoginHistory")); // ✅ correct tab
        document.getElementById("idChangePass").classList.remove("active");
    }, ["loginHisotryID"]); // ✅ show login history section
}

function showLoadingAndRun(callback, visibleIds = []) {
    const loadingEl = document.getElementById("loadingAnimationSettings");
    console.log("Loader shown");

    showSection([]); // Hide all first
    loadingEl.style.display = "flex"; // Show loader

    setTimeout(() => {
        try {
            callback(); // Run the main logic
            console.log("Callback done");
        } catch (err) {
            console.error("Error in callback:", err);
        }

        loadingEl.style.display = "none"; // Hide loader
        console.log("Loader hidden");

        showSection(visibleIds); // Show the required section
    }, 500);
}
