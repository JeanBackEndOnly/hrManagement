function personalInfo() {
    console.log("Personal Information!");
    showLoadingAndRun(() => {}, [
        "personalID",
        "updateButton",
        "personalInformation",
        "personalProfileInformation"
    ]);
}

function familyBG() {
    console.log("Family Background!");
    showLoadingAndRun(() => {}, [
        "familybg",
        "updateButtonFBG",
        "familyInformation",
        "familyProfileInformation"
    ]);
}

function educationalBG() {
    console.log("Educational Background!");
    showLoadingAndRun(() => {}, [
        "educationalbg",
        "updateButtonEBG",
        "educationalInformation",
        "educationProfileInformation"
    ]);
}

function showSection(visibleIds) {
    const allSections = [
        "personalID",
        "familybg",
        "educationalbg",
        "updateButton",
        "updateButtonFBG",
        "updateButtonEBG",
        "educationalInformation",
        "familyInformation",
        "personalInformation",
        "educationProfileInformation",
        "familyProfileInformation",
        "personalProfileInformation"
    ];

    allSections.forEach(id => {
        const el = document.getElementById(id);
        if (el) {
            el.style.display = visibleIds.includes(id) ? 'flex' : 'none';
        }
    });
}

window.addEventListener("load", function () {
    const urlParams = new URLSearchParams(window.location.search);
    const tab = urlParams.get("tab") || "personal";

    const tabMap = {
        personal: { btnId: "Personal", action: personalInfo },
        family: { btnId: "Family", action: familyBG },
        educational: { btnId: "Educational", action: educationalBG }
    };

    const tabConfig = tabMap[tab] || tabMap["personal"];
    const btn = document.getElementById(tabConfig.btnId);
    if (btn) activateTab(btn);
    tabConfig.action();
});


function showLoaderThen(callback) {
        const loader = document.getElementById("loading-overlay");
        loader.style.display = "flex";

        setTimeout(() => {
            loader.style.display = "none";
            callback();
        }, 800); 
    }

    // ======================= ADMIN REGISTRATION FOR EMPLOYEE ============================== //

function previewImage(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                console.log("Image Loaded: ", e.target.result);
                document.getElementById("imageIDAdmin").src = e.target.result;
            };
            reader.readAsDataURL(file);
        } else {
            console.log("No file selected");
        }
}
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

    const passwordInput = document.getElementById('passwordInputAdmin');
    const showPassword = document.getElementById('showPasswordAdmin');
    const hidePassword = document.getElementById('hidePasswordAdmin');

    const confirmPasswordInput = document.getElementById('confirmPasswordInputAdmin');
    const showConfirmPassword = document.getElementById('showConfirmPasswordAdmin');
    const hideConfirmPassword = document.getElementById('hideConfirmPasswordAdmin');

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
function nextstA() {
        const lnameEl = document.getElementById('surname');
        const fnameEl = document.getElementById('fname');
        const mnameEl = document.getElementById('mname');
        const employeeIDEl = document.getElementById('employeeID');
        const departmentEl = document.getElementById('Department');
        const jobTitleEl = document.getElementById('Job_Title');
        const slary_rateEl = document.getElementById('Slary_rate');
        const salary_Range_FromEl = document.getElementById('salary_Range_From');
        const salary_Range_ToEl = document.getElementById('salary_Range_To');
        const salaryEl = document.getElementById('salary');
        const citizenshipEl = document.getElementById('Citizenship');
        const genderEl = document.getElementById('gender');
        const civil_statusEl = document.getElementById('civil_status');

        const lname = lnameEl.value.trim();
        const fname = fnameEl.value.trim();
        const mname = mnameEl.value.trim();
        const employeeID = employeeIDEl.value.trim();
        const department = departmentEl.value;
        const job_Title = jobTitleEl.value;
        const slary_rate = slary_rateEl.value;
        const salary_Range_From = salary_Range_FromEl.value.trim();
        const salary_Range_To = salary_Range_ToEl.value.trim();
        const salary = salaryEl.value.trim();
        const citizenship = citizenshipEl.value;
        const gender = genderEl.value.trim();
        const civil_status = civil_statusEl.value.trim();

        const allFields = [
            lnameEl, fnameEl, mnameEl, employeeIDEl,
            salary_Range_FromEl, salary_Range_ToEl, salaryEl,
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
        if (!salary_Range_From) { showError(salary_Range_FromEl); valid = false; }
        if (!salary_Range_To) { showError(salary_Range_ToEl); valid = false; }
        if (!salary) { showError(salaryEl); valid = false; }
        if (!civil_status) { showError(civil_statusEl); valid = false; }
        if (gender === "NO GENDER") { showError(genderEl); valid = false; }
        if (department === "NO DEPARTMENT") { showError(departmentEl); valid = false; }
        if (slary_rate === "NO SALARY RATE") { showError(slary_rateEl); valid = false; }
        if (!job_Title) { showError(jobTitleEl); valid = false; }
        if (citizenship === "NO Citizanship") { showError(citizenshipEl); valid = false; }

        if (valid) {
            showLoaderThen(() => {
                document.getElementById("st-stepA").style.display = "none";
                document.getElementById("stButtonA").style.display = "none";

                document.getElementById("nd-stepA").style.display = "block";
                document.getElementById("ndBUttonA").style.display = "flex";

                document.getElementById("rd-stepA").style.display = "none";
                document.getElementById("rdButtonA").style.display = "none";
            });
        }
}

function disable_Button(){
        const signup = document.getElementById("button-signupA");
        signup.disabled = true; 
        console.log("ehey!");

        if (signup.disabled === true) {
            signup.style.backgroundColor = "#979797"; 
        }
}

async function nextndA() {
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
            const response = await fetch('../emailAuth.php', {
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
            document.getElementById("st-stepA").style.display = "none";
            document.getElementById("stButtonA").style.display = "none";

            document.getElementById("nd-stepA").style.display = "none";
            document.getElementById("ndBUttonA").style.display = "none";

            document.getElementById("rd-stepA").style.display = "flex";
            document.getElementById("rdButtonA").style.display = "flex";

            document.getElementById("button-signup-rdA").style.display = "flex";
            document.getElementById("button-signupA").style.display = "none";
        });
}

document.addEventListener('DOMContentLoaded', () => {
    const emailEl = document.getElementById('email');

    function showError(input, message) {
        let messageEl = input.nextElementSibling;
        if (!messageEl || !messageEl.classList.contains('input-message')) {
            messageEl = document.createElement('div');
            messageEl.classList.add('input-message');
            messageEl.style.fontSize = '0.9em';
            messageEl.style.marginTop = '4px';
            input.parentNode.insertBefore(messageEl, input.nextSibling);
        }
        messageEl.textContent = message;
        messageEl.style.color = 'red';
        input.style.border = 'solid 1px red';
    }

    function showSuccess(input, message) {
        let messageEl = input.nextElementSibling;
        if (!messageEl || !messageEl.classList.contains('input-message')) {
            messageEl = document.createElement('div');
            messageEl.classList.add('input-message');
            messageEl.style.fontSize = '0.9em';
            messageEl.style.marginTop = '4px';
            input.parentNode.insertBefore(messageEl, input.nextSibling);
        }
        messageEl.textContent = message;
        messageEl.style.color = 'green';
        input.style.border = 'solid 1px green';
    }

    function clearMessage(input) {
        input.style.border = '';
        let messageEl = input.nextElementSibling;
        if (messageEl && messageEl.classList.contains('input-message')) {
            messageEl.textContent = '';
        }
    }

    function isValidEmail(email) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    }

    async function validateEmailLive() {
        const email = emailEl.value.trim();
        clearMessage(emailEl);

        if (!email) {
            showError(emailEl, "Email is required.");
            return;
        }

        if (!isValidEmail(email)) {
            showError(emailEl, "Invalid email format.");
            return;
        }

        try {
            const response = await fetch('../emailAuth.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `email=${encodeURIComponent(email)}`
            });

            const data = await response.json();

            if (data.exists) {
                showError(emailEl, "This email is already registered.");
            } else {
                showSuccess(emailEl, "✔️ Valid email and available.");
            }
        } catch (err) {
            showError(emailEl, "Error checking email. Try again.");
        }
    }

    // Debounce
    function debounce(func, delay) {
        let timeout;
        return function (...args) {
            clearTimeout(timeout);
            timeout = setTimeout(() => func.apply(this, args), delay);
        };
    }

    emailEl.addEventListener('input', debounce(validateEmailLive, 500));
});


function isValidEmail(email) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
}
function nextrdA(){
        const buttonrd = document.getElementById("nexts");
        buttonrd.disabled = true;
        console.log("ehey!");
        if (buttonrd.disabled === true) {
            console.log("COLOR CHANGED!");
            buttonrd.style.backgroundColor = "#979797"; 
        }
}

function backstA() {
        const back = document.getElementById("backsA");
        back.disabled = true; 
        console.log("ehey!lolo");

        if (back.disabled === true) {
            back.style.backgroundColor = "#979797"; 
        }
}
function backndA() {
        showLoaderThen(() => {
            document.getElementById("st-stepA").style.display = "flex";
            document.getElementById("stButtonA").style.display = "flex";

            document.getElementById("nd-stepA").style.display = "none";
            document.getElementById("ndBUttonA").style.display = "none";

            document.getElementById("rd-stepA").style.display = "none";
            document.getElementById("rdButtonA").style.display = "none";
        });
}
function backrdA() {
        showLoaderThen(() => {
            document.getElementById("st-stepA").style.display = "none";
            document.getElementById("stButtonA").style.display = "none";

            document.getElementById("nd-stepA").style.display = "flex";
            document.getElementById("ndBUttonA").style.display = "flex";

            document.getElementById("rd-stepA").style.display = "none";
            document.getElementById("rdButtonA").style.display = "none";

        });
}
document.addEventListener('DOMContentLoaded', () => {
    const profileInput = document.getElementById('profile');
    const usernameInput = document.getElementById('username');
    const passwordInput = document.getElementById('passwordInput');
    const confirmPasswordInput = document.getElementById('confirmPasswordInput');

    function showError(input, message) {
    removeMessage(input);
    const msg = document.createElement('div');
    msg.classList.add('input-error');
    msg.style.color = 'red';
    msg.style.fontSize = '0.9em';
    msg.style.marginTop = '4px';
    msg.style.border = 'none';
    msg.textContent = message;

    const wrapper = input.closest('li');
    if (wrapper) {
        wrapper.insertAdjacentElement('afterend', msg);
    }

    input.style.border = '2px solid red';
}

function showSuccess(input, message) {
    removeMessage(input);
    const msg = document.createElement('div');
    msg.classList.add('input-success');
    msg.style.color = 'green';
    msg.style.fontSize = '0.9em';
    msg.style.marginTop = '4px';
    msg.style.border = 'none';
    msg.textContent = message;

    const wrapper = input.closest('li');
    if (wrapper) {
        wrapper.insertAdjacentElement('afterend', msg);
    }

    input.style.border = '2px solid green';
}

function removeMessage(input) {
    input.style.border = '';
    const wrapper = input.closest('li');
    if (wrapper && wrapper.nextElementSibling) {
        const sibling = wrapper.nextElementSibling;
        if (sibling.classList.contains('input-error') || sibling.classList.contains('input-success')) {
            sibling.remove();
        }
    }
}


    async function validateUsername() {
        const username = usernameInput.value.trim();
        removeMessage(usernameInput);
        if (!username) return;

        try {
            const response = await fetch('../usernameAuth.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `username=${encodeURIComponent(username)}`
            });
            const data = await response.json();
            if (data.exists) {
                showError(usernameInput, "Username is already taken.");
            } else {
                showSuccess(usernameInput, "✓ Username is available.");
            }
        } catch (error) {
            showError(usernameInput, "Error checking username. Try again.");
        }
    }

    function validatePasswords() {
        const password = passwordInput.value;
        const confirmPassword = confirmPasswordInput.value;

        removeMessage(passwordInput);
        removeMessage(confirmPasswordInput);

        const errors = [];

        if (password.length < 8) {
            errors.push("Password must be at least 8 characters.");
        }

        if (!/[A-Z]/.test(password)) {
            errors.push("Password must contain at least one uppercase letter.");
        }

        if (!/[0-9]/.test(password)) {
            errors.push("Password must contain at least one number.");
        }

        if (!/[!@#$%^&*(),.?":{}|<>]/.test(password)) {
            errors.push("Password must contain at least one special character (e.g. #, !, @).");
        }

        if (errors.length > 0) {
            showError(passwordInput, errors[0]); // show first error
            return;
        } else {
            showSuccess(passwordInput, "✓ Password is strong.");
        }

        // Confirm password match
        if (!confirmPassword) {
            removeMessage(confirmPasswordInput);
            return;
        }

        if (password !== confirmPassword) {
            showError(confirmPasswordInput, "Passwords do not match.");
        } else {
            showSuccess(confirmPasswordInput, "✓ Passwords match.");
        }
    }

    function validateProfile() {
        removeMessage(profileInput);
        if (!profileInput.files || profileInput.files.length === 0) {
            showError(profileInput, "Please select a profile picture.");
        } else {
            showSuccess(profileInput, "✓ Profile picture selected.");
        }
    }

    // Debounce utility to limit server requests
    function debounce(func, delay) {
        let timeout;
        return function (...args) {
            clearTimeout(timeout);
            timeout = setTimeout(() => func.apply(this, args), delay);
        };
    }

    // Attach listeners
    usernameInput.addEventListener('input', debounce(validateUsername, 500));
    passwordInput.addEventListener('input', validatePasswords);
    confirmPasswordInput.addEventListener('input', validatePasswords);
    profileInput.addEventListener('change', validateProfile);
});
    // =================================== JOB AND SALARY =========================== //
