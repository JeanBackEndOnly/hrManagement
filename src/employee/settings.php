<?php include '../../templates/Uheader.php';?>

<main>
    <div class="main-body w-100 h-100 m-0 p-0">
         <div class="header d-flex align-items-center justify-content-between px-3" style="height: 60px; min-width: 100%;">
            <div class="logo d-flex align-items-center">
                <button type="button" onclick="sideNav();"><i class="fa-solid fa-bars fs-4 me-3"></i></button>
                <img src="../../assets/image/pueri-logo.png" alt="Logo" style="height: 40px;" class="me-2">
                <h4 class="m-0">ZAMBOANGA PUERICULTURE CENTER</h4>
            </div>

            <div class="usersButton d-flex align-items-center">
                <a href="settings.php"><i class="fa-solid fa-gear"></i></a>
                <a href="../logout.php"><i class="fa-solid fa-right-from-bracket ms-3 me-1"></i></a>
                <a href="profile.php?users_id=<?php echo $employeeInfo["users_id"]; ?>" class="align-items-center m-0" style="text-decoration: none; color: #000;" type="button" onclick="userButton()">
                    <img src="../../assets/image/upload/<?php echo htmlspecialchars($employeeInfo["user_profile"]) ?>" class="rounded-circle me-0 ms-4" style="height: 35px; width: 35px;">
                    <span class="fw-bold"><?php echo isset($employeeInfo["lname"]) ? htmlspecialchars($employeeInfo["lname"]) . ", " . htmlspecialchars($employeeInfo["fname"]) : "N/A" ?></span>
                </a>
            </div>
        </div>


        <div class="d-flex w-100 align-items-start" style="height: 91%">
            <div class="sideNav p-0" id="sideHEhe">
                <div class="navs p-0 m-0 mt-2 w-auto">
                    <li class="dashboardLi d-flex align-items-center p-2 mb-2">
                        <a href="dashboard.php" class="d-flex align-items-center w-100">
                            <i id="dashoardi" class="fa-solid fa-house fs-5 me-2 me-side-text2"></i>
                            <p class="text-start side-text m-0" id="pdashboard">Dashboard</p>
                        </a>
                    </li>
                    <li class="hrLi d-flex align-items-center p-2 mb-2 w-100">
                        <button type="button" onclick="hrButton()" class="p-0 m-0 w-100 h-100 d-flex align-items-center">
                            <i id="hri" class="fa-solid me-2 fa-users"></i>
                            <p class="text-start side-text" id="phr">HR Management</p>
                            <i id="iLeftArrowHr" class="fa-solid fa-chevron-left" style="display:none;"></i>
                        </button>
                    </li>

                    <ul id="hrUl" class="flex-column" style="display:none;">
                        <li class="my-1"><a href="leave.php"  class="d-flex justify-content-start"><i class="fa-solid me-1 d-flex align-items-center fa-file-export"></i><p style="display:flex;" id="pNone" class="text-start">LEAVE REQUEST</p></a></li>
                        <li class="my-1"><a href="reports.php"  class="d-flex justify-content-start"><i class="fa-solid me-1 fa-briefcase"></i><p style="display:flex;" id="pNone" class="text-start">REPORTS</p></a></li>
                        <li class="my-1"><a href="pds.php"  class="d-flex justify-content-start"><i class="fa-solid me-1 d-flex align-items-center fa-file-export"></i><p style="display:flex;" id="pNone" class="text-start">PDS</p></a></li>
                    </ul>

                    <li class="payrollLi d-flex align-items-center p-2 mb-2">
                        <button type="button" onclick="payrollButton()" class="p-0 m-0 w-100 h-100 d-flex align-items-center">
                            <i id="payrolli" class="fa-solid me-2 fa-peso-sign"></i>
                            <p class="text-start side-text" id="ppr">Payroll Management</p>
                            <i id="iLeftArrowPr" class="fa-solid fa-chevron-left" style="display:none;"></i>
                        </button>
                    </li>

                    <ul id="payrollUl" class="flex-column" style="display:none;">
                        <li class="my-1"><a href="employee.php"><i class="fa-solid me-1 fa-users-gear"></i>RECRUITMENTS</a></li>
                        <li class="my-1"><a href="leave.php"><i class="fa-solid me-1 fa-file-export"></i>LEAVE REQUEST</a></li>
                        <li class="my-1"><a href="job.php"><i class="fa-solid me-1 fa-briefcase"></i>JOB TITLES</a></li>
                    </ul>

                    <li class="attendanceLi d-flex align-items-center p-2 mb-2">
                        <a href="#" class="p-0 m-0 w-100 h-100 d-flex align-items-center">
                            <i class="fa-solid me-2 fa-clock"></i>
                            <p class="text-start side-text" id="pa">Attendance</p>
                        </a>
                    </li>

                    <li class="settingsLi d-flex align-items-center p-2 mb-2">
                        <a href="settings.php" class="p-0 m-0 w-100 h-100 d-flex align-items-center">
                            <i class="fa-solid me-2 fa-gear"></i>
                            <p class="text-start side-text" id="ps">Settings</p>
                        </a>
                    </li>
                </div>
            </div>
            <div class="contents w-100 h-100 d-flex flex-column align-items-center justify-content-start p-0 m-0">
                <div class="header-employee d-flex flex-row justify-content-between align-items-center col-md-11 flex-wrap" style="height: 7rem;">
                    <div class="h1 col-md-4 col-12">
                        <h3 class="h3-employee">SETTINGS</h3>
                    </div> 
                    <div class="History_Pass d-flex flex-row justify-content-between align-items-center col-12 col-md-4">
                        <button id="idChangePass" class="historyPass active col-md-6 col-6" onclick="changePass()">Change password</button>
                        <button id="idLoginHistory" class="historyPass col-md-4 col-6" onclick="loginHistory()">Login History</button>
                    </div>
                </div>
                
                <div class="container" id="changePAsswordID" style="display: flex;">
                    <div class="container shadow p-5 rounded-2">
                        <form class="w-100" method="POST" action="../../auth/authentications.php">
                                <?php isset($_SESSION["csrf_token"]) && $_SESSION["csrf_token"] !== "" ? $csrf = $_SESSION["csrf_token"] : " null "; ?>
                                <input type="hidden" name="csrf_token" value="<?php echo $csrf; ?>">
                                <input type="hidden" name="changePasswordEmp" value="true">
                            <div class="mb-3">
                                <li class="li-div w-100 flex-column" style="display: flex; list-style-type: none; align-items: start;">
                                    <label for="newPassword" class="form-label text-start fw-bold">Current Password</label>
                                    <input type="password" class="form-control" name="current_password" placeholder="Password" required id="passwordInputCurrents" style="flex: 1;">
                                    
                                    <button type="button" id="showPasswordCurrents" style="background: none; border: none;  position:fixed; right: 7rem; transform: translateY(2.5rem); margin-left: 5px;">
                                        <i class="fa-solid fa-eye"></i>
                                    </button>

                                    <button type="button" id="hidePasswordCurrents" style="background: none; border: none; position:fixed; right: 7rem; transform: translateY(2.5rem); margin-left: 5px; display: none;">
                                        <i class="fa-solid fa-eye-slash"></i>
                                    </button>
                                </li>
                            </div>
                            <div class="mb-3">
                                <li class="li-div w-100 flex-column" style="display: flex; list-style-type: none; align-items: start;">
                                    <label for="newPassword" class="form-label text-start fw-bold">New Password</label>
                                    <input type="password" class="form-control" name="new_password" placeholder="Password" required id="passwordInputs" style="flex: 1;">
                                    
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
                                    <input type="password" class="form-control" name="confirm_password" placeholder="Confirm Password" required id="confirmPasswordInputs" style="flex: 1;">
                                    
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
                <div class="loginHistory" id="loginHisotryID" style="display:none; width: 95%; height:63vh;">
                    <div class="container shadow p-2 cold-md-12 h-100 rounded-2 d-flex justify-content-between align-items-start flex-wrap overflow-scroll">
                        <?php if($employeeHistory): ?>
                            <div class="w-50">
                                <h4 class="text-center fw-bold col-md-5 col-9">Login Time</h4>
                                <?php foreach($employeeHistory as $history): ?>
                                    <p class="text-center my-1 p-2 bg-light border border-secondary-subtle rounded" style="width: 98% !important;">
                                        <?= date('F j, Y h:i A', strtotime($history['login_time'])) ?>
                                    </p>
                                <?php endforeach ?>
                            </div>
                            <div class="w-50">
                                <h4 class="text-center fw-bold col-md-5 col-8" style="width: 98% !important;">Logout Time</h4>
                                <?php foreach($employeeHistory as $history): ?>
                                    <p class="text-center my-1 p-2 bg-light border border-secondary-subtle rounded" style="width: 98% !important;">
                                        <?= isset($history['logout_time']) ? date('F j, Y h:i A', strtotime($history['logout_time'])) : 'User not logged out' ?>
                                    </p>
                                <?php endforeach ?>
                            </div>
                        <?php endif ?>
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
         document.addEventListener('DOMContentLoaded', () => {
        if (passwordFailed) {
            console.log("Showing updateReq toast");
            Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'error',
            title: 'Failed to update Password!.',
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
        document.addEventListener("DOMContentLoaded", function () {

        const passwordInputCurrents = document.getElementById('passwordInputCurrents');
        const showPasswordCurrents = document.getElementById('showPasswordCurrents');
        const hidePasswordCurrents = document.getElementById('hidePasswordCurrents');

        const passwordInputs = document.getElementById('passwordInputs');
        const showPasswords = document.getElementById('showPasswords');
        const hidePasswords = document.getElementById('hidePasswords');

        const confirmPasswordInputs = document.getElementById('confirmPasswordInputs');
        const showConfirmPasswords = document.getElementById('showConfirmPasswords');
        const hideConfirmPasswords = document.getElementById('hideConfirmPasswords');

        if (showPasswordCurrents && hidePasswordCurrents && passwordInputCurrents) {
            showPasswordCurrents.addEventListener('click', () => {
                passwordInputCurrents.type = 'text';
                showPasswordCurrents.style.display = 'none';
                hidePasswordCurrents.style.display = 'inline';
            });

            hidePasswordCurrents.addEventListener('click', () => {
                passwordInputCurrents.type = 'password';
                showPasswordCurrents.style.display = 'inline';
                hidePasswordCurrents.style.display = 'none';
            });
        }

        if (showPasswords && hidePasswords && passwordInputs) {
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
        }

        if (showConfirmPasswords && hideConfirmPasswords && confirmPasswordInputs) {
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
        }
    });

    </script>
<script src="../../assets/js/hr/settings.js"></script>
<?php include '../../templates/Ufooter.php'?>