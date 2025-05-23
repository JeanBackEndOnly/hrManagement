<?php include '../templates/header.php'; 
    require_once '../auth/reg.php';
   
 ?>

                
<div class="addmamhen" id="addmamhens">

        <?php
            signup_inputs();
        ?>
    <div class="outerButton" id="register-outer">
        <button type="submit" id="naniButton" class="btn btn-primary">SIGN UP</button>
    </div>
    </form>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
    fetch('api/ajax.php') // Adjust path if needed
        .then(response => response.json())
        .then(data => {
            const select = document.getElementById('RegisterJobTitle');
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
            const select = document.getElementById('RegisterJobTitle');
            select.innerHTML = '<option value="">Failed to load job titles</option>';
        });
});
document.getElementById("departmentss").addEventListener("change", function () {
    const department = this.value;
    const schoolFrom = document.getElementById("school_schedule_from");
    const schoolTo = document.getElementById("school_schedule_to");
    const hospitalFrom = document.getElementById("hospital_schedule_from");
    const hospitalTo = document.getElementById("hospital_schedule_to");

    if (schoolFrom) schoolFrom.style.display = "none";
    if (schoolTo) schoolTo.style.display = "none";
    if (hospitalFrom) hospitalFrom.style.display = "none";
    if (hospitalTo) hospitalTo.style.display = "none";

    if (department === "SCHOOL") {
        if (schoolFrom) schoolFrom.style.display = "block";
        if (schoolTo) schoolTo.style.display = "block";
    } else if (department === "HOSPITAL") {
        if (hospitalFrom) hospitalFrom.style.display = "block";
        if (hospitalTo) hospitalTo.style.display = "block";
    }
});

window.addEventListener("DOMContentLoaded", function () {
    document.getElementById("departmentss").dispatchEvent(new Event("change"));
});

function toggleScheduleFields() {
    const department = document.getElementById('departmentss').value;
    const schoolField = document.getElementById('school_schedule_field');
    const hospitalField = document.getElementById('hospital_schedule_field');

    if (department === "SCHOOL") {
        schoolField.style.display = 'flex';
        hospitalField.style.display = 'none';
    } else if (department === "HOSPITAL") {
        hospitalField.style.display = 'flex';
        schoolField.style.display = 'none';
    } else {
        hospitalField.style.display = 'none';
        schoolField.style.display = 'none';
    }
}

document.addEventListener('DOMContentLoaded', toggleScheduleFields);
</script>
<?php include '../templates/footer.php'?>