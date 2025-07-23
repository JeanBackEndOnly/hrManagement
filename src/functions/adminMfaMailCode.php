<?php include '../../templates/funcHeader.php'; ?>
<style>
.loginBG {
    /* background: linear-gradient(130deg, #E32126, #fff, #fff, #E32126); */
    background-color: #dbdbdbff !important;
}

a {
    text-decoration: none;
}

.transition {
    transition: .5s ease-in;
}

.buttonHover:hover {
    background-color: #E32126 !important;
}

.noBG {
    background-color: transparent !important;
}
@media (max-width: 576px) {
    .mediaHeaderText{
        font-size: 14px !important;
    }
    .mediaImgeHeader{
        width: 40px !important;
        height: 40px !important;
    }
    .mediaLogin{
        margin-top: -5rem !important;
    }
    .mediaFontTitle{
        font-size: 3rem !important;
    }
    .mediaLoginSub{
        font-size: .8rem !important;
        margin-top: -.8rem;
    }
    .mediaSignupText{
        font-size: 12px !important;
    }
}
</style>
<main id="main" class="login-page px-0 ">
    <div class="d-flex flex-column h-100 w-100 align-items-center justify-content-start loginBG fadeInAnimation"
        style="position: fixed !important;">
        <div class="header col-md-11 col-11 mt-2 h-auto rounded-3 d-flex align-items-center justify-content-center p-2"
            style="background-color: #E32126 !important">
            <img src="../../assets/image/pueri-logo.png" alt="" style="width: 60px; height: 60px;" class="mediaImgeHeader ">
            <h5 class="text-center ms-2 fw-bold fs-2 m-0 mediaHeaderText" style="color: #fff;">ZAMBOANGA PUERICULTURE CENTER</h5>
        </div>
        <div class="h-100 col-md-12 col-12 d-flex align-items-center justify-content-center" style="background-color: #dbdbdbff !important;">
            <div class="container mediaLogin col-md-4 col-10 d-flex shadow flex-column align-items-center h-auto justify-content-center m-0 p-0 pb-2 rounded-bottom-4"
                style="background-color: #fff !important;">
                <div class="headerLogin mb-1 w-100 h-auto d-flex justify-content-center flex-column align-items-center m-0 p-0 rounded-top-4 shadow py-2"
                    style="background-color: #E32126; margin-top: -3rem !important;">
                    <div class="back w-100 d-flex justify-contet-start ps-4">
                        <a href="../index.php"><i class="fa-solid fa-arrow-left-long text-white"></i></a>
                    </div>
                    <label class="fw-light text-white m-0 p-0 mediaFontTitle"
                        style="font-family: 'Jomhuria', cursive !important; font-size: 4rem ">VERIFICATION CODE</label>
                    <span class="text-white text-center mediaLoginSub">Email authentication makes you safer</span>
                </div>
                <form method="POST" action="../../auth/authentications.php" class="modal-content">
                    <?php isset($_SESSION["csrf_token"]) && $_SESSION["csrf_token"] !== "" ? $csrf = $_SESSION["csrf_token"] : " null "; ?>
                    <input type="hidden" name="csrf_token" value="<?php echo $csrf; ?>">
                    <input type="hidden" name="loginAuth" value="true">    
                    <div class="emailAuth w-100 d-flex flex-column justify-content-start align-items-start m-0 py-3 px-4 rounded-2">
                        <p class="text-center w-100 mt-2 mb-1 fs-7 fw-bold">Email verification code</p>
                        <input type="text" name="AdminMailCode" id="emailLabel" class="form-control w-100 text-center fw-bold p-2 fs-6" placeholder="Authentication Code" required>
                    </div>
                    <div class="button w-100 d-flex justify-content-center">
                        <button class="btn p-1 rounded-0 col-md-11 rounded-2 text-white fw-bold btn-confirm" style="background-color: #E53935;">Confirm</button>
                    </div>
                </form>
                <div class="resendCode my-2">
                    <form action="../../auth/authentications.php" method="post">
                        <?php isset($_SESSION["csrf_token"]) && $_SESSION["csrf_token"] !== "" ? $csrf = $_SESSION["csrf_token"] : " null "; ?>
                        <input type="hidden" name="csrf_token" value="<?php echo $csrf; ?>">
                        <input type="hidden" name="loginAuth" value="true">   
                        <input type="hidden" name="AdminResendCode" value="true">
                        <button style="background: none; border: none; cursor: pointer;">Resend Code</button>
                    </form>
                </div>
                    
            </div>
        </div>

</main>

</div>    
<!-- <script src="../../assets/js/hr/login.js"></script> -->
        
        
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
        }else if (resent) {
            console.log("Showing updateReq toast");
            Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: 'Mail resend successfully!.',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            customClass: { popup: 'swal2-row-toast' }
            });
            removeUrlParams(['resent']);
        }

        function removeUrlParams(params) {
            const url = new URL(window.location);
            params.forEach(param => url.searchParams.delete(param));
            window.history.replaceState({}, document.title, url.toString());
        }
});
document.querySelectorAll('.btn-confirm').forEach(btn => {
    btn.addEventListener('click', function () {
        const loader = document.getElementById('loaderOverlay');
        if (loader) {
            loader.style.display = 'flex';
        }
        setTimeout(() => loader.style.display = 'none', 3000);
    });
});


</script>
<?php include '../../templates/funcFooter.php'; ?>