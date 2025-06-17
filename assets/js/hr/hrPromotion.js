document.getElementById("jobTitleSearchInput").addEventListener("input", function () {
    const query = this.value.toLowerCase().trim();
    const rows = document.querySelectorAll("#jobTitleTableBody tr");

    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(query) ? "table" : "none";
    });
});
document.getElementById("empSearchInput").addEventListener("input", function () {
    const query = this.value.toLowerCase().trim();
    const rows = document.querySelectorAll("#empTableBody tr");

    rows.forEach(row => {
        const text = row.textContent.toLowerCase();
        row.style.display = text.includes(query) ? "table" : "none";
    });
});
function openUpdateModal(users_id, jobTitle, salary) {
    document.getElementById('updateJobId').value = users_id;
    document.getElementById('Job_Title').value = jobTitle;
    document.getElementById('updateSalary').value = salary;
}

function updateEmpItemsPerPage(perPage) {
    const url = new URL(window.location.href);
    url.searchParams.set("emp_perPage", perPage);
    url.searchParams.set("emp_page", 1);
    url.searchParams.set("tab", "salaryManage");
    window.location.href = url.toString();
}

function updateEmpSort(value) {
    const [sort, order] = value.split("-");
    const url = new URL(window.location.href);
    url.searchParams.set("emp_sort", sort);
    url.searchParams.set("emp_order", order);
    url.searchParams.set("emp_page", 1);
    url.searchParams.set("tab", "salaryManage");
    window.location.href = url.toString();
}

function handleEmpSort(value) {
    const [sort, order] = value.split("-");
    const url = new URL(window.location.href);
    url.searchParams.set("emp_sort", sort);
    url.searchParams.set("emp_order", order);
    url.searchParams.set("emp_page", 1); 
    location.href = url.toString();
}

function sortJobPromotion(column, order) {
    const url = new URL(window.location.href);
    url.searchParams.set('sort', column);
    url.searchParams.set('order', order);
    url.searchParams.set('perPage', document.querySelector('#itemsPerPage')?.value || '<?= $jobPerPage ?>');
    url.searchParams.set('page', 1); 

    history.replaceState(null, '', url);
    jobSalaryButton(); 
}

function updateSort(value) {
    const url = new URL(window.location.href);
    url.searchParams.set('sort', 'jobTitle');
    url.searchParams.set('order', value);
    url.searchParams.set('perPage', document.querySelector('#itemsPerPage')?.value || '<?= $jobPerPage ?>');
    history.replaceState(null, '', url);
    jobSalaryButton(); 
}

function updateItemsPerPage(value) {
    const url = new URL(window.location.href);
    url.searchParams.set('perPage', value);
    url.searchParams.set('sort', '<?= $jobSortColumn ?>');
    url.searchParams.set('order', '<?= $jobSortOrder ?>');
    history.replaceState(null, '', url);
    jobSalaryButton();
}

function activateTab(element) {
        document.querySelectorAll(".tab-btns").forEach(btn => {
            btn.classList.remove("active");
        });
        element.classList.add("active");
}

function jobSalaryButton() {
    showLoadingAndRun(() => {
        console.log("Salary Management tab action triggered.");

        document.getElementById("titleJob").style.display = 'none';
        document.getElementById("buttonJobTitle").style.display = 'none';
        document.getElementById("headerTableJob").style.display = 'none';
        document.getElementById("jobList").style.display = 'none';

         document.getElementById("titleSalary").style.display = 'flex';
         document.getElementById("promotionList").style.display = 'flex';
         document.getElementById("headerTableJobPromotion").style.display = 'flex';

        const salaryContent = document.getElementById("salaryContentArea");
        if (salaryContent) {
            salaryContent.style.display = 'flex';
        }

        activateTab(document.getElementById("salaryManage"));
        document.getElementById("jobTtitles").classList.remove("active");

    });
}

function jobTitleButton() {
    showLoadingAndRun(() => {
        console.log("Job Titles tab action triggered.");

        document.getElementById("titleJob").style.display = 'flex';
        document.getElementById("buttonJobTitle").style.display = 'flex';
        document.getElementById("headerTableJob").style.display = 'flex';
        document.getElementById("jobList").style.display = 'flex';

         document.getElementById("promotionList").style.display = 'none';
         document.getElementById("headerTableJobPromotion").style.display = 'none';
        document.getElementById("titleSalary").style.display = 'none';

        const salaryContent = document.getElementById("salaryContentArea");
        if (salaryContent) {
            salaryContent.style.display = 'none';
        }

        activateTab(document.getElementById("jobTtitles"));
        document.getElementById("salaryManage").classList.remove("active");

    });
}
window.addEventListener("load", function () {
        const urlParams = new URLSearchParams(window.location.search);
        const tab = urlParams.get("tab") || "jobTtitles";

        const tabMap = {
            jobTtitles: { btnId: "jobTtitles", action: jobTitleButton },
            salaryManage: { btnId: "salaryManage", action: jobSalaryButton },
        };

        const tabConfig = tabMap[tab] || tabMap["jobTtitles"]; 

        const btn = document.getElementById(tabConfig.btnId);

        if (btn) {
            activateTab(btn);
            tabConfig.action();
        } else {
            console.warn(`Button with ID '${tabConfig.btnId}' not found. Defaulting to 'jobTtitles'.`);
            const defaultBtn = document.getElementById("jobTtitles");
            if (defaultBtn) {
                activateTab(defaultBtn);
                jobTitleButton();
            }
        }
});

function showLoadingAndRun(callback) {
        const loader = document.getElementById("loading-overlay");
        loader.style.display = "flex";

        setTimeout(() => {
            loader.style.display = "none";
            callback();
        }, 800);
}

// ======================= SETTINGS ======================= //
window.addEventListener('DOMContentLoaded', () => {
        changePass(); 
    });

    function changePass() {
    showLoadingAndRun(() => {
        console.log("Change Password tab action triggered.");

       document.getElementById("changePAsswordID").style.display = 'flex';
       document.getElementById("loginHisotryID").style.display = 'none';

        activateTab(document.getElementById("idChangePass"));
        document.getElementById("idLoginHistory").classList.remove("active");

    });
}

function loginHistory() {
    showLoadingAndRun(() => {
        console.log("Login HIstory tab action triggered.");

        document.getElementById("loginHisotryID").style.display = 'flex';
        document.getElementById("changePAsswordID").style.display = 'none';

        activateTab(document.getElementById("idLoginHistory"));
        document.getElementById("idChangePass").classList.remove("active");

    });
}


