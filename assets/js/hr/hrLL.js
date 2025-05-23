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

function addDateInput(containerId) {
    const container = document.getElementById(containerId);
    const newInput = document.createElement("li");
    newInput.innerHTML = `<input type="date" id="leave_dates" name="Leave_Date[]">`;
    container.appendChild(newInput);
}


function hiddenFormB(){
    console.log("hehe");
    document.getElementById("hiddenBreavement").style.display = "flex";
}
function backPO(){
    document.getElementById("hiddenBreavement").style.display = "none";
}
function hiddenFormM(){
    console.log("hehe");
    document.getElementById("hiddenMaternity").style.display = "flex";
}
function backPOM(){
    document.getElementById("hiddenMaternity").style.display = "none";
}
function hiddenFormP(){
    console.log("hehe");
    document.getElementById("hiddenPaternity").style.display = "flex";
}
function backPOP(){
    document.getElementById("hiddenPaternity").style.display = "none";
}
function hiddenFormS(){
    console.log("hehe");
    document.getElementById("hiddenSick").style.display = "flex";
}
function backPOS(){
    document.getElementById("hiddenSick").style.display = "none";
}
function hiddenFormV(){
    console.log("hehe");
    document.getElementById("hiddenVacation").style.display = "flex";
}
function backPOV(){
    document.getElementById("hiddenVacation").style.display = "none";
}
function hiddenFormW(){
    console.log("hehe");
    document.getElementById("hiddenWedding").style.display = "flex";
}
function backPOW(){
    document.getElementById("hiddenWedding").style.display = "none";
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
       
        // document.addEventListener('DOMContentLoaded', function () {
        //     fetch('../api/ajax.php')
        //         .then(response => response.json())
        //         .then(data => {
        //             const leaveData = data.leave;
        //             const container = document.getElementById('leaveList');
        //             container.innerHTML = ''; // Clear previous content if any
        
        //             leaveData.forEach((entry, index) => {
        //                 const row = document.createElement('div');
        //                 row.style.display = 'flex';
        //                 row.style.gap = '15px';
        //                 row.style.marginBottom = '10px';
        
        //                 row.innerHTML = `
        //                     <h5>${index + 1}</h5>
        //                     <h5>${entry.users_id}</h5>
        //                     <h5>${entry.surname}</h5>
        //                     <h5>${entry.leave_type}</h5>
        //                     <h5><a href="${entry.proof}" target="_blank">View</a></h5>
        //                     <h5>${entry.request_at}</h5>
        //                     <h5>${entry.approved_at}</h5>
        //                 `;
        
        //                 container.appendChild(row);
        //             });
        //         })
        //         .catch(error => {
        //             console.error('Error loading leave info:', error);
        //             const container = document.getElementById('leaveList');
        //             container.innerHTML = '<p>Failed to load leave information.</p>';
        //         });
        // });
          