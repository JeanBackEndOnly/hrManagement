
    function previewImage(event) {
        const file = event.target.files[0];
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
    // ================== TOAST NOTIFICATION ================== //
    document.addEventListener('DOMContentLoaded', () => {
        if (updateReq) {
            console.log("Showing updateReq toast");
            Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: 'Profile Updated Successfully.',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            customClass: { popup: 'swal2-row-toast' }
            });
            removeUrlParams(['updateReq']);
        }else if (updateValFailed) {
            console.log("Showing updateReq toast");
            Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'error',
            title: 'Profile Update Failed.',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            customClass: { popup: 'swal2-row-toast' }
            });
            removeUrlParams(['updateValFailed']);
        }else if (updateReqFailed) {
            console.log("Showing updateReq toast");
            Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'error',
            title: 'Profile Update Failed.',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            customClass: { popup: 'swal2-row-toast' }
            });
            removeUrlParams(['updateReqFailed']);
        }else if (updateVal) {
            console.log("Showing updateReq toast");
            Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: 'Profile Updated Successfully.',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            customClass: { popup: 'swal2-row-toast' }
            });
            removeUrlParams(['updateVal']);
        }else if (upsertSuccess) {
            console.log("Showing updateReq toast");
            Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: 'Profile Updated Successfully.',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            customClass: { popup: 'swal2-row-toast' }
            });
            removeUrlParams(['upsert']);
        }else if (upsertFailed) {
            console.log("Showing updateReq toast");
            Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'error',
            title: 'Profile Updated Failed.',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            customClass: { popup: 'swal2-row-toast' }
            });
            removeUrlParams(['upsert']);
        }else if (promotion) {
            console.log("Showing updateReq toast");
            Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: 'Employee promoted Successfully.',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            customClass: { popup: 'swal2-row-toast' }
            });
            removeUrlParams(['promotion']);
        }
        function removeUrlParams(params) {
            const url = new URL(window.location);
            params.forEach(param => url.searchParams.delete(param));
            window.history.replaceState({}, document.title, url.toString());
        }
    });
    document.addEventListener('DOMContentLoaded', () => {
        if (AddJobModal) {
            Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: 'Job title has been added successfully.',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            customClass: { popup: 'swal2-row-toast' }
            });
            removeUrlParams(['job']);
        } 
        else if (DeleteJobModal) {
            Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: 'Job title has been deleted successfully.',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            customClass: { popup: 'swal2-row-toast' }
            });
            removeUrlParams(['deleteJob']);
        }
        else if (JobTitleExdit) {
            Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: 'Job title edited successfully.',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            customClass: { popup: 'swal2-row-toast' }
            });
            removeUrlParams(['JobTitleExdit']);
        }
        else if (JobExistModal) {
            Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'error',
            title: 'Job title already exists.',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            customClass: { popup: 'swal2-row-toast' }
            });
            removeUrlParams(['Job']);
        }else if (acceptEmployee) {
            Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: 'Employee Validated Successfully.',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            customClass: { popup: 'swal2-row-toast' }
            });
            removeUrlParams(['acceptEmployee']);
        }else if (rejectEmployee) {
            Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'error',
            title: 'Employee Rejected Successfully.',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            customClass: { popup: 'swal2-row-toast' }
            });
            removeUrlParams(['rejectEmployee']);
        }else if (deleteValidatedEmployee) {
            Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'error',
            title: 'Employee Deleted Successfully.',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            customClass: { popup: 'swal2-row-toast' }
            });
            removeUrlParams(['deleteValidatedEmployee']);
        }else if (updateReq) {
            console.log("Showing updateReq toast");
            Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: 'Profile Updated Successfully.',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            customClass: { popup: 'swal2-row-toast' }
            });
            removeUrlParams(['updateReq']);
        }
        function removeUrlParams(params) {
            const url = new URL(window.location);
            params.forEach(param => url.searchParams.delete(param));
            window.history.replaceState({}, document.title, url.toString());
        }
    });
    document.addEventListener('DOMContentLoaded', function () {
        var toastElList = [].slice.call(document.querySelectorAll('.toast'));
        toastElList.forEach(function (toastEl) {
            var toast = new bootstrap.Toast(toastEl);
            toast.show();
        });
    });
    // ================== REGISTRATION NOTIFICATION SUCCESS ================== //
    document.addEventListener('DOMContentLoaded', () => {
        function getQueryParam(param) {
            const urlParams = new URLSearchParams(window.location.search);
            return urlParams.get(param);
        }

        if (getQueryParam('signup') === 'success') {
            Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: 'Signup successful! You may now log in.',
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true,
            customClass: {
                popup: 'swal2-row-toast'
            }
            });

            const url = new URL(window.location);
            url.searchParams.delete('signup');
            window.history.replaceState({}, document.title, url.toString());
        }
    });
     // ================== JOB TITLE LIST IN REGISTRATION ================== //
    document.addEventListener('DOMContentLoaded', function () {
        const jobTitleSelect = document.getElementById('JobTitle');
        console.log("heheWorking!");
        if (!jobTitleSelect) {
            console.error("JobTitle select element not found!");
            return;
        }

        fetch('api.php')
            .then(response => response.json())
            .then(data => {
                if (!Array.isArray(data.jobTitles)) {
                    console.error('Invalid data from API:', data);
                    return;
                }

                // Clear existing options
                jobTitleSelect.innerHTML = '<option value="">Select Job Title</option>';

                data.jobTitles.forEach(item => {
                    const option = document.createElement('option');
                    option.value = item.jobTitle;
                    option.textContent = item.jobTitle;

                    if (typeof selectedJobTitle !== 'undefined' && item.jobTitle === selectedJobTitle) {
                        option.selected = true;
                    }

                    jobTitleSelect.appendChild(option);
                });
            })
            .catch(error => {
                console.error('Error loading job titles:', error);
            });
    });
    document.addEventListener('DOMContentLoaded', function () {
        const jobTitleSelect = document.getElementById('Job_Title');
        console.log("Fok!");
        console.log("Selected Job Title is:", selectedJobTitle);

        if (!jobTitleSelect) {
            console.error("JobTitle select element not found!");
            return;
        }

        fetch('../api.php')
        .then(response => response.json())
        .then(data => {
            console.log("Fetched data:", data);

            if (!Array.isArray(data.jobTitles)) {
                console.error('Invalid data from API:', data);
                return;
            }

            jobTitleSelect.innerHTML = '<option value="">Select Job Title</option>';

            data.jobTitles.forEach(item => {
                const option = document.createElement('option');
                option.value = item.jobTitle;
                option.textContent = item.jobTitle;

                if (selectedJobTitle && item.jobTitle === selectedJobTitle) {
                    option.selected = true;
                }

                jobTitleSelect.appendChild(option);
            });
        })
        .catch(error => {
            console.error('Error loading job titles:', error);
            jobTitleSelect.innerHTML = '<option value="">Failed to load job titles</option>';
        });

    });
     // ================== Request Count ================== //
    document.addEventListener('DOMContentLoaded', function () {
        fetch('../api.php')
            .then(response => response.json())
            .then(data => {
                const count = data.pendingCount ?? 0; 
                document.getElementById('pendingCountDisplay').textContent = count;
            })
            .catch(error => {
                console.error('Error fetching data:', error);
            });
    });
        // ================== PASSWORD EYE ================== //
    const passwordInput = document.getElementById('passwordInput');
    const showPassword = document.getElementById('showPassword');
    const hidePassword = document.getElementById('hidePassword');

    const confirmPasswordInput = document.getElementById('confirmPasswordInput');
    const showConfirmPassword = document.getElementById('showConfirmPassword');
    const hideConfirmPassword = document.getElementById('hideConfirmPassword');

    showPassword.addEventListener('click', () => {
        passwordInput.type = 'text';
        showPassword.style.display = 'none';
        hidePassword.style.display = 'inline';
    });

    hidePassword.addEventListener('click', () => {
        passwordInput.type = 'password';
        showPassword.style.display = 'inline';
        hidePassword.style.display = 'none';
    });

    showConfirmPassword.addEventListener('click', () => {
        confirmPasswordInput.type = 'text';
        showConfirmPassword.style.display = 'none';
        hideConfirmPassword.style.display = 'inline';
    });

    hideConfirmPassword.addEventListener('click', () => {
        confirmPasswordInput.type = 'password';
        showConfirmPassword.style.display = 'inline';
        hideConfirmPassword.style.display = 'none';
    });
     // ================== SCHEDULE VALIDATION ================== //
    document.addEventListener('DOMContentLoaded', function () {
        const departmentSelect = document.getElementById('Department');
        const scheduleFrom = document.getElementById('scheduleFrom');
        const scheduleTo = document.getElementById('scheduleTo');

        if (!departmentSelect || !scheduleFrom || !scheduleTo) {
            console.error('One or more required DOM elements are missing');
            return;
        }

        const schedules = {
            HOSPITAL: [
                { from: '07:00 AM', to: '03:00 PM' },
                { from: '03:00 PM', to: '11:00 PM' },
                { from: '11:00 PM', to: '07:00 AM' }
            ],
            SCHOOL: [
                { from: '07:30 AM', to: '04:30 PM' }
            ]
        };

        console.log('Department value:', departmentSelect.value);
        console.log('Schedules available:', schedules[departmentSelect.value]);
        console.log('Old scheduleFrom:', window.signupData ? window.signupData.scheduleFrom : undefined);
        console.log('Old scheduleTo:', window.signupData ? window.signupData.scheduleTo : undefined);

        function populateSchedules(dept) {
            scheduleFrom.innerHTML = '<option value="">Select Schedule From</option>';
            scheduleTo.innerHTML = '<option value="">Select Schedule To</option>';

            if (!schedules[dept]) return;

            schedules[dept].forEach(shift => {
                const optionFrom = document.createElement('option');
                optionFrom.value = shift.from;
                optionFrom.textContent = shift.from;
                scheduleFrom.appendChild(optionFrom);

                const optionTo = document.createElement('option');
                optionTo.value = shift.to;
                optionTo.textContent = shift.to;
                scheduleTo.appendChild(optionTo);
            });
        }

        departmentSelect.addEventListener('change', function () {
            populateSchedules(this.value);
        });

        if (departmentSelect.value && departmentSelect.value !== 'NO DEPARTMENT') {
            console.log('Populating schedules for department:', departmentSelect.value);
            populateSchedules(departmentSelect.value);

            const oldFrom = window.signupData ? window.signupData.scheduleFrom : null;
            const oldTo = window.signupData ? window.signupData.scheduleTo : null;

            console.log('Old From:', oldFrom);
            console.log('Old To:', oldTo);

            if (oldFrom) scheduleFrom.value = oldFrom;
            if (oldTo) scheduleTo.value = oldTo;
        }
    });
    // ================== JOB TITLE SEARCH ================== //
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.querySelector('.search-active input');
        const rows = document.querySelectorAll('.job-list tbody tr');

        searchInput.addEventListener('keyup', function () {
            const query = this.value.trim().toLowerCase();

            rows.forEach(row => {
                const jobTitleCell = row.querySelector('td:nth-child(2)');
                if (!jobTitleCell) return;

                const title = jobTitleCell.textContent.trim().toLowerCase();
                if (title.includes(query)) {
                    row.style.display = 'table';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    });
    // ================== EMPLOYEE SEARCH ================== //
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
    // ================== REGISTRATION FORM VALIDATION ================== //
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
    // ====================== register =========================== //

    function showLoaderThen(callback) {
        const loader = document.getElementById("loading-overlay");
        loader.style.display = "flex";

        setTimeout(() => {
            loader.style.display = "none";
            callback();
        }, 800); 
    }

    function nextst() {
        const lnameEl = document.getElementById('surname');
        const fnameEl = document.getElementById('fname');
        const mnameEl = document.getElementById('mname');
        const employeeIDEl = document.getElementById('employeeID');
        const departmentEl = document.getElementById('Department');
        const jobTitleEl = document.getElementById('JobTitle');
        const slary_rateEl = document.getElementById('Slary_rate');
        // const salary_Range_FromEl = document.getElementById('salary_Range_From');
        // const salary_Range_ToEl = document.getElementById('salary_Range_To');
        // const salaryEl = document.getElementById('salary');
        const citizenshipEl = document.getElementById('Citizenship');
        const genderEl = document.getElementById('gender');
        const civil_statusEl = document.getElementById('civil_status');

        const lname = lnameEl.value.trim();
        const fname = fnameEl.value.trim();
        const mname = mnameEl.value.trim();
        const employeeID = employeeIDEl.value.trim();
        const department = departmentEl.value;
        const jobTitle = jobTitleEl.value.trim();
        const slary_rate = slary_rateEl.value;
        // const salary_Range_From = salary_Range_FromEl.value.trim();
        // const salary_Range_To = salary_Range_ToEl.value.trim();
        // const salary = salaryEl.value.trim();
        const citizenship = citizenshipEl.value;
        const gender = genderEl.value.trim();
        const civil_status = civil_statusEl.value.trim();

        const allFields = [
            lnameEl, fnameEl, mnameEl, employeeIDEl,
            // salary_Range_FromEl, salary_Range_ToEl, salaryEl,
            genderEl, civil_statusEl,
            departmentEl, slary_rateEl, jobTitleEl, citizenshipEl
        ];

        function showError(input, message) {
        let errorEl = input.nextElementSibling;
        if (!errorEl || !errorEl.classList.contains('input-error')) {
            errorEl = document.createElement('div');
            errorEl.classList.add('input-error');
            errorEl.style.color = 'red';
            errorEl.style.fontSize = '0.9em';
            errorEl.style.marginTop = '4px';
            errorEl.style.border = 'none'; 
            input.parentNode.insertBefore(errorEl, input.nextSibling);
        }
        errorEl.textContent = message;
        input.style.border = 'solid 1px red'; 
    }


        function clearError(input) {
        let errorEl = input.nextElementSibling;
        if (errorEl && errorEl.classList.contains('input-error')) {
            errorEl.textContent = '';
        }
        input.style.border = ''; 
    }


    allFields.forEach(el => clearError(el));

    let valid = true;

    if (!lname) { showError(lnameEl); valid = false; }
    if (!fname) { showError(fnameEl); valid = false; }
    if (!mname) { showError(mnameEl); valid = false; }
    if (!employeeID) { showError(employeeIDEl); valid = false; }
    // if (!salary_Range_From) { showError(salary_Range_FromEl); valid = false; }
    // if (!salary_Range_To) { showError(salary_Range_ToEl); valid = false; }
    // if (!salary) { showError(salaryEl); valid = false; }
    if (!civil_status) { showError(civil_statusEl); valid = false; }
    if (gender === "NO GENDER") { showError(genderEl); valid = false; }
    if (department === "NO DEPARTMENT") { showError(departmentEl); valid = false; }
    if (slary_rate === "NO SALARY RATE") { showError(slary_rateEl); valid = false; }
    if (!jobTitle) { showError(jobTitleEl); valid = false; }
    if (citizenship === "NO Citizanship") { showError(citizenshipEl); valid = false; }

    if (valid) {
        showLoaderThen(() => {
            document.getElementById("st-step").style.display = "none";
            document.getElementById("stButton").style.display = "none";

            document.getElementById("nd-step").style.display = "flex";
            document.getElementById("ndBUtton").style.display = "flex";

            document.getElementById("rd-step").style.display = "none";
            document.getElementById("rdButton").style.display = "none";
        });
    }
    }


    function disable_Button(){
        const signup = document.getElementById("button-signups");
        signup.disabled = true; 
        console.log("ehey!");

        if (signup.disabled === true) {
            signup.style.backgroundColor = "#979797"; 
        }
    }

    async function nextnd() {
        const birthdayEl = document.getElementById('birthday');
        const birthPlaceEl = document.getElementById('birthPlace');
        const contactEl = document.getElementById('contact');
        const emailEl = document.getElementById('email');
        const secheduleFromEl = document.getElementById('scheduleFrom');
        const scheduleToEl = document.getElementById('scheduleTo');
        const streetEl = document.getElementById('street');
        const barangayEl = document.getElementById('Brangay');
        const cityEl = document.getElementById('city_muntinlupa');
        const provinceEl = document.getElementById('province');
        const zipCodeEl = document.getElementById('zipCode');

        const birthday = birthdayEl.value.trim();
        const birthPlace = birthPlaceEl.value.trim();
        const contact = contactEl.value.trim();
        const email = emailEl.value.trim();
        const secheduleFrom = secheduleFromEl.value;
        const scheduleTo = scheduleToEl.value;
        const street = streetEl.value.trim();
        const barangay = barangayEl.value.trim();
        const city = cityEl.value.trim();
        const province = provinceEl.value;
        const zip_code = zipCodeEl.value.trim();

        const allFields = [
            birthdayEl, birthPlaceEl, contactEl, emailEl,
            secheduleFromEl, scheduleToEl,
            streetEl, barangayEl, cityEl, provinceEl, zipCodeEl
        ];

        function showError(input, message) {
        let errorEl = input.nextElementSibling;
        if (!errorEl || !errorEl.classList.contains('input-error')) {
            errorEl = document.createElement('div');
            errorEl.classList.add('input-error');
            errorEl.style.color = 'red';
            errorEl.style.fontSize = '0.9em';
            errorEl.style.marginTop = '4px';
            errorEl.style.border = 'none'; 
            input.parentNode.insertBefore(errorEl, input.nextSibling);
        }
        errorEl.textContent = message;
        input.style.border = 'solid 1px red'; 
    }
        function clearError(input) {
            input.style.border = '';
            let errorEl = input.nextElementSibling;
            if (errorEl && errorEl.classList.contains('input-error')) {
                errorEl.textContent = '';
            }
        }

        // Clear all previous errors
        allFields.forEach(el => clearError(el));

        let valid = true;

        if (!birthday) {
            showError(birthdayEl);
            valid = false;
        }
        if (!birthPlace) {
            showError(birthPlaceEl);
            valid = false;
        }
        if (!contact) {
            showError(contactEl);
            valid = false;
        }
        if (!email) {
            showError(emailEl, "Please enter your email.");
            valid = false;
        }
        if (!street) {
            showError(streetEl);
            valid = false;
        }
        if (!barangay) {
            showError(barangayEl);
            valid = false;
        }
        if (!city) {
            showError(cityEl);
            valid = false;
        }
        if (!zip_code) {
            showError(zipCodeEl);
            valid = false;
        }
        if (!secheduleFrom) {
            showError(secheduleFromEl);
            valid = false;
        }
        if (!scheduleTo) {
            showError(scheduleToEl);
            valid = false;
        }
        if (province === "NO PROVINCE" || !province) {
            showError(provinceEl);
            valid = false;
        }

        if (!valid) {
            return;
        }

        if (!isValidEmail(email)) {
            showError(emailEl, "Please enter a valid email address.");
            return;
        }

        try {
            const response = await fetch('emailAuth.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `email=${encodeURIComponent(email)}`
            });
            const data = await response.json();

            if (data.exists) {
                showError(emailEl, "This email is already registered.");
                return;
            }
        } catch (error) {
            showError(emailEl, "Error checking email existence. Please try again.");
            return;
        }

        showLoaderThen(() => {
            document.getElementById("st-step").style.display = "none";
            document.getElementById("stButton").style.display = "none";

            document.getElementById("nd-step").style.display = "none";
            document.getElementById("ndBUtton").style.display = "none";

            document.getElementById("rd-step").style.display = "flex";
            document.getElementById("rdButton").style.display = "flex";

            document.getElementById("button-signup-rd").style.display = "flex";
            document.getElementById("button-signups").style.display = "none";
            document.getElementById("button-signup").style.display = "none";
        });
    }

    function isValidEmail(email) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    }
    function nextrd(){
        const buttonrd = document.getElementById("nexts");
        buttonrd.disabled = true;
        console.log("ehey!");
        if (buttonrd.disabled === true) {
            console.log("COLOR CHANGED!");
            buttonrd.style.backgroundColor = "#979797"; 
        }
    }

    function backst() {
        const back = document.getElementById("backs");
        back.disabled = true; 
        console.log("ehey!");

        if (back.disabled === true) {
            back.style.backgroundColor = "#979797"; 
        }
    }
    function backnd() {
        showLoaderThen(() => {
            document.getElementById("st-step").style.display = "flex";
            document.getElementById("stButton").style.display = "flex";

            document.getElementById("nd-step").style.display = "none";
            document.getElementById("ndBUtton").style.display = "none";

            document.getElementById("rd-step").style.display = "none";
            document.getElementById("rdButton").style.display = "none";
        });
    }
    function backrd() {
        showLoaderThen(() => {
            document.getElementById("st-step").style.display = "none";
            document.getElementById("stButton").style.display = "none";

            document.getElementById("nd-step").style.display = "flex";
            document.getElementById("ndBUtton").style.display = "flex";

            document.getElementById("rd-step").style.display = "none";
            document.getElementById("rdButton").style.display = "none";

        });
    }
    async function signUP() {
   
        const profileInput = document.getElementById('profile');
        const usernameInput = document.getElementById('username');
        const passwordInput = document.getElementById('passwordInput');
        const confirmPasswordInput = document.getElementById('confirmPasswordInput');

        function showError(input, message) {
        let errorEl = input.nextElementSibling;
        if (!errorEl || !errorEl.classList.contains('input-error')) {
            errorEl = document.createElement('div');
            errorEl.classList.add('input-error');
            errorEl.style.color = 'red';
            errorEl.style.fontSize = '0.9em';
            errorEl.style.marginTop = '4px';
            errorEl.style.border = 'none'; 
            input.parentNode.insertBefore(errorEl, input.nextSibling);
        }
        errorEl.textContent = message;
        input.style.border = 'solid 2px red'; 
    }

        function clearError(input) {
            input.style.border = '';
            let errorEl = input.nextElementSibling;
            if (errorEl && errorEl.classList.contains('input-error')) {
                errorEl.textContent = '';
            }
        }

        [profileInput, usernameInput, passwordInput, confirmPasswordInput].forEach(el => {
            if (el) clearError(el);
        });

        let valid = true;

        if (!profileInput.files || profileInput.files.length === 0) {
            showError(profileInput, "Please select a profile picture.");
            valid = false;
        }

        const username = usernameInput.value.trim();
        if (!username) {
            showError(usernameInput);
            valid = false;
        }

        const password = passwordInput.value;
        const confirmPassword = confirmPasswordInput.value;

        if (!password) {
            showError(passwordInput);
            valid = false;
        }

        if (!confirmPassword) {
            showError(confirmPasswordInput);
            valid = false;
        }

        if (password && confirmPassword && password !== confirmPassword) {
            showError(passwordInput, "Passwords do not match.");
            showError(confirmPasswordInput, "Passwords do not match.");
            valid = false;
        }

        if (!valid) return;

        try {
            const response = await fetch('username.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `username=${encodeURIComponent(username)}`
            });

            const data = await response.json();

            if (data.exists) {
                showError(usernameInput, "Username is already taken. Please choose another.");
                return;
            }
        } catch (error) {
            showError(usernameInput, "Error checking username availability. Please try again.");
            return;
        }

        document.getElementById('signupForm').submit();
    }


// ===================== toast notification ===================== //

    document.addEventListener('DOMContentLoaded', function () {
            var toastEl = document.querySelector('.toast');
            if (toastEl) {
            var toast = new bootstrap.Toast(toastEl);
            toast.show();
            }
        });
  // ===================== side navs ===================== //

   function sideNav() {
        const sideHEhe = document.getElementById("sideHEhe");
        const ilahr = document.getElementById("iLeftArrowHr");
        const ilapr = document.getElementById("iLeftArrowPr");
        const hrUls = document.getElementById("hrUl");
        const payrollUl = document.getElementById("payrollUl");

        const isOpen = sideHEhe.classList.contains("opened");

        if (!isOpen) {
            sideHEhe.classList.add("opened");

            ilahr.style.display = 'flex';
            ilapr.style.display = 'flex';

            if (hrUls.classList.contains("open")) {
                hrUls.style.display = "flex";
                hrUls.style.flexDirection = "column";
                hrUls.style.maxHeight = hrUls.scrollHeight + "px";
                hrUls.style.opacity = "1";
                hrUls.style.marginTop = "0.5rem";
            }

             if (payrollUl.classList.contains("open")) {
                payrollUl.style.display = "flex";
                payrollUl.style.flexDirection = "column";
                payrollUl.style.maxHeight = payrollUl.scrollHeight + "px";
                payrollUl.style.opacity = "1";
                payrollUl.style.marginTop = "0.5rem";
            }

        } else {
            sideHEhe.classList.remove("opened");

            ilahr.style.display = 'none';
            ilapr.style.display = 'none';

            // Don't reset hrUl display directly — let hrButton handle its own toggle
            hrUls.style.maxHeight = "0";
            hrUls.style.opacity = "0";
            hrUls.style.marginTop = "0";
            payrollUl.style.maxHeight = "0";
            payrollUl.style.opacity = "0";
            payrollUl.style.marginTop = "0";
            payrollUl.classList.remove("open");
            setTimeout(() => {
                hrUls.style.display = "none";
                payrollUl.style.display = "none";
            }, 400);

        }
    }
    function hrButton() {
        const hrUl = document.getElementById("hrUl");

        if (hrUl.classList.contains("open")) {
            hrUl.style.maxHeight = "0";
            hrUl.style.opacity = "0";
            hrUl.style.marginTop = "0";
            hrUl.classList.remove("open");
            setTimeout(() => {
                hrUl.style.display = "none";
            }, 400); 
        } else {
            hrUl.style.display = "flex"; 
            hrUl.style.flexDirection = "column";
            hrUl.style.maxHeight = hrUl.scrollHeight + "px";
            hrUl.style.opacity = "1";
            hrUl.style.marginTop = "0.5rem";
            hrUl.classList.add("open");
        }
    }
    function payrollButton() {
        const payrollUl = document.getElementById("payrollUl");

        if (payrollUl.classList.contains("open")) {
            payrollUl.style.maxHeight = "0";
            payrollUl.style.opacity = "0";
            payrollUl.style.marginTop = "0";
            payrollUl.classList.remove("open");
            setTimeout(() => {
                payrollUl.style.display = "none";
            }, 400); 
        } else {
            payrollUl.style.display = "flex"; 
            payrollUl.style.flexDirection = "column"; 
            payrollUl.style.maxHeight = payrollUl.scrollHeight + "px";
            payrollUl.style.opacity = "1";
            payrollUl.style.marginTop = "0.5rem";
            payrollUl.classList.add("open");
        }
    }

// =================== JOB TITLES =========================== //

    function editJob(id, title) {
        console.log("Edit clicked", id, title); 
        document.getElementById('editJobId').value = id;
        document.getElementById('editJobTitle').value = title;
        var editModal = new bootstrap.Modal(document.getElementById('editJobModal'));
        editModal.show();
    }

    function setDeleteJobId(id) {
        document.getElementById('deleteJobId').value = id;
    }
    
// ==================== EMPLOYEE MANAGEMENT =========================== //
function showLoading() {
    const loading = document.getElementById("loadingAnimation");
    loading.style.display = "flex";
}

function hideLoading() {
    const loading = document.getElementById("loadingAnimation");
    loading.style.display = "none";
}

function getValidated() {
    showLoading();

    setTimeout(() => {
        document.getElementById("validatedList").style.display = 'flex';
        document.getElementById("validateSearch").style.display = 'flex';
        document.getElementById("validatedEmployees").style.display = 'flex';

        document.getElementById("requestList").style.display = 'none';
        document.getElementById("requestSearch").style.display = 'none';
        document.getElementById("employeesRequest").style.display = 'none';
        document.getElementById("rejectedList").style.display = 'none';
        document.getElementById("rejectedSearch").style.display = 'none';
        document.getElementById("rejectedEmployees").style.display = 'none';

        hideLoading();
    }, 800); 
}

function getRequest() {
    showLoading();

    setTimeout(() => {
        document.getElementById("requestList").style.display = 'flex';
        document.getElementById("requestSearch").style.display = 'flex';
        document.getElementById("employeesRequest").style.display = 'flex';

        document.getElementById("validatedList").style.display = 'none';
        document.getElementById("validateSearch").style.display = 'none';
        document.getElementById("validatedEmployees").style.display = 'none';
        document.getElementById("rejectedList").style.display = 'none';
        document.getElementById("rejectedSearch").style.display = 'none';
        document.getElementById("rejectedEmployees").style.display = 'none';

        hideLoading();
    }, 800); 
}

function getRejected(){
   showLoading();

    setTimeout(() => {
        document.getElementById("rejectedList").style.display = 'flex';
        document.getElementById("rejectedSearch").style.display = 'flex';
        document.getElementById("rejectedEmployees").style.display = 'flex';

        document.getElementById("requestList").style.display = 'none';
        document.getElementById("requestSearch").style.display = 'none';
        document.getElementById("employeesRequest").style.display = 'none';
        document.getElementById("validatedList").style.display = 'none';
        document.getElementById("validateSearch").style.display = 'none';
        document.getElementById("validatedEmployees").style.display = 'none';

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

// ============= END ==================== //