function activateTab(clickedBtn) {
    document.querySelectorAll(".tab-btn").forEach(btn => {
        btn.classList.remove("active");
    });
    clickedBtn.classList.add("active");
}

function showLoadingAndRun(callback) {
    const loader = document.getElementById("loadingAnimation");
    loader.style.display = "flex";

    setTimeout(() => {
        loader.style.display = "none";
        callback();
    }, 800);
}

function personalInfo() {
    console.log("Personal Information!");
    showLoadingAndRun(() => {
        showSection([
            "personalID",
            "updateButton",
            "personalInformation",
            "personalProfileInformation"
        ]);
    });
}

function familyBG() {
    console.log("Family Background!");
    showLoadingAndRun(() => {
        showSection([
            "familybg",
            "updateButtonFBG",
            "familyInformation",
            "familyProfileInformation"
        ]);
    });
}

function educationalBG() {
    console.log("Educational Background!");
    showLoadingAndRun(() => {
        showSection([
            "educationalbg",
            "updateButtonEBG",
            "educationalInformation",
            "educationProfileInformation"
        ]);
    });
}
function showSection(visibleIds) {
    const allSections = [
        "personalID",
        "updateButton",
        "personalInformation",
        "personalProfileInformation",
        "familybg",
        "updateButtonFBG",
        "familyInformation",
        "familyProfileInformation",
        "educationalbg",
        "updateButtonEBG",
        "educationalInformation",
        "educationProfileInformation"
    ];

    allSections.forEach(id => {
        const el = document.getElementById(id);
        if (el) el.style.display = "none";
    });

    visibleIds.forEach(id => {
        const el = document.getElementById(id);
        if (el) el.style.display = "block";
    });
}

window.addEventListener("load", function () {
    const urlParams = new URLSearchParams(window.location.search);
    const tab = urlParams.get("tab") || "personal";

    const tabMap = {
        personal: { btnId: "Personal", action: personalInfo },
        family: { btnId: "Family", action: familyBG },
        educational: { btnId: "Educational", action: educationalBG }
    };

    const tabConfig = tabMap[tab] || tabMap["personal"];
    const btn = document.getElementById(tabConfig.btnId);
    if (btn) activateTab(btn);
    tabConfig.action();
});