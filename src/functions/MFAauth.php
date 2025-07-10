<?php include '../../templates/funcHeader.php'; ?>
<div class="hehe h-auto d-flex justify-content-start align-items-start" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 90%;">
   <div class="heh w-100 h-auto d-flex justify-content-center flex-column align-items-center m-0 p-0 rounded-4" style="background-color: #f0f0f0;">
        <div class="headerCode w-100 h-auto d-flex justify-content-center flex-column align-items-center m-0 p-0 rounded-4 shadow" style="background-color:#E32126;">
            <div class="linkToEmployeeManagement d-flex flex-row align-items-center justify-content-start pt-1 m-0" style="width: 95%; height: 2rem !important;">
                <a href="../index.php" style="text-decoration: none; color: #000;" class="m-0"><i class="fa-solid fa-arrow-left-long fs-6 me-1" style="color: #fff;"></i></a>
            </div>
            <div class="logo w-100 d-flex justify-content-center">
                <img src="../../assets/image/pueri-logo.png" alt="" style="width: 100px; height: 100px;">
            </div>
            <div class="title">
                <h5 class="text-center" style="color: #ffffff;">ZAMBOANGA PUERICULTURE CENTER</h5>
            </div>
        </div>
        <form method="POST" action="../../auth/authentications.php" class="modal-content">
            <?php isset($_SESSION["csrf_token"]) && $_SESSION["csrf_token"] !== "" ? $csrf = $_SESSION["csrf_token"] : " null "; ?>
            <input type="hidden" name="csrf_token" value="<?php echo $csrf; ?>">
            <input type="hidden" name="loginAuth" value="true">    
            <div class="emailAuth w-100 d-flex flex-column justify-content-start align-items-start m-0 py-3 px-4">
                <p class="text-center w-100 mt-2 mb-1 fs-7 fw-bold">Email verification code</p>
                <input type="text" name="mailCode" id="emailLabel" class="form-control w-100 text-center fw-bold p-2 fs-6" placeholder="Authentication Code" required>
            </div>
            <div class="button w-100 d-flex justify-content-center">
                <button class="btn btn-danger p-1 rounded-0 col-md-11 col-11 rounded-2">Confirm</button>
            </div>
        </form>
        <div class="resendCode my-2">
            <form action="../../auth/authentications.php" method="post">
                <?php isset($_SESSION["csrf_token"]) && $_SESSION["csrf_token"] !== "" ? $csrf = $_SESSION["csrf_token"] : " null "; ?>
                <input type="hidden" name="csrf_token" value="<?php echo $csrf; ?>">
                <input type="hidden" name="loginAuth" value="true">   
                <input type="hidden" name="resendCode" value="true">
                <button style="background: none; border: none; cursor: pointer;">Resend Code</button>
            </form>
        </div>
    </div>
</div>
<!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->
<script>
document.addEventListener('DOMContentLoaded', () => {
        if (mfa) {
            console.log("Showing updateReq toast");
            Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'error',
            title: 'Mail code not match, please try again..!.',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            customClass: { popup: 'swal2-row-toast' }
            });
            removeUrlParams(['mfa']);
        }

        function removeUrlParams(params) {
            const url = new URL(window.location);
            params.forEach(param => url.searchParams.delete(param));
            window.history.replaceState({}, document.title, url.toString());
        }
});
</script>
<?php include '../../templates/funcFooter.php'; ?>