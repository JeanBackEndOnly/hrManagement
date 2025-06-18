function personalInfo() {
    console.log("Personal Information!");
    showLoadingAndRun(() => {}, [
        "personalID",
        "updateButton",
        "personalInformation",
        "personalProfileInformation"
    ]);
}

function familyBG() {
    console.log("Family Background!");
    showLoadingAndRun(() => {}, [
        "familybg",
        "updateButtonFBG",
        "familyInformation",
        "familyProfileInformation"
    ]);
}

function educationalBG() {
    console.log("Educational Background!");
    showLoadingAndRun(() => {}, [
        "educationalbg",
        "updateButtonEBG",
        "educationalInformation",
        "educationProfileInformation"
    ]);
}

function showSection(visibleIds) {
    const allSections = [
        "personalID",
        "familybg",
        "educationalbg",
        "updateButton",
        "updateButtonFBG",
        "updateButtonEBG",
        "educationalInformation",
        "familyInformation",
        "personalInformation",
        "educationProfileInformation",
        "familyProfileInformation",
        "personalProfileInformation"
    ];

    allSections.forEach(id => {
        const el = document.getElementById(id);
        if (el) {
            el.style.display = visibleIds.includes(id) ? 'flex' : 'none';
        }
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


function showLoaderThen(callback) {
        const loader = document.getElementById("loading-overlay");
        loader.style.display = "flex";

        setTimeout(() => {
            loader.style.display = "none";
            callback();
        }, 800); 
    }