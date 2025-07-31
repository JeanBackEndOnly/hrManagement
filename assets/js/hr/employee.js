// ==================== EMPLOYEE MANAGEMENT =========================== //
window.onload = function () {
        const urlParams = new URLSearchParams(window.location.search);
        const tab = urlParams.get("tab");

        switch (tab) {
            case "accept":
                if (typeof getValidated === "function") getValidated();
                break;
            case "reject":
                if (typeof getRejected === "function") getRejected();
                break;
            case "request":
                if (typeof getRequest === "function") getRequest();
                break;
        }
};
document.addEventListener('DOMContentLoaded', function() {
        const form = document.querySelector('form[action="../auth/authentications.php"]');

        form.addEventListener('submit', function(e) {
            const requiredFields = form.querySelectorAll('input[required], textarea[required], select[required]');
            
            let emptyFound = false;

            requiredFields.forEach(field => {
            if (!field.value.trim()) {  
                emptyFound = true;
                field.classList.add('input-error'); 
            } else {
                field.classList.remove('input-error');
            }
            });

            if (emptyFound) {
            e.preventDefault();  
            alert('Please fill out all required fields before submitting.');
            }
        });
    });
    document.getElementById("searchRejectedInput").addEventListener("input", function () {
        const filter = this.value.toLowerCase();
        const rows = document.querySelectorAll("#rejectedList tr");

        rows.forEach(row => {
            if (row.querySelectorAll("td").length < 6) return;
            const rowText = row.textContent.toLowerCase();
            row.style.display = rowText.includes(filter) ? "table" : "none";
        });
    });
    document.getElementById("searchRequestInput").addEventListener("input", function () {
        const filter = this.value.toLowerCase();
        const rows = document.querySelectorAll("#requestList tbody tr");

        rows.forEach(row => {
            if (row.querySelectorAll("td").length < 6) return;

            const rowText = row.textContent.toLowerCase();
            row.style.display = rowText.includes(filter) ? "table" : "none";
        });
    });
    document.getElementById("searchValidatedInput").addEventListener("input", function () {
        const filter = this.value.toLowerCase();
        const rows = document.querySelectorAll("#validatedList tbody tr");

        rows.forEach(row => {
            if (row.querySelectorAll("td").length < 6) return;

            const rowText = row.textContent.toLowerCase();
            row.style.display = rowText.includes(filter) ? "table" : "none";
        });
    });
    function showLoadingAndRun(callback, visibleIds = []) {
        const loadingEl = document.getElementById("loadingAnimation");

        showSection([]);

        loadingEl.style.display = "flex";

        setTimeout(() => {
            callback();
            loadingEl.style.display = "none";
            showSection(visibleIds);
        }, 500);
    }
    function fetchPendingCount() {
        fetch('../functions/api.php')
            .then(response => response.json())
            .then(data => {
                const count = data.pendingCount ?? 0;
                document.getElementById('pendingCountDisplay').textContent = count;
            })
            .catch(error => {
                console.error('Error fetching data:', error);
            });
    }

    document.addEventListener('DOMContentLoaded', function () {
        fetchPendingCount(); 
        setInterval(fetchPendingCount, 5000);
    });

function getValidated() {
    showLoading();

    setTimeout(() => {
        document.getElementById("validatedList").style.display = 'flex';
        document.getElementById("validateSearch").style.display = 'flex';
        // document.getElementById("validatedEmployees").style.display = 'flex';

        document.getElementById("requestList").style.display = 'none';
        document.getElementById("requestSearch").style.display = 'none';
        // document.getElementById("employeesRequest").style.display = 'none';
        document.getElementById("rejectedList").style.display = 'none';
        document.getElementById("rejectedSearch").style.display = 'none';
        // document.getElementById("rejectedEmployees").style.display = 'none';

        hideLoading();
    }, 800); 
}

function getRequest() {
    // showLoading();
    setTimeout(() => {
        document.getElementById("requestList").style.display = 'flex';
        document.getElementById("requestSearch").style.display = 'flex';
        // document.getElementById("employeesRequest").style.display = 'flex';

        document.getElementById("validatedList").style.display = 'none';
        document.getElementById("validateSearch").style.display = 'none';
        // document.getElementById("validatedEmployees").style.display = 'none';
        document.getElementById("rejectedList").style.display = 'none';
        document.getElementById("rejectedSearch").style.display = 'none';
        // document.getElementById("rejectedEmployees").style.display = 'none';

        hideLoading();
    }, 800); 
}

function getRejected(){
   showLoading();

    setTimeout(() => {
        document.getElementById("rejectedList").style.display = 'flex';
        document.getElementById("rejectedSearch").style.display = 'flex';
        // document.getElementById("rejectedEmployees").style.display = 'flex';

        document.getElementById("requestList").style.display = 'none';
        document.getElementById("requestSearch").style.display = 'none';
        // document.getElementById("employeesRequest").style.display = 'none';
        document.getElementById("validatedList").style.display = 'none';
        document.getElementById("validateSearch").style.display = 'none';
        // document.getElementById("validatedEmployees").style.display = 'none';

        hideLoading();
    }, 800); 
}
function openAcceptModal(employeeId) {
    document.getElementById('acceptEmployeeId').value = employeeId;
    var acceptModal = new bootstrap.Modal(document.getElementById('acceptModal'));
    acceptModal.show();
}

function openRejectModal(employeeId) {
    document.getElementById('rejectEmployeeId').value = employeeId;
    var rejectModal = new bootstrap.Modal(document.getElementById('rejectModal'));
    rejectModal.show();
}
function setDeleteId(userId) {
    document.getElementById('delete_user_id').value = userId;
}
function activateTab(button) {
    document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
    button.classList.add('active');

    const tabName = button.getAttribute('data-tab');
    if (tabName) {
        const url = new URL(window.location);
        url.searchParams.set('tab', tabName);
        window.history.replaceState(null, '', url.toString());
    }
}
