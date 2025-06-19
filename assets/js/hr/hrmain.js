    // ================== TOAST NOTIFICATION ================== //
    document.addEventListener('DOMContentLoaded', () => {
        if (newNotMatched) {
            console.log("Showing updateReq toast");
            Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'error',
            title: 'Password not match!.',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            customClass: { popup: 'swal2-row-toast' }
            });
            removeUrlParams(['password']);
        }else if (currentNotMatched) {
            console.log("Showing updateReq toast");
            Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'error',
            title: 'Current password not match!.',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            customClass: { popup: 'swal2-row-toast' }
            });
            removeUrlParams(['password']);
        }else if (currentNotMatched) {
            console.log("Showing updateReq toast");
            Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'error',
            title: 'Current password not match!.',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            customClass: { popup: 'swal2-row-toast' }
            });
            removeUrlParams(['password']);
        }else if (password) {
            console.log("Showing updateReq toast");
            Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: 'Password changed successfully!.',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            customClass: { popup: 'swal2-row-toast' }
            });
            removeUrlParams(['password']);
        }
        function removeUrlParams(params) {
            const url = new URL(window.location);
            params.forEach(param => url.searchParams.delete(param));
            window.history.replaceState({}, document.title, url.toString());
        }
    });
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
        }else if (salary) {
            console.log("Showing updateReq toast");
            Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: 'Employee Salary and Job Title Updated Successfully.',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            customClass: { popup: 'swal2-row-toast' }
            });
            removeUrlParams(['salary']);
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
    
    // ================== PASSWORD EYE ================== //
    const passwordInputCurrent = document.getElementById('passwordInputCurrent');
    const showPasswordCurrent = document.getElementById('showPasswordCurrent');
    const hidePasswordCurrent = document.getElementById('hidePasswordCurrent');

    const passwordInput = document.getElementById('passwordInput');
    const showPassword = document.getElementById('showPassword');
    const hidePassword = document.getElementById('hidePassword');

    const confirmPasswordInput = document.getElementById('confirmPasswordInput');
    const showConfirmPassword = document.getElementById('showConfirmPassword');
    const hideConfirmPassword = document.getElementById('hideConfirmPassword');

    showPasswordCurrent.addEventListener('click', () => {
        passwordInputCurrent.type = 'text';
        showPasswordCurrent.style.display = 'none';
        hidePasswordCurrent.style.display = 'inline';
    });

    hidePasswordCurrent.addEventListener('click', () => {
        passwordInputCurrent.type = 'password';
        showPasswordCurrent.style.display = 'inline';
        hidePasswordCurrent.style.display = 'none';
    });

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
        const sideHEheHr = document.getElementById("sideHEhe");
        const ilahr = document.getElementById("iLeftArrowHr");
        const ilapr = document.getElementById("iLeftArrowPr");

        const isOpen = hrUl.classList.contains("open");

        if (isOpen) {
            sideHEheHr.classList.remove("opened");
             ilahr.style.display = 'none';
            ilapr.style.display = 'none';
            hrUl.style.maxHeight = "0";
            hrUl.style.opacity = "0";
            hrUl.style.marginTop = "0";
            hrUl.classList.remove("open");

            setTimeout(() => {
                hrUl.style.display = "none";
            }, 400);
        } else {
            sideHEheHr.classList.add("opened");
             ilahr.style.display = 'flex';
            ilapr.style.display = 'flex';
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
        const sideHEheHr = document.getElementById("sideHEhe");
        const ilahr = document.getElementById("iLeftArrowHr");
        const ilapr = document.getElementById("iLeftArrowPr");

        const isOpen = payrollUl.classList.contains("open");

        if (isOpen) {
            sideHEheHr.classList.remove("opened");
             ilahr.style.display = 'none';
            ilapr.style.display = 'none';
            payrollUl.style.maxHeight = "0";
            payrollUl.style.opacity = "0";
            payrollUl.style.marginTop = "0";
            payrollUl.classList.remove("open");

            setTimeout(() => {
                payrollUl.style.display = "none";
            }, 400);
        } else {
            sideHEheHr.classList.add("opened");
             ilahr.style.display = 'flex';
            ilapr.style.display = 'flex';
            payrollUl.style.display = "flex";
            payrollUl.style.flexDirection = "column";
            payrollUl.style.maxHeight = payrollUl.scrollHeight + "px";
            payrollUl.style.opacity = "1";
            payrollUl.style.marginTop = "0.5rem";
            payrollUl.classList.add("open");
        }
    }

function showLoading() {
    const loading = document.getElementById("loadingAnimation");
    loading.style.display = "flex";
}

function hideLoading() {
    const loading = document.getElementById("loadingAnimation");
    loading.style.display = "none";
}

// ============= END ==================== //