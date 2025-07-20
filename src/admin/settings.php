<?php
 include '../../templates/Uheader.php';
 include '../../templates/HN.php';
?>

<main>
    <div class="main-body w-100 h-100 m-0 p-0">
        <?php echo renderHeader() ?>

        <div class="d-flex w-100 align-items-start" style="height: 91%">
            <?php renderNav() ?>

            <div class="contents col-md-10 col-10 h-100 d-flex flex-column align-items-center justify-content-start p-0 m-0">
                <div class="header-employee d-flex flex-row justify-content-between align-items-center col-md-11 col-11"
                    style="height: 7rem;">
                    <div class="h1 AnimationFinalfirst">
                        <h3 class="m-0 titleFont">SETTINGS</h3>
                        <p style="font-size: 17px !important; margin-top: -1rem !important;"><span>Make sure that to have a secure password</span></p>
                    </div>
                </div>
                <div class="d-flex flex-row justify-content-start align-items-center col-md-10 col-12 mb-2" >
                    <button id="idChangePass" class="historyPass active col-md-2 col-2" onclick="changePass()">Change
                        password</button>
                    <button id="idLoginHistory" class="historyPass col-md-2 col-2" onclick="loginHistory()">Login
                        History</button>
                </div>
                <div class="container col-md-11" id="changePAsswordID" style="display: flex;">
                    <div class="container shadow p-5 rounded-2">
                        <form class="w-100" method="POST" action="../../auth/authentications.php">
                            <?php isset($_SESSION["csrf_token"]) && $_SESSION["csrf_token"] !== "" ? $csrf = $_SESSION["csrf_token"] : " null "; ?>
                            <input type="hidden" name="csrf_token" value="<?php echo $csrf; ?>">
                            <input type="hidden" name="changePassword" value="true">
                            <div class="mb-3">
                                <li class="li-div w-100 flex-column"
                                    style="display: flex; list-style-type: none; align-items: start;">
                                    <label for="newPassword" class="form-label text-start fw-bold">Current
                                        Password</label>
                                    <input type="password" class="form-control" name="current_password"
                                        placeholder="Password" required id="passwordInputCurrents" style="flex: 1;">

                                    <button type="button" id="showPasswordCurrents"
                                        style="background: none; border: none;  position:fixed; right: 9rem; transform: translateY(2.5rem); margin-left: 5px;">
                                        <i class="fa-solid fa-eye"></i>
                                    </button>

                                    <button type="button" id="hidePasswordCurrents"
                                        style="background: none; border: none; position:fixed; right: 9rem; transform: translateY(2.5rem); margin-left: 5px; display: none;">
                                        <i class="fa-solid fa-eye-slash"></i>
                                    </button>
                                </li>
                            </div>
                            <div class="mb-3">
                                <li class="li-div w-100 flex-column"
                                    style="display: flex; list-style-type: none; align-items: start;">
                                    <label for="newPassword" class="form-label text-start fw-bold">New Password</label>
                                    <input type="password" class="form-control" name="new_password"
                                        placeholder="Password" required id="passwordInputs" style="flex: 1;">

                                    <button type="button" id="showPasswords"
                                        style="background: none; border: none;  position:fixed; right: 9rem; transform: translateY(2.5rem); margin-left: 5px;">
                                        <i class="fa-solid fa-eye"></i>
                                    </button>

                                    <button type="button" id="hidePasswords"
                                        style="background: none; border: none; position:fixed; right: 9rem; transform: translateY(2.5rem); margin-left: 5px; display: none;">
                                        <i class="fa-solid fa-eye-slash"></i>
                                    </button>
                                </li>
                            </div>

                            <div class="mb-3">
                                <li class="li-div w-100 flex-column justify-content-start"
                                    style="display: flex; list-style-type: none; align-items: start;">
                                    <label for="confirmPassword" class="form-label text-start fw-bold">Confirm New
                                        Password</label>
                                    <input type="password" class="form-control" name="confirm_password"
                                        placeholder="Confirm Password" required id="confirmPasswordInputs"
                                        style="flex: 1;">

                                    <button type="button" id="showConfirmPasswords"
                                        style="background: none; border: none;  position:fixed; right: 9rem; transform: translateY(2.5rem); margin-left: 5px;">
                                        <i class="fa-solid fa-eye"></i>
                                    </button>

                                    <button type="button" id="hideConfirmPasswords"
                                        style="background: none; border: none; position:fixed; right: 9rem; transform: translateY(2.5rem); margin-left: 5px; display: none;">
                                        <i class="fa-solid fa-eye-slash"></i>
                                    </button>
                                </li>
                            </div>
                            <button type="submit" class="btn btn-success">Change Password</button>
                        </form>
                        <div class="mt-3">
                            <button class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                data-bs-target="#changePassword">Forgot Password?</button>
                        </div>
                    </div>
                </div>
                <div class="loginHistory" id="loginHisotryID" style="display:none; width: 95%; height:65vh;">
                    <div
                        class="container shadow p-2 m-0 w-100 h-100 rounded-2 d-flex justify-content-between align-items-start flex-wrap overflow-scroll">
                        <?php if($adminHistory): ?>
                        <div class="w-50">
                            <h3 class="text-center fw-bold" style="width: 98% !important;">Login Time</h3>
                            <?php foreach($adminHistory as $history): ?>
                            <p class="text-center my-1 p-2 bg-light border border-secondary-subtle rounded"
                                style="width: 98% !important;">
                                <?= date('F j, Y h:i A', strtotime($history['login_time'])) ?>
                            </p>
                            <?php endforeach ?>
                        </div>
                        <div class="w-50">
                            <h3 class="text-center fw-bold" style="width: 98% !important;">Logout Time</h3>
                            <?php foreach($adminHistory as $history): ?>
                            <p class="text-center my-1 p-2 bg-light border border-secondary-subtle rounded"
                                style="width: 98% !important;">
                                <?= isset($history['logout_time']) ? date('F j, Y h:i A', strtotime($history['logout_time'])) : 'Not logged out' ?>
                            </p>
                            <?php endforeach ?>
                        </div>
                        <?php endif ?>
                    </div>
                </div>
                <!-- ============================ Change Password Modal End ============================ -->
                <div class="modal fade" id="changePassword" tabindex="-1" aria-labelledby="passwordModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <form method="POST" action="../../auth/authentications.php" class="modal-content">
                            <?php isset($_SESSION["csrf_token"]) && $_SESSION["csrf_token"] !== "" ? $csrf = $_SESSION["csrf_token"] : " null "; ?>
                            <input type="hidden" name="csrf_token" value="<?php echo $csrf; ?>">
                            <input type="hidden" name="forgotPassword" value="true">
                            <div class="modal-header bg-success">
                                <h5 class="modal-title text-start w-100" id="passwordModalLabel" style="color: #fff;">
                                    Enter your username:</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <label for="usernameConfim">Username:</label>
                                <input type="text" name="username" id="usernameConfim" class="form-control">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">Confirm</button>
                            </div>
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
<script src="../../assets/js/hr/settings.js"></script>
<?php include '../../templates/Ufooter.php'?>