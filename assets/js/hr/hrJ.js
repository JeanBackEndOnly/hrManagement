function deleteJob(id){
    console.log("button clicked!");
    document.getElementById("deleteJobs").style.display = 'flex';
    document.getElementById("jobID").value = id;
    document.getElementById("deleteForm").action = "../../auth/authentications.php?id=" + id;
}
function addJobs(){
    const jl = document.getElementById("jl");
    console.log("button clicked!")
    if(jl.style.display == 'none'){
        jl.style.display = 'flex';
    }else{
        jl.style.display = 'none';
    }
}
function CancelJob(){
    document.getElementById("deleteJobs").style.display = "none";
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
