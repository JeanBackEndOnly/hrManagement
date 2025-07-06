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
        }else if (passwordAuth) {
            console.log("Showing updateReq toast");
            Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'error',
            title: 'Fill up empty fields!.',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            customClass: { popup: 'swal2-row-toast' }
            });
            removeUrlParams(['passwordAuth']);
        }else if (passwordAuthFailes) {
            console.log("Showing updateReq toast");
            Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'error',
            title: 'Username not match, Try again!.',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            customClass: { popup: 'swal2-row-toast' }
            });
            removeUrlParams(['passwordAuthFailes']);
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
        const payrollUl = document.getElementById("payrollUl");
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
            payrollUl.classList.remove("open");
            payrollUl.style.display = 'none';

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
            payrollUl.classList.remove("open");
            payrollUl.style.display = 'none';
        }
}

function payrollButton() {
        const payrollUl = document.getElementById("payrollUl");
        const hrUl = document.getElementById("hrUl");
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
            hrUl.classList.remove("open");
            hrUl.style.display = 'none';

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
            hrUl.classList.remove("open");
            hrUl.style.display = 'none';
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