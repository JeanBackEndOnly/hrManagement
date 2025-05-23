function previewImage(event) {
    const file = event.target.files[0];
    console.log("✅ hr.js loaasdasdasdded");
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            console.log("Image Loaded: ", e.target.result);
            document.getElementById("imageNani").src = e.target.result;
        };
        reader.readAsDataURL(file);
    } else {
        console.log("No file selected");
    }
}
function pibutton(){
    const ei = document.getElementById("ei");
    const ebg = document.getElementById("ebg");
    const fbg = document.getElementById("fbg");
    const pi = document.getElementById("pi");
    const eb = document.getElementById("eb");
    const fb = document.getElementById("fb");
    console.log("button clicked!")
    if(ei.style.display == 'none'){
        ei.style.display = 'flex';
        ebg.style.display = 'none';
        fbg.style.display = 'none';
        pi.classList.add("active-btn");
        eb.classList.remove("active-btn");
        fb.classList.remove("active-btn");

        pi.classList.remove("inactive-btn");
        eb.classList.add("inactive-btn");
        fb.classList.add("inactive-btn");
    }else{
        ei.style.display = 'flex';
        
    }
}
function edbutton(){
    const ei = document.getElementById("ei");
    const ebg = document.getElementById("ebg");
    const fbg = document.getElementById("fbg");
    const pi = document.getElementById("pi");
     const eb = document.getElementById("eb");
     const fb = document.getElementById("fb");
    console.log("button clicked!")
    if(ebg.style.display == 'none'){
        ebg.style.display = 'flex';
        fbg.style.display = 'none';
        ei.style.display = 'none';
        pi.classList.remove("active-btn");
        eb.classList.add("active-btn");
        fb.classList.remove("active-btn");

        pi.classList.add("inactive-btn");
        eb.classList.remove("inactive-btn");
        fb.classList.add("inactive-btn");
    }else{
        ebg.style.display = 'flex';
    }
}

function febutton(){
    const ei = document.getElementById("ei");
    const ebg = document.getElementById("ebg");
    const fbg = document.getElementById("fbg");
    const fb = document.getElementById("fb");
    const pi = document.getElementById("pi");
    const eb = document.getElementById("eb");
    console.log("button clicked!")
    if(fbg.style.display == 'none'){
        fbg.style.display = 'flex';
        ebg.style.display = 'none';
        ei.style.display = 'none';
        pi.classList.remove("active-btn");
        eb.classList.remove("active-btn");
        fb.classList.add("active-btn");

        pi.classList.add("inactive-btn");
        eb.classList.add("inactive-btn");
        fb.classList.remove("inactive-btn");
    }else{
        fbg.style.display = 'flex';
    }
}
function updateButton(){
    document.getElementById("buttonConfirmation").style.display = 'flex';
}

    document.getElementById("searchInput").addEventListener("input", function () {
        const input = this.value.toLowerCase();
        const employees = document.querySelectorAll(".employeeCard");

        employees.forEach(function (employee) {
            const name = employee.querySelector("p:nth-child(3)").textContent.toLowerCase(); // Lastname, Firstname
            const job = employee.querySelector("p:nth-child(4)").textContent.toLowerCase();  // Job Title
            const department = employee.querySelector("p:nth-child(5)").textContent.toLowerCase(); // Department

            if (name.includes(input) || job.includes(input) || department.includes(input)) {
                employee.style.display = "block";
            } else {
                employee.style.display = "none";
            }
        });
    });

    const searchInput = document.getElementById('searchInput');
    const employeeContainer = document.getElementById('employeeContainer');
    const employeeList = document.getElementById('employeeList');
    const employees = employeeContainer.querySelectorAll('.approved');

    // Initial state
    employeeContainer.style.display = 'none';
    employeeList.style.display = 'flex';

    searchInput.addEventListener('input', () => {
        const filter = searchInput.value.trim().toLowerCase();
        let hasMatch = false;

        employees.forEach(employee => {
            const id = employee.getAttribute('data-employee-id')?.toLowerCase() || '';
            const name = employee.querySelector('.emp-name')?.textContent.toLowerCase() || '';
            const dept = employee.querySelector('.emp-dept')?.textContent.toLowerCase() || '';

            const match = id.includes(filter) || name.includes(filter) || dept.includes(filter);

            if (filter && match) {
                employee.style.display = 'flex';
                hasMatch = true;
            } else {
                employee.style.display = 'none';
            }
        });

        if (filter && hasMatch) {
            employeeContainer.style.display = 'flex';
            employeeList.style.display = 'none';
        } else {
            employeeContainer.style.display = 'none';
            employeeList.style.display = 'flex';
        }
    });

    function previewImage(event) {
        const file = event.target.files[0];
        console.log("✅ hr.js loaded");
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                console.log("Image Loaded: ", e.target.result);
                document.getElementById("previewsss").src = e.target.result;
            };
            reader.readAsDataURL(file);
        } else {
            console.log("No file selected");
        }
    }

    function updateButton(){
        document.getElementById("buttonConfirmation").style.display = 'flex';
    }
    function CancelUPdate(){
        document.getElementById("buttonConfirmation").style.display = 'none';
    }
    function showProof(id) {
        document.getElementById("hiddenProof" + id).style.display = "block";
    }
    
    function backPoAko(id) {
        document.getElementById("hiddenProof" + id).style.display = "none";
    }
    function showProof(id) {
        document.getElementById("hiddenProof" + id).style.display = "block";
    }
    function backPoAko(id) {
        document.getElementById("hiddenProof" + id).style.display = "none";
    }
    
    function loadLeaves() {
        fetch("../../../src/api/ajax.php")
            .then(response => response.json())
            .then(data => {
                if (!data.success) {
                    document.getElementById("hehe").innerText = "Failed to load leave data.";
                    return;
                }
    
                let html = "";
                data.data.forEach(row => {
                    html += `
                        <ul>
                            <p>${row.leaveID}</p>
                            <p>${row.employeeID}</p>
                            <p>${row.Lname}</p>
                            <p>${row.leave_Type}</p>
                            <p><button type="button" onclick="showProof(${row.id})"><i class="fa-solid fa-eye"></i></button></p>
                            <div class="hiddenProof" id="hiddenProof${row.id}" style="display: none;">
                                <button type="button" onclick="backPoAko(${row.id})"><i class="fa-solid fa-arrow-left"></i></button>
                                <img src="../../assets/image/upload/${row.prof}" alt="Proof Image">
                            </div>
                            <p>${row.request_at}</p>
                            <p>${row.approved_at}</p>
                        </ul>
                    `;
                });
    
                document.getElementById("hehe").innerHTML = html;
            })
            .catch(err => {
                document.getElementById("hehe").innerText = "An error occurred while fetching leave data.";
                console.error(err);
            });
    }
    
    // Load leaves on page load
    document.addEventListener("DOMContentLoaded", loadLeaves);