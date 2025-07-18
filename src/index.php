<?php include '../templates/RLheader.php'; ?>
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
            <img src="../assets/image/pueri-logo.png" alt="" style="width: 60px; height: 60px;" class="mediaImgeHeader ">
            <h5 class="text-center ms-2 fw-bold fs-2 m-0 mediaHeaderText" style="color: #fff;">ZAMBOANGA PUERICULTURE CENTER</h5>
        </div>
        <div class="h-100 col-md-12 col-12 d-flex align-items-center justify-content-center">
            <div class="container mediaLogin col-md-4 col-10 d-flex shadow flex-column align-items-center h-auto justify-content-center m-0 p-0 rounded-bottom-4"
                style="background-color: #fff !important;">
                <div class="headerLogin mb-1 w-100 h-auto d-flex justify-content-center flex-column align-items-center m-0 p-0 rounded-top-4 shadow py-2"
                    style="background-color: #E32126; margin-top: -3rem !important;">
                    <label class="fw-light text-white m-0 p-0 mediaFontTitle"
                        style="font-family: 'Jomhuria', cursive !important; font-size: 4rem ">LOGIN ACCESS</label>
                    <span class="text-white text-center mediaLoginSub">Welcome to Zamboanga Puericulture Center</span>
                </div>
                <form action="../auth/authentications.php" class="col-md-12 col-11 h-auto mt-2 px-3" method="post">

                    <?php isset($_SESSION["csrf_token"]) && $_SESSION["csrf_token"] !== "" ? $csrf = $_SESSION["csrf_token"] : " null "; ?>
                    <input type="hidden" name="csrf_token" value="<?php echo $csrf; ?>">
                    <input type="hidden" name="loginAuth" value="true">
                    <div class="mb-3">
                        <input type="text" class="form-control rounded-1" name="username" placeholder="Username: "
                            required>
                    </div>
                    <div class="mb-3">
                        <li class="li-div w-100"
                            style="display: flex; list-style-type: none; align-items: center; position: relative;">
                            <input type="password" class="form-control rounded-1" name="password" placeholder="Password"
                                required id="passwordInputs" style="flex: 1;">
                            <button type="button" id="showPasswords"
                                style="background: none; border: none; position: absolute; right: 1rem;">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                            <button type="button" id="hidePasswords"
                                style="background: none; border: none; position: absolute; right: 1rem; display: none;">
                                <i class="fa-solid fa-eye-slash"></i>
                            </button>
                        </li>
                    </div>
                    <div class="mb-3 mt-3 text-center w-100">
                        <button type="submit" class="btn btn-danger w-100 p-2 mb-0 fw-bold buttonHover"
                            style="background-color: #E53935; ">Login</button>
                    </div>
                </form>
                <button class="btn btn-sm mb-1 fw-bold mediaSignupText" style="background: none; box-shadow: none; color: #000;"
                    data-bs-toggle="modal" data-bs-target="#changePassword">Forgot Password?</button>
                <div class="mb-1 text-center">
                    <p class="mediaSignupText">Doesn’t have an account? <a href="register.php" style="color: blue;"><span
                                style="color: #E53935 !important;" class="fw-bold mediaSignupText">Sign-up</span></a></p>
                </div>
            </div>
        </div>

</main>

<div class="modal fade" id="changePassword" tabindex="-1" aria-labelledby="passwordModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="../auth/authentications.php" class="modal-content">
            <?php isset($_SESSION["csrf_token"]) && $_SESSION["csrf_token"] !== "" ? $csrf = $_SESSION["csrf_token"] : " null "; ?>
            <input type="hidden" name="csrf_token" value="<?php echo $csrf; ?>">
            <input type="hidden" name="usersForgottenPass" value="true">
            <div class="modal-header bg-success">
                <h5 class="modal-title text-start w-100" id="passwordModalLabel" style="color: #fff;">Enter your
                    username:</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <label for="usernameConfim">Username:</label>
                <input type="text" name="usernameAuth" id="usernameConfim" class="form-control" required>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Confirm</button>
            </div>
        </form>
    </div>
</div>
</div>

<script>
if ('serviceWorker' in navigator) {
    navigator.serviceWorker.register('./service-worker.js')
        .then(reg => console.log('✅ SW registered ➜', reg.scope))
        .catch(err => console.error('ServiceWorker registration failed:', err));
}
</script>
<script src="../assets/js/hr/login.js"></script>
<?php include '../templates/RLfooter.php'; ?>