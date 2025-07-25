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
            console.log("Working Employee ID");
        console.log("Selected Job Title is:", selectedJobTitle);

        if (!jobTitleSelect) {
            console.error("JobTitle select element not found!");
            return;
        }

        fetch('../functions/api.php')
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
document.addEventListener('DOMContentLoaded', function () {

    document.getElementById('employeeID').addEventListener('input', async function () {
            console.log("Working Employee ID");
        const employeeIDEl = this;
        const employeeID = employeeIDEl.value.trim();

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

        if (employeeID === '') return;

        try {
            const response = await fetch('../functions/employeeIDAuth.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `employeeID=${encodeURIComponent(employeeID)}`
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
            errorEl.textContent = "Error checking Employee ID.";
            errorEl.style.color = '#000';
            employeeIDEl.style.border = 'solid 1px red';
        }
    });
});
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

(function () {
  /* ===== helper: wait for DOM ===== */
  document.addEventListener('DOMContentLoaded', initWizard);

  function initWizard() {
    /* -----------------------------------------------------------
       Section 1 – generic helpers
    ----------------------------------------------------------- */
    const form = document.getElementById('signupForm');

    /* spinner overlay (the same delay you used earlier) */
    window.showLoaderThen = function (callback) {
      const overlay = document.getElementById('loading-overlay');
      if (overlay) overlay.style.display = 'flex';
      setTimeout(() => {
        if (overlay) overlay.style.display = 'none';
        callback();
      }, 800);
    };

    /* step toggling + enable/disable controls */
    window.switchStep = function (currentStepEl, nextStepEl) {
      currentStepEl
        .querySelectorAll('input, select, textarea')
        .forEach((el) => (el.disabled = true));
      currentStepEl.style.display = 'none';

      nextStepEl
        .querySelectorAll('input, select, textarea')
        .forEach((el) => (el.disabled = false));
      nextStepEl.style.display = 'flex';
    };

    ['nd-stepA', 'rd-stepA'].forEach((id) => {
      const step = document.getElementById(id);
      if (step) {
        step
          .querySelectorAll('input, select, textarea')
          .forEach((el) => (el.disabled = true));
      }
    });

    /* Re-enable EVERYTHING just before the real submit          */
    form.addEventListener('submit', () => {
      form.querySelectorAll('[disabled]').forEach((el) => (el.disabled = false));
    });
 window.nextstA = async function () {
      /* === original validation block === */
    const lnameEl = document.getElementById('surname');
    const fnameEl = document.getElementById('fname');
    const mnameEl = document.getElementById('mname');
    const citizenshipEl = document.getElementById('Citizenship');
    const genderEl = document.getElementById('gender');
    const civil_statusEl = document.getElementById('civil_status');
    const birthdayEl = document.getElementById('birthday');
    const birthPlaceEl = document.getElementById('birthPlace');
    const contactEl = document.getElementById('contact');
    const emailEl = document.getElementById('email');
    const slary_rateEl = document.getElementById('Slary_rate');
    const salary_Range_FromEl = document.getElementById('salary_Range_From');
    const salary_Range_ToEl = document.getElementById('salary_Range_To');

    const birthday = birthdayEl.value.trim();
    const birthPlace = birthPlaceEl.value.trim();
    const contact = contactEl.value.trim();
    const email = emailEl.value.trim();
    const lname = lnameEl.value.trim();
    const fname = fnameEl.value.trim();
    const mname = mnameEl.value.trim();
    const slary_rate = slary_rateEl.value;
    const salary_Range_From = salary_Range_FromEl.value.trim();
    const salary_Range_To = salary_Range_ToEl.value.trim();
    const citizenship = citizenshipEl.value;
    const gender = genderEl.value.trim();
    const civil_status = civil_statusEl.value.trim();

      const allFields = [
        lnameEl,
        fnameEl,
        mnameEl,
        salary_Range_FromEl,
        salary_Range_ToEl,
        genderEl,
        civil_statusEl,
        slary_rateEl,
        citizenshipEl,
        birthdayEl, birthPlaceEl, contactEl, emailEl,
      ];

      function showError(input, message = '') {
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
      allFields.forEach(clearError);

      let valid = true;
      if (!birthday) {
            showError(birthdayEl); valid = false;
        }
        if (!birthPlace) {
            showError(birthPlaceEl); valid = false;
        }
        if (!contact) {
            showError(contactEl); valid = false;
        }
        if (!email) {
            showError(emailEl, "Please enter your email."); valid = false;
        }
      if (!lname) showError(lnameEl), (valid = false);
      if (!fname) showError(fnameEl), (valid = false);
      if (!mname) showError(mnameEl), (valid = false);
      if (!salary_Range_From) showError(salary_Range_FromEl), (valid = false);
      if (!salary_Range_To) showError(salary_Range_ToEl), (valid = false);
    
      if (!civil_status) showError(civil_statusEl), (valid = false);
      if (gender === 'NO GENDER') showError(genderEl), (valid = false);
    
      if (slary_rate === 'NO SALARY RATE')
        showError(slary_rateEl), (valid = false);
    
      if (citizenship === 'NO Citizanship')
        showError(citizenshipEl), (valid = false);
       if (!isValidEmail(email)) {
            showError(emailEl, "Please enter a valid email address.");
            return;
        }
        try {
            const response = await fetch('../functions/emailAuth.php', {
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
      /* === on success, switch step === */
      if (valid) {
        showLoaderThen(() => {
          switchStep(
            document.getElementById('st-stepA'),
            document.getElementById('nd-stepA')
          );
          document.getElementById('stButtonA').style.display = 'none';
          document.getElementById('ndBUttonA').style.display = 'flex';
        });
      }
    };

function disable_Button(){
        const signup = document.getElementById("button-signupA");
        signup.disabled = true; 
        console.log("ehey!");

        if (signup.disabled === true) {
            signup.style.backgroundColor = "#979797"; 
        }
}

  window.nextndA = async function () {
    const employeeIDEl = document.getElementById('employeeID');
    const departmentEl = document.getElementById('Department');
    const jobTitleEl = document.getElementById('Job_Title');
    const salaryEl = document.getElementById('salary');
    const scheduleFromEl = document.getElementById('scheduleFrom');
    const scheduleToEl = document.getElementById('scheduleTo');
    const streetEl = document.getElementById('street');
    const barangayEl = document.getElementById('Brangay');
    const cityEl = document.getElementById('city_muntinlupa');
    const provinceEl = document.getElementById('province');
    const zipCodeEl = document.getElementById('zipCode');

    const employeeID = employeeIDEl.value.trim();
    const department = departmentEl.value;
    const job_Title = jobTitleEl.value;
    const salary = salaryEl.value.trim();
    const secheduleFrom = scheduleFromEl.value;
    const scheduleTo = scheduleToEl.value;
    const street = streetEl.value.trim();
    const barangay = barangayEl.value.trim();
    const city = cityEl.value.trim();
    const province = provinceEl.value;
    const zip_code = zipCodeEl.value.trim();

    const allFields = [
            scheduleFromEl, scheduleToEl,
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
        if (department === 'NO DEPARTMENT')
            showError(departmentEl), (valid = false);
          if (!job_Title) showError(jobTitleEl), (valid = false);
        if (!employeeID) showError(employeeIDEl), (valid = false);
          if (!salary) showError(salaryEl), (valid = false);
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
            showError(scheduleFromEl);
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

        if (valid) {
        showLoaderThen(() => {
          switchStep(
            document.getElementById('nd-stepA'),
            document.getElementById('rd-stepA')
          );
          document.getElementById('ndBUttonA').style.display = 'none';
          document.getElementById('rdButtonA').style.display = 'flex';
          /* swap the final NEXT/SUBMIT buttons */
          document.getElementById('button-signupA').style.display = 'none';
          document.getElementById('button-signup-rdA').style.display = 'flex';
        });
      }
};
window.backndA = function () {
      showLoaderThen(() => {
        switchStep(
          document.getElementById('nd-stepA'),
          document.getElementById('st-stepA')
        );
        document.getElementById('ndBUttonA').style.display = 'none';
        document.getElementById('stButtonA').style.display = 'flex';
      });
    };

    window.backrdA = function () {
      showLoaderThen(() => {
        switchStep(
          document.getElementById('rd-stepA'),
          document.getElementById('nd-stepA')
        );
        document.getElementById('rdButtonA').style.display = 'none';
        document.getElementById('ndBUttonA').style.display = 'flex';
        document.getElementById('button-signup-rdA').style.display = 'none';
        document.getElementById('button-signupA').style.display = 'flex';
      });
    };
  }
})();

document.addEventListener("DOMContentLoaded", () => {
    const contactInput = document.getElementById('contact');
    const emailInput = document.getElementById('email');

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
            const response = await fetch('emailAuth.php', {
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

// document.addEventListener('DOMContentLoaded', () => {
//     const profileInput = document.getElementById('profile');
//     const usernameInput = document.getElementById('username');
//     const passwordInput = document.getElementById('passwordInput');
//     const confirmPasswordInput = document.getElementById('confirmPasswordInput');

//     function showError(input, message) {
//     removeMessage(input);
//     const msg = document.createElement('div');
//     msg.classList.add('input-error');
//     msg.style.color = 'red';
//     msg.style.fontSize = '0.9em';
//     msg.style.marginTop = '4px';
//     msg.style.border = 'none';
//     msg.textContent = message;

//     const wrapper = input.closest('li');
//     if (wrapper) {
//         wrapper.insertAdjacentElement('afterend', msg);
//     }

//     input.style.border = '2px solid red';
// }

// function showSuccess(input, message) {
//     removeMessage(input);
//     const msg = document.createElement('div');
//     msg.classList.add('input-success');
//     msg.style.color = 'green';
//     msg.style.fontSize = '0.9em';
//     msg.style.marginTop = '4px';
//     msg.style.border = 'none';
//     msg.textContent = message;

//     const wrapper = input.closest('li');
//     if (wrapper) {
//         wrapper.insertAdjacentElement('afterend', msg);
//     }

//     input.style.border = '2px solid green';
// }

// function removeMessage(input) {
//     input.style.border = '';
//     const wrapper = input.closest('li');
//     if (wrapper && wrapper.nextElementSibling) {
//         const sibling = wrapper.nextElementSibling;
//         if (sibling.classList.contains('input-error') || sibling.classList.contains('input-success')) {
//             sibling.remove();
//         }
//     }
// }


//     async function validateUsername() {
//         const username = usernameInput.value.trim();
//         removeMessage(usernameInput);
//         if (!username) return;

//         try {
//             const response = await fetch('../usernameAuth.php', {
//                 method: 'POST',
//                 headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
//                 body: `username=${encodeURIComponent(username)}`
//             });
//             const data = await response.json();
//             if (data.exists) {
//                 showError(usernameInput, "Username is already taken.");
//             } else {
//                 showSuccess(usernameInput, "✓ Username is available.");
//             }
//         } catch (error) {
//             showError(usernameInput, "Error checking username. Try again.");
//         }
//     }

//     function validatePasswords() {
//         const password = passwordInput.value;
//         const confirmPassword = confirmPasswordInput.value;

//         removeMessage(passwordInput);
//         removeMessage(confirmPasswordInput);

//         const errors = [];

//         if (password.length < 8) {
//             errors.push("Password must be at least 8 characters.");
//         }

//         if (!/[A-Z]/.test(password)) {
//             errors.push("Password must contain at least one uppercase letter.");
//         }

//         if (!/[0-9]/.test(password)) {
//             errors.push("Password must contain at least one number.");
//         }

//         if (!/[!@#$%^&*(),.?":{}|<>]/.test(password)) {
//             errors.push("Password must contain at least one special character (e.g. #, !, @).");
//         }

//         if (errors.length > 0) {
//             showError(passwordInput, errors[0]); 
//             return;
//         } else {
//             showSuccess(passwordInput, "✓ Password is strong.");
//         }
//         if (!confirmPassword) {
//             removeMessage(confirmPasswordInput);
//             return;
//         }

//         if (password !== confirmPassword) {
//             showError(confirmPasswordInput, "Passwords do not match.");
//         } else {
//             showSuccess(confirmPasswordInput, "✓ Passwords match.");
//         }
//     }

//     function validateProfile() {
//         removeMessage(profileInput);
//         if (!profileInput.files || profileInput.files.length === 0) {
//             showError(profileInput, "Please select a profile picture.");
//         } else {
//             showSuccess(profileInput, "✓ Profile picture selected.");
//         }
//     }
//     function debounce(func, delay) {
//         let timeout;
//         return function (...args) {
//             clearTimeout(timeout);
//             timeout = setTimeout(() => func.apply(this, args), delay);
//         };
//     }
//     usernameInput.addEventListener('input', debounce(validateUsername, 500));
//     passwordInput.addEventListener('input', validatePasswords);
//     confirmPasswordInput.addEventListener('input', validatePasswords);
//     profileInput.addEventListener('change', validateProfile);
// });



document.addEventListener('DOMContentLoaded', () => {
    const usernameInput = document.getElementById('username');
    const passwordInput = document.getElementById('passwordInputAdmin');
    const confirmPasswordInput = document.getElementById('confirmPasswordInputAdmin');
    const profileInput = document.getElementById('profile');
    const form = document.getElementById('signupForm');

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
            const response = await fetch('usernameAuth.php', {
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
