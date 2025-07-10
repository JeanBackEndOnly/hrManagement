<?php
 include '../../templates/Uheader.php';
 include '../../templates/HN.php';
?>

<main>
    <div class="main-body w-100 h-100 m-0 p-0">
        <?php echo renderHeader() ?>
        
        <div class="d-flex w-100 align-items-start" style="height: 91%">
            <?php renderNav() ?>

            <div class="contents w-100 h-100 d-flex flex-column align-items-center justify-content-start p-0 m-0">
                <div class="linkToEmployeeManagement d-flex flex-row align-items-center justify-content-start p-0 m-0 my-3 " style="width: 95%; height: 3rem !important;">
                    <a href="settings.php" style="text-decoration: none;"><i class="fa-solid fa-arrow-left-long fs-6 me-1"></i>Go back to Settings</a>
                </div>
                <div class="header-employee d-flex flex-row justify-content-between align-items-center " style="height: 7rem; width: 95%;">
                    <div class="h1">
                        <h3 class="m-0">SETTINGS</h3>
                    </div> 
                    <div class="History_Pass d-flex flex-row justify-content-between align-items-center" style="width: 25%">
                        <button id="idChangePass" class="historyPass active" onclick="changePass()">Change password</button>
                    </div>
                </div>
                <div class="container" id="changePAsswordID" style="display: flex;">
                    <div class="container shadow p-5 rounded-2">
                        <form class="w-100" method="POST" action="../../auth/authentications.php">
                                <?php isset($_SESSION["csrf_token"]) && $_SESSION["csrf_token"] !== "" ? $csrf = $_SESSION["csrf_token"] : " null "; ?>
                                <input type="hidden" name="csrf_token" value="<?php echo $csrf; ?>">
                                <input type="hidden" name="forgotPassword" value="true">
                            <div class="mb-3">
                                <li class="li-div w-100 flex-column" style="display: flex; list-style-type: none; align-items: start;">
                                    <label for="newPassword" class="form-label text-start fw-bold">Mail Code</label>
                                    <input type="text" class="form-control" name="mailCode" placeholder="Mail Code" required id="mailCode" style="flex: 1;">
                                </li>
                            </div>
                            <!-- ==================== MAMAYA NAYUNG EMAIL NAKAKA BUSIT DI MA FIX! ===================== -->
                            <div class="mb-3">
                                <li class="li-div w-100 flex-column" style="display: flex; list-style-type: none; align-items: start;">
                                    <label for="newPassword" class="form-label text-start fw-bold">New Password</label>
                                    <input type="password" class="form-control" name="new_password" placeholder="New Password" required id="passInput" style="flex: 1;">
                                    
                                    <button type="button" id="showPasswords" style="background: none; border: none;  position:fixed; right: 7rem; transform: translateY(2.5rem); margin-left: 5px;">
                                        <i class="fa-solid fa-eye"></i>
                                    </button>

                                    <button type="button" id="hidePasswords" style="background: none; border: none; position:fixed; right: 7rem; transform: translateY(2.5rem); margin-left: 5px; display: none;">
                                        <i class="fa-solid fa-eye-slash"></i>
                                    </button>
                                </li>
                            </div>

                            <div class="mb-3">
                                <li class="li-div w-100 flex-column justify-content-start" style="display: flex; list-style-type: none; align-items: start;">
                                    <label for="confirmPassword" class="form-label text-start fw-bold">Confirm New Password</label>
                                    <input type="password" class="form-control" name="confirm_password" placeholder="Confirm Password" required id="chInput" style="flex: 1;">
                                    
                                    <button type="button" id="showConfirmPasswords" style="background: none; border: none;  position:fixed; right: 7rem; transform: translateY(2.5rem); margin-left: 5px;">
                                        <i class="fa-solid fa-eye"></i>
                                    </button>

                                    <button type="button" id="hideConfirmPasswords" style="background: none; border: none; position:fixed; right: 7rem; transform: translateY(2.5rem); margin-left: 5px; display: none;">
                                        <i class="fa-solid fa-eye-slash"></i>
                                    </button>
                                </li>
                            </div>
                            <button type="submit" class="btn btn-success">Change Password</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<div id="loadingAnimationSettings" style="display:none;">
        <div class="loading-lines">
            <div class="line"></div>
            <div class="line"></div>
            <div class="line"></div>
        </div>
    </div>
    <script>
        const passwordInputs = document.getElementById('passInput');
const showPasswords = document.getElementById('showPasswords');
const hidePasswords = document.getElementById('hidePasswords');

const confirmPasswordInputs = document.getElementById('chInput');
const showConfirmPasswords = document.getElementById('showConfirmPasswords');
const hideConfirmPasswords = document.getElementById('hideConfirmPasswords');

    showPasswords.addEventListener('click', () => {
        passwordInputs.type = 'text';
        showPasswords.style.display = 'none';
        hidePasswords.style.display = 'inline';
    });

    hidePasswords.addEventListener('click', () => {
        passwordInputs.type = 'password';
        showPasswords.style.display = 'inline';
        hidePasswords.style.display = 'none';
    });

    showConfirmPasswords.addEventListener('click', () => {
        confirmPasswordInputs.type = 'text';
        showConfirmPasswords.style.display = 'none';
        hideConfirmPasswords.style.display = 'inline';
    });

    hideConfirmPasswords.addEventListener('click', () => {
        confirmPasswordInputs.type = 'password';
        showConfirmPasswords.style.display = 'inline';
        hideConfirmPasswords.style.display = 'none';
    });
    </script>
<script src="../../assets/js/hr/settings.js"></script>
<?php include '../../templates/Ufooter.php'?>