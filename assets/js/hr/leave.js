function previewImage(event) {
    const file = event.target.files[0];
    const previewId = event.target.getAttribute('data-preview-id');
    const previewImg = document.getElementById(previewId);

    if (file && previewImg) {
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImg.src = e.target.result;
        };
        reader.readAsDataURL(file);
    } else {
        console.log("No file selected or preview image not found");
    }
}

    function showProof(id) {
        document.getElementById("hiddenProof" + id).style.display = "block";
    }
    
    function backPoAko(id) {
        document.getElementById("hiddenProof" + id).style.display = "none";

    }
    document.addEventListener('DOMContentLoaded', function () {
    fetch('../api/ajax.php')
        .then(response => response.json())
        .then(data => {
            const container = document.getElementById('leaveList');
            container.innerHTML = ''; // Clear previous content

            // Check if 'leave' is a valid array
            if (Array.isArray(data.leave) && data.leave.length > 0) {
                const leaveData = data.leave.filter(entry => entry.leaveID !== null && entry.leave_Type !== null);

                if (leaveData.length === 0) {
                    container.innerHTML = '<p>No leave information available.</p>';
                    return;
                }

                leaveData.forEach((entry, index) => {
                    const row = document.createElement('div');
                    row.style.display = 'grid';
                    row.style.gridTemplateColumns = 'repeat(7, 1fr)';
                    row.style.gap = '17px';
                    row.style.marginBottom = '10px';
                    row.style.padding = '10px';
                    row.style.border = '1px solid #ccc';
                    row.style.borderRadius = '5px';
                    row.style.marginBottom = '0';

                    row.innerHTML = `
                        <h5>${index + 1}</h5>
                        <h5>${entry.employee_id}</h5>
                        <h5>${entry.Lname}</h5>
                        <h5>${entry.leave_Type}</h5>
                        <h5><a href="viewImage.php?image=${entry.prof}" target="_blank" style="margin-left: 1.6rem;">View</a></h5>
                        <h5 style="padding-left: 2rem;">${entry.Leave_Date}</h5>
                        <h5><button type="button" id="removehehe" onclick="hiddenDeleteHehe('${entry.leaveID}')"><i class="fa-solid fa-trash" style="margin-left: 2.5rem; font-size: 20px; color: #000;"></i></button></h5>
                    `;

                    container.appendChild(row);
                });
            } else {
                container.innerHTML = '<p>No leave information available.</p>';
            }
        })
        .catch(error => {
            console.error('Error loading leave info:', error);
            const container = document.getElementById('leaveList');
            container.innerHTML = '<p>Failed to load leave information.</p>';
        });
});
document.addEventListener('DOMContentLoaded', function () {
    fetch('../api/ajax.php')
        .then(response => response.json())
        .then(data => {
            const container = document.getElementById('requestList');
            container.innerHTML = ''; // Clear previous content

            // Check if 'leave' is a valid array
            if (Array.isArray(data.pendingLeave) && data.pendingLeave.length > 0) {
                const leaveData = data.pendingLeave.filter(entry => entry.leaveID !== null && entry.leave_Type !== null);

                if (leaveData.length === 0) {
                    container.innerHTML = '<p>No leave information available.</p>';
                    return;
                }

                leaveData.forEach((entry, index) => {
                    const row = document.createElement('div');
                    row.style.display = 'grid';
                    row.style.gridTemplateColumns = 'repeat(7, 1fr)';
                    row.style.gap = '17px';
                    row.style.marginBottom = '10px';
                    row.style.padding = '10px';
                    row.style.border = '1px solid #ccc';
                    row.style.borderRadius = '5px';
                    row.style.marginBottom = '0';

                    row.innerHTML = `
                        <h5>${index + 1}</h5>
                        <h5>${entry.employee_id}</h5>
                        <h5>${entry.Lname}</h5>
                        <h5>${entry.leave_Type}</h5>
                        <h5><a href="viewImage.php?image=${entry.prof}" target="_blank" style="margin-left: 1.6rem;">View</a></h5>
                        <h5 style="padding-left: 2rem;">${entry.Leave_Date}</h5>
                        <h5 id="twoButtons">
                        <button type="button" id="acceptRequest" onclick="hiddentAccept('${entry.leaveID}')"><i class="fa-solid fa-square-check" style="margin-left: 2.5rem; font-size: 20px; color: #000;"></i></button>
                        <button type="button" id="DeleteLeaveRequest" onclick="hiddenDeleteLeave('${entry.leaveID}')"><i class="fa-solid fa-square-minus" style="margin-left: 2.5rem; font-size: 20px; color: #000;"></i></button>
                        </h5>
                    `;

                    container.appendChild(row);
                });
            } else {
                container.innerHTML = '<p>No leave information available.</p>';
            }
        })
        .catch(error => {
            console.error('Error loading leave info:', error);
            const container = document.getElementById('requestList');
            container.innerHTML = '<p>Failed to load leave information.</p>';
        });
});
function hiddentAccept(idLeave){
    document.getElementById("hiddenAksep").style.display = 'flex';
    // document.getElementById("leaveIDs").value = idLeave;
    document.getElementById("acceptLeave").action = "../../auth/authentications.php?leaveID=" + idLeave;
}
function backPOW(){
    document.getElementById("hiddenBreavement").style.display = 'none';
}
function hiddenDeleteHehe(id){
    document.getElementById("hiddenDeleteBUtton").style.display = 'flex';
    document.getElementById("deleteLeaveHistory").action = '../../auth/authentications.php?leaveID=' + id;
    document.getElementById("idMahamen").value = id;
    document.getElementById("leaveID").value = id;
}
function hiddenDeleteLeave(employeeID){
    document.getElementById("hiddenDeleteRequest").style.display = 'flex';
    document.getElementById("RejectLeaveRequest").action  = '../../auth/authentications.php?leaveID=' + employeeID;
}
function cancelThis(){
    document.getElementById("hiddenDeleteBUtton").style.display = 'none';
    document.getElementById("hiddenAksep").style.display = 'none';
    document.getElementById("hiddenDeleteRequest").style.display = 'none';
}
function Lrequest(){
    document.getElementById("hiddenLeaveRequest").style.display = 'flex';
}
function heheBack(){
    document.getElementById("hiddenLeaveRequest").style.display = 'none';
}