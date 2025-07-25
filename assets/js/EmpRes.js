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
function showLoaderThen(callback) {
        const loader = document.getElementById("loading-overlay");
        loader.style.display = "flex";

        setTimeout(() => {
            loader.style.display = "none";
            callback();
        }, 800); 
}

    document.addEventListener('DOMContentLoaded', function () {
        const jobTitleSelect = document.getElementById('JobTitle');
        console.log("heheWorkingOnIt!");
        if (!jobTitleSelect) {
            console.error("JobTitle select element not found!");
            return;
        }

        fetch('functions/api.php')
            .then(response => response.json())
            .then(data => {
                if (!Array.isArray(data.jobTitles)) {
                    console.error('Invalid data from API:', data);
                    return;
                }

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
    document.getElementById('employeeIDEmp').addEventListener('input', async function () {
        const employeeIDEl = this;
        const employeeIDEmp = employeeIDEl.value.trim();

        const errorClass = 'input-errors';
        let errorEl = employeeIDEl.nextElementSibling;

        if (!errorEl || !errorEl.classList.contains(errorClass)) {
            errorEl = document.createElement('div');
            errorEl.classList.add(errorClass);
            errorEl.style.fontSize = '0.9em';
            errorEl.style.marginTop = '4px';
            employeeIDEl.parentNode.insertBefore(errorEl, employeeIDEl.nextSibling);
        }

        errorEl.textContent = '';
        employeeIDEl.style.border = '';

        if (employeeIDEmp === '') return;

        try {
            console.log("ABCABC");
            const response = await fetch('functions/employeeIDAuth.php', {
                
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `employeeID=${encodeURIComponent(employeeIDEmp)}`
            });

            const data = await response.json();

            if (data.exists) {
                errorEl.textContent = "This Employee ID already exists.";
                errorEl.style.color = 'red';
                employeeIDEl.style.border = 'solid 1px red';
            } else {
                errorEl.textContent = "✅ Employee ID is available.";
                errorEl.style.color = 'green';
                employeeIDEl.style.border = 'solid 1px green';
            }
        } catch (error) {
            errorEl.textContent = "⚠️ Error checking Employee ID.";
            errorEl.style.color = 'orange';
            employeeIDEl.style.border = 'solid 1px orange';
        }
    });
function nextst() {
        const lnameEl = document.getElementById('surname');
        const fnameEl = document.getElementById('fname');
        const mnameEl = document.getElementById('mname');
        const employeeIDEl = document.getElementById('employeeIDEmp');
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
    if (citizenship === "NO Citizenship") { showError(citizenshipEl); valid = false; }

    if (valid) {
        showLoaderThen(() => {
            document.getElementById("st-step").style.display = "none";
            document.getElementById("stButton").style.display = "none";

            document.getElementById("nd-step").style.display = "flex";
            document.getElementById("ndBUtton").style.display = "flex";

            document.getElementById("rd-step").style.display = "none";
            document.getElementById("rdButton").style.display = "none";

            document.getElementById("button-signup-rd").style.display = "none";
            document.getElementById("button-signups").style.display = "flex";
            document.getElementById("button-signup").style.display = "none";
        });
    }
    }

    // next second
    function isValidEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}

function isValidContactNumber(number) {
    return /^[0-9]{11}$/.test(number);
}

function showLiveError(input, message, color = 'red') {
    let errorEl = input.nextElementSibling;
    if (!errorEl || !errorEl.classList.contains('input-errors')) {
        errorEl = document.createElement('div');
        errorEl.classList.add('input-errors');
        errorEl.style.fontSize = '0.9em';
        errorEl.style.marginTop = '4px';
        input.parentNode.insertBefore(errorEl, input.nextSibling);
    }
    errorEl.textContent = message;
    errorEl.style.color = color;
    // input.style.border = `solid 1px ${color}`;
}

function clearLiveError(input) {
    input.style.border = '';
    const errorEl = input.nextElementSibling;
    if (errorEl && errorEl.classList.contains('input-errors')) {
        errorEl.textContent = '';
    }
}

document.addEventListener("DOMContentLoaded", () => {
    const contactInput = document.getElementById('contactEmp');
    const emailInput = document.getElementById('emailEmp');

    contactInput.addEventListener('input', () => {
        const value = contactInput.value.trim();

        if (!value) {
            clearLiveError(contactInput);
            return;
        }

        if (!/^\d+$/.test(value)) {
            showLiveError(contactInput, "Contact number must contain only digits.");
        } else if (value.length !== 11) {
            showLiveError(contactInput, "Contact number must be exactly 11 digits.");
        } else {
            clearLiveError(contactInput);
        }
    });

    emailInput.addEventListener('input', async () => {
        const email = emailInput.value.trim();

        if (!email) {
            clearLiveError(emailInput);
            return;
        }

        if (!isValidEmail(email)) {
            showLiveError(emailInput, "Invalid email format.");
            return;
        }

        try {
            const response = await fetch('functions/emailAuth.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `email=${encodeURIComponent(email)}`
            });

            const data = await response.json();

            if (data.exists) {
                showLiveError(emailInput, "This email is already registered.");
            } else {
                showLiveError(emailInput, "✅ Email is available.", 'green');
            }
        } catch (err) {
            showLiveError(emailInput, "⚠️ Error checking email.", 'orange');
        }
    });
});


async function nextnd() {
    const birthdayEl = document.getElementById('birthday');
    const birthPlaceEl = document.getElementById('birthPlace');
    const contactEl = document.getElementById('contactEmp');
    const emailEl = document.getElementById('emailEmp');
    const secheduleFromEl = document.getElementById('scheduleFrom');
    const scheduleToEl = document.getElementById('scheduleTo');
    const streetEl = document.getElementById('street');
    const barangayEl = document.getElementById('Brangay');
    const cityEl = document.getElementById('city_muntinlupa');
    const provinceEl = document.getElementById('province');
    const zipCodeEl = document.getElementById('zipCode');

    const elements = {
        birthdayEl, birthPlaceEl, contactEl, emailEl,
        secheduleFromEl, scheduleToEl, streetEl,
        barangayEl, cityEl, provinceEl, zipCodeEl
    };

    // Check for missing elements
    for (const [key, el] of Object.entries(elements)) {
        if (!el) {
            console.error(`Missing element with id: ${key}`);
            alert(`Developer Error: Missing element with id '${key}'`);
            return; // Exit early
        }
    }

    // Now safe to access .value
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
        if (!errorEl || !errorEl.classList.contains('input-errors')) {
            errorEl = document.createElement('div');
            errorEl.classList.add('input-errors');
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

        // try {
        //     const response = await fetch('emailAuth.php', {
        //         method: 'POST',
        //         headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        //         body: `email=${encodeURIComponent(email)}`
        //     });
        //     const data = await response.json();

        //     if (data.exists) {
        //         showError(emailEl, "This email is already registered.");
        //         return;
        //     }
        // } catch (error) {
        //     showError(emailEl, "Error checking email existence. Please try again.");
        //     return;
        // }

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

    const passwordInput = document.getElementById('passwordInputEmp');
    const showPassword = document.getElementById('showPasswordEmp');
    const hidePassword = document.getElementById('hidePasswordEmp');

    const confirmPasswordInput = document.getElementById('confirmPasswordInputEmp');
    const showConfirmPassword = document.getElementById('showConfirmPasswordEmp');
    const hideConfirmPassword = document.getElementById('hideConfirmPasswordEmp');

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
document.addEventListener('DOMContentLoaded', () => {
    const usernameInput = document.getElementById('usernameEmp');
    const passwordInput = document.getElementById('passwordInputEmp');
    const confirmPasswordInput = document.getElementById('confirmPasswordInputEmp');
    const profileInput = document.getElementById('profileEmp');
    const form = document.getElementById('signupFormEmp');

    function showError(input, message, color = 'red') {
        let errorEl = input.nextElementSibling;
        if (!errorEl || !errorEl.classList.contains('input-errors')) {
            errorEl = document.createElement('div');
            errorEl.classList.add('input-errors');
            errorEl.style.fontSize = '0.9em';
            errorEl.style.marginTop = '4px';
            input.parentNode.insertBefore(errorEl, input.nextSibling);
        }
        errorEl.textContent = message;
        errorEl.style.color = color;
        input.style.border = `1px solid ${color}`;
    }

    function clearError(input) {
        input.style.border = '';
        let errorEl = input.nextElementSibling;
        if (errorEl && errorEl.classList.contains('input-errors')) {
            errorEl.textContent = '';
        }
    }

    function isStrongPassword(password) {
        const regex = /^(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/;
        return regex.test(password);
    }

    usernameInput.addEventListener('input', async function () {
        const username = usernameInput.value.trim();
        clearError(usernameInput);

        if (username === '') return;

        try {
            const response = await fetch('functions/usernameAuth.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `username=${encodeURIComponent(username)}`
            });

            const data = await response.json();

            if (data.exists) {
                showError(usernameInput, "Username is already taken.");
            } else {
                showError(usernameInput, "✅ Username is available.", 'green');
            }
        } catch (error) {
            showError(usernameInput, "⚠️ Error checking username.", 'orange');
        }
    });

    confirmPasswordInput.addEventListener('input', function () {
        const password = passwordInput.value;
        const confirmPassword = confirmPasswordInput.value;

        clearError(confirmPasswordInput);
        clearError(passwordInput);

        if (confirmPassword === '') return;

        if (password !== confirmPassword) {
            showError(confirmPasswordInput, "Passwords do not match.");
            showError(passwordInput, "Passwords do not match.");
        } else if (!isStrongPassword(password)) {
            showError(passwordInput, "Password must be at least 8 chars, 1 capital, 1 special char, 1 number.");
        } else {
            showError(confirmPasswordInput, "✅ Passwords match.", 'green');
        }
    });

    form.addEventListener('submit', function (e) {
        let valid = true;

        clearError(profileInput);
        clearError(usernameInput);
        clearError(passwordInput);
        clearError(confirmPasswordInput);

        // if (!profileInput.files || profileInput.files.length === 0) {
        //     showError(profileInput, "Please select a profile picture.");
        //     valid = false;
        // }

        const username = usernameInput.value.trim();
        const password = passwordInput.value;
        const confirmPassword = confirmPasswordInput.value;

        if (!username) {
            showError(usernameInput, "Username is required.");
            valid = false;
        }

        if (!password) {
            showError(passwordInput, "Password is required.");
            valid = false;
        } else if (!isStrongPassword(password)) {
            showError(passwordInput, "Password must be at least 8 chars, 1 capital, 1 special char, 1 number.");
            valid = false;
        }

        if (!confirmPassword) {
            showError(confirmPasswordInput, "Please confirm your password.");
            valid = false;
        }

        if (password && confirmPassword && password !== confirmPassword) {
            showError(passwordInput, "Passwords do not match.");
            showError(confirmPasswordInput, "Passwords do not match.");
            valid = false;
        }

        if (!valid) e.preventDefault();
    });
});
