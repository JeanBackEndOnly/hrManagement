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
    const pHR = document.getElementById("phr");
    const pDASHBOARD = document.getElementById("pdashboard");
    const ppr = document.getElementById("ppr");
    const pa = document.getElementById("pa");
    const ps = document.getElementById("ps");

    const isClosed = sideHEhe.classList.contains("colsed");

    if (isClosed) {
        // Open Sidebar
        sideHEhe.classList.remove("colsed");
        sideHEhe.classList.add("opened");

        // Show text and arrows
        [pHR, pDASHBOARD, ppr, pa, ps, ilahr, ilapr].forEach(el => el.style.display = 'flex');

        // Expand submenus if they were open
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
        // Close Sidebar
        sideHEhe.classList.remove("opened");
        sideHEhe.classList.add("colsed");

        // Hide text and arrows
        [pHR, pDASHBOARD, ppr, pa, ps, ilahr, ilapr].forEach(el => el.style.display = 'none');

        // Collapse submenus
        [hrUls, payrollUl].forEach(ul => {
            ul.style.maxHeight = "0";
            ul.style.opacity = "0";
            ul.style.marginTop = "0";
        });

        setTimeout(() => {
            hrUls.style.display = "none";
            payrollUl.style.display = "none";
        }, 400);
    }
}

function toggleDropdown(targetUl, otherUl) {
  if (targetUl.classList.contains("open")) {
    targetUl.style.maxHeight = "0";
    targetUl.classList.remove("open");
  } else {
    // Expand target
    targetUl.style.maxHeight = targetUl.scrollHeight + "px";
    targetUl.classList.add("open");

    // Collapse other
    otherUl.style.maxHeight = "0";
    otherUl.classList.remove("open");
  }
}

function hrButton() {
  const hrUl = document.getElementById("hrUl");
  const prUl = document.getElementById("payrollUl");
  toggleDropdown(hrUl, prUl);
}

function payrollButton() {
  const hrUl = document.getElementById("hrUl");
  const prUl = document.getElementById("payrollUl");
  toggleDropdown(prUl, hrUl);
}


document.querySelectorAll('.btn-confirm').forEach(btn => {
    btn.addEventListener('click', function () {
        //  alert('button clicked');
        const loader = document.getElementById('loaderOverlay');
        if (loader) {
            loader.style.display = 'flex';
        }
        setTimeout(() => loader.style.display = 'none', 2000);
    });
});


// ============= END ==================== //