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

        // try {
        //     const response = await fetch('usernameAuth.php', {
        //         method: 'POST',
        //         headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        //         body: `username=${encodeURIComponent(username)}`
        //     });

        //     const data = await response.json();

        //     if (data.exists) {
        //         showError(usernameInput, "Username is already taken. Please choose another.");
        //         return;
        //     }
        // } catch (error) {
        //     showError(usernameInput, "Error checking username availability. Please try again.");
        //     return;
        // }

        document.getElementById('signupForm').submit();
    }

    // =================================== JOB AND SALARY =========================== //
