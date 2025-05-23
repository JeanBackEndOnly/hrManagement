// console.log("✅ hr.js loaded");


function previewImage(event) {
    const file = event.target.files[0];
    console.log("✅ hr.js loaded");
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            console.log("Image Loaded: ", e.target.result);
            document.getElementById("imageID").src = e.target.result;
        };
        reader.readAsDataURL(file);
    } else {
        console.log("No file selected");
    }
}

document.addEventListener('DOMContentLoaded', function () {
    fetch('../api/ajax.php')
        .then(response => response.json())
        .then(data => {
            const jobTitles = data.jobTitles; // Access the jobTitles array
            const select = document.getElementById('UpdateJobTitle');
            const currentValue = select.value;

            jobTitles.forEach(title => {
                if (title !== currentValue) {
                    const option = document.createElement('option');
                    option.value = title;
                    option.textContent = title;
                    select.appendChild(option);
                }
            });
        })
        .catch(error => {
            console.error('Error loading job titles:', error);
        });
});


document.addEventListener('DOMContentLoaded', function () {
    fetch('../api/ajax.php') // Adjust path if needed
        .then(response => response.json())
        .then(data => {
            const select = document.getElementById('job_TitleSelect');
            select.innerHTML = '<option value="None">Select Job Title</option>';

            const selectedJob = "<?php echo isset($_SESSION['admin_signup']['job_Title']) ? $_SESSION['admin_signup']['job_Title'] : ''; ?>";

            // Access data.jobTitles here
            data.jobTitles.forEach(title => {
                const option = document.createElement('option');
                option.value = title;
                option.textContent = title;
                if (title === selectedJob) {
                    option.selected = true;
                }
                select.appendChild(option);
            });
        })
        .catch(error => {
            console.error('Error fetching job titles:', error);
            const select = document.getElementById('job_TitleSelect');
            select.innerHTML = '<option value="">Failed to load job titles</option>';
        });
});
setTimeout(function() {
    var successDiv = document.getElementById("sideSuccess");
    if(successDiv) {
        successDiv.classList.add("hidden");
        setTimeout(function() {
            successDiv.style.display = "none";
        }, 500); // wait for fade-out
    }
}, 2000);
 function backening() {
    document.getElementById("edits").style.display = "none"; 
}





function cancelAction() {
    document.getElementById("hiddenForm").style.display = "none"; 
}


function openDeleteForm(userId) {   
    console.log("Button clicked!")
    document.getElementById("hiddenForm").style.display = "flex"; 
    document.getElementById("usersID").value = userId;
    document.getElementById("deleteForm").action = "../../auth/authentications.php?id=" + userId;
}



function backButton(){
    const sd = document.getElementById("accountRequest");
    const rejected = document.getElementById("rejectedRequest");
    const add = document.getElementById("addmamhen");
    console.log("button clicked!")
    if(sd.style.display == 'flex'){
        sd.style.display = 'none';
    }else if(rejected.style.display == 'flex'){
        rejected.style.display = 'none';
    }else if(add.style.display == 'flex'){
        add.style.display = 'none';
    }
}

function getHrNavs(){
    const sd = document.getElementById("hrNavs");
    console.log("button clicked!")
    if(sd.style.display == 'none'){
        sd.style.display = 'flex';
    }else{
        sd.style.display = 'none';
    }
}
 function addButton(){
    const reject = document.getElementById("addmamhen");
    console.log("button clicked!")
    if(reject.style.display == 'none'){
        reject.style.display = 'flex';
    }else{
        reject.style.display = 'none';
    }
}
function rejectButton(){
    const reject = document.getElementById("rejectedRequest");
    console.log("button clicked!")
    if(reject.style.display == 'none'){
        reject.style.display = 'flex';
    }else{
        reject.style.display = 'none';
    }
}
function requestButton(){
    const sd = document.getElementById("accountRequest");
    console.log("button clicked!")
    if(sd.style.display == 'none'){
        sd.style.display = 'flex';
    }else{
        sd.style.display = 'none';
    }
}
function profileMenu(){
    const sd = document.getElementById("profileMenu");
    console.log("button clicked!")
    if(sd.style.display == 'none'){
        sd.style.display = 'flex';
    }else{
        sd.style.display = 'none';
    }
}
function menuBar(){
    const buttonMenu = document.getElementById("sideContents");
    console.log("button clicked!")
    if(buttonMenu.style.display == 'none'){
    buttonMenu.style.display = 'flex';
    }else{
    buttonMenu.style.display = 'none';
    }
}
