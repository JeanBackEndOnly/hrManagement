
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
        function backPOW(){
    document.getElementById("hiddenBreavement").style.display = 'none';
}
document.addEventListener('DOMContentLoaded', function () {
    fetch('../api/ajax.php')
        .then(response => response.json())
        .then(data => {
            const container = document.getElementById('leaveList');
            container.innerHTML = ''; // Clear previous content

            // Check if 'leave' is a valid array
            if (Array.isArray(data.Employeeleave) && data.Employeeleave.length > 0) {
                const leaveData = data.Employeeleave.filter(entry => entry.leaveID !== null && entry.leave_Type !== null);


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
                        <h5 style="padding-left: 2rem;">${entry.approved_at}</h5>
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