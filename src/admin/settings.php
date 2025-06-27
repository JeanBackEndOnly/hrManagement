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
                <a href="logout.php"><i class="fa-solid fa-right-from-bracket ms-3"></i></a>
                <button class="align-items-center" type="button" onclick="userButton()">
                    <img src="../../assets/image/users.png" class="rounded-circle me-2 ms-4" style="height: 35px; width: 35px;">
                    <span class="fw-bold">ADMIN</span>
                </button>
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
                       <li class="my-1"><a href="employee.php" class="d-flex justify-content-start"><i class="fa-solid me-1 fa-users-gear d-flex align-items-center"></i><p style="display:flex;" id="pNone" class="text-start">RECRUITMENTS</p></a></li>
                        <li class="my-1"><a href="leave.php"  class="d-flex justify-content-start"><i class="fa-solid me-1 d-flex align-items-center fa-file-export"></i><p style="display:flex;" id="pNone" class="text-start">LEAVE REQUEST</p></a></li>
                        <li class="my-1"><a href="job.php"  class="d-flex justify-content-start"><i class="fa-solid me-1 d-flex align-items-center fa-briefcase"></i><p style="display:flex;" id="pNone" class="text-start">JOB & SALARY</p></a></li>
                        <li class="my-1"><a href="reports.php"  class="d-flex justify-content-start"><i class="fa-solid me-1 fa-flag" d-flex align-items-center></i><p style="display:flex;" id="pNone" class="text-start">Reports</p></a></li>
                    </ul>

                    <li class="payrollLi d-flex align-items-center p-2 mb-2">
                        <button type="button" onclick="payrollButton()" class="p-0 m-0 w-100 h-100 d-flex align-items-center">
                            <i id="payrolli" class="fa-solid me-2 fa-peso-sign"></i>
                            <p class="text-start side-text" id="ppr">Payroll Management</p>
                            <i id="iLeftArrowPr" class="fa-solid fa-chevron-left" style="display:none;"></i>
                        </button>
                    </li>

                    <ul id="payrollUl" class="flex-column" style="display:none;">
                        <li class="my-1"><a href="payroll/process.php"><i class="fa-solid me-1 fa-users-gear"></i>PROCESS</a></li>
                        <li class="my-1"><a href="payroll/Config.php"><i class="fa-solid me-1 fa-file-export"></i>CONFIG</a></li>
                        <li class="my-1"><a href="payroll/Reports.php"><i class="fa-solid me-1 fa-briefcase"></i>REPORTS</a></li>
                        <li class="my-1"><a href="payroll/Deduction Slip.php"><i class="fa-solid me-1 fa-file-export"></i>DEDUCTION SLIP</a></li>
                        <li class="my-1"><a href="payroll/Loan Request.php"><i class="fa-solid me-1 fa-briefcase"></i>LOAN REQUEST</a></li>
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
                <div class="header-employee d-flex flex-row justify-content-between align-items-center " style="height: 9rem; width: 95%;">
                    <div class="h1">
                        <h3 class="m-0">SETTINGS</h3>
                    </div> 
                    <div class="History_Pass d-flex flex-row justify-content-between align-items-center" style="width: 25%">
                        <button id="idChangePass" class="historyPass active" onclick="changePass()">Change password</button>
                        <button id="idLoginHistory" class="historyPass" onclick="loginHistory()">Login History</button>
                    </div>
                </div>
                <div class="container" id="changePAsswordID" style="display: flex;">
                    <div class="container shadow p-5 rounded-2">
                        <form class="w-100" method="POST" action="../../auth/authentications.php">
                                <?php isset($_SESSION["csrf_token"]) && $_SESSION["csrf_token"] !== "" ? $csrf = $_SESSION["csrf_token"] : " null "; ?>
                                <input type="hidden" name="csrf_token" value="<?php echo $csrf; ?>">
                                <input type="hidden" name="changePassword" value="true">
                            <div class="mb-3">
                                <li class="li-div w-100 flex-column" style="display: flex; list-style-type: none; align-items: start;">
                                    <label for="newPassword" class="form-label text-start fw-bold">Current Password</label>
                                    <input type="password" class="form-control" name="current_password" placeholder="Password" required id="passwordInputCurrents" style="flex: 1;">
                                    
                                    <button type="button" id="showPasswordCurrents" style="background: none; border: none;  position:fixed; right: 9rem; transform: translateY(2.5rem); margin-left: 5px;">
                                        <i class="fa-solid fa-eye"></i>
                                    </button>

                                    <button type="button" id="hidePasswordCurrents" style="background: none; border: none; position:fixed; right: 9rem; transform: translateY(2.5rem); margin-left: 5px; display: none;">
                                        <i class="fa-solid fa-eye-slash"></i>
                                    </button>
                                </li>
                            </div>
                            <div class="mb-3">
                                <li class="li-div w-100 flex-column" style="display: flex; list-style-type: none; align-items: start;">
                                    <label for="newPassword" class="form-label text-start fw-bold">New Password</label>
                                    <input type="password" class="form-control" name="new_password" placeholder="Password" required id="passwordInputs" style="flex: 1;">
                                    
                                    <button type="button" id="showPasswords" style="background: none; border: none;  position:fixed; right: 9rem; transform: translateY(2.5rem); margin-left: 5px;">
                                        <i class="fa-solid fa-eye"></i>
                                    </button>

                                    <button type="button" id="hidePasswords" style="background: none; border: none; position:fixed; right: 9rem; transform: translateY(2.5rem); margin-left: 5px; display: none;">
                                        <i class="fa-solid fa-eye-slash"></i>
                                    </button>
                                </li>
                            </div>

                            <div class="mb-3">
                                <li class="li-div w-100 flex-column justify-content-start" style="display: flex; list-style-type: none; align-items: start;">
                                    <label for="confirmPassword" class="form-label text-start fw-bold">Confirm New Password</label>
                                    <input type="password" class="form-control" name="confirm_password" placeholder="Confirm Password" required id="confirmPasswordInputs" style="flex: 1;">
                                    
                                    <button type="button" id="showConfirmPasswords" style="background: none; border: none;  position:fixed; right: 9rem; transform: translateY(2.5rem); margin-left: 5px;">
                                        <i class="fa-solid fa-eye"></i>
                                    </button>

                                    <button type="button" id="hideConfirmPasswords" style="background: none; border: none; position:fixed; right: 9rem; transform: translateY(2.5rem); margin-left: 5px; display: none;">
                                        <i class="fa-solid fa-eye-slash"></i>
                                    </button>
                                </li>
                            </div>
                            <button type="submit" class="btn btn-success">Change Password</button>
                        </form>
                        <div class="mt-3">
                            <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#changePassword">Forgot Password?</button>
                        </div>
                    </div>
                </div>
                <div class="loginHistory" id="loginHisotryID" style="display:none; width: 95%; height:75vh;">
                    <div class="container shadow p-5 w-100 h-100 rounded-2 d-flex justify-content-between align-items-start flex-wrap overflow-scroll">
                        <?php if($adminHistory): ?>
                            <div class="w-50">
                                <h3 class="text-center fw-bold" style="width: 98% !important;">Login Time</h3>
                                <?php foreach($adminHistory as $history): ?>
                                    <p class="text-center my-1 p-2 bg-light border border-secondary-subtle rounded" style="width: 98% !important;">
                                        <?= date('F j, Y h:i A', strtotime($history['login_time'])) ?>
                                    </p>
                                <?php endforeach ?>
                            </div>
                            <div class="w-50">
                                <h3 class="text-center fw-bold" style="width: 98% !important;">Logout Time</h3>
                                <?php foreach($adminHistory as $history): ?>
                                    <p class="text-center my-1 p-2 bg-light border border-secondary-subtle rounded" style="width: 98% !important;">
                                        <?= isset($history['logout_time']) ? date('F j, Y h:i A', strtotime($history['logout_time'])) : 'Not logged out' ?>
                                    </p>
                                <?php endforeach ?>
                            </div>
                        <?php endif ?>
                    </div>
                </div>
                <!-- ============================ Change Password Modal End ============================ -->
                <div class="modal fade" id="changePassword" tabindex="-1" aria-labelledby="passwordModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <form method="POST" action="../../auth/authentications.php" class="modal-content">
                            <?php isset($_SESSION["csrf_token"]) && $_SESSION["csrf_token"] !== "" ? $csrf = $_SESSION["csrf_token"] : " null "; ?>
                            <input type="hidden" name="csrf_token" value="<?php echo $csrf; ?>">
                            <input type="hidden" name="forgotPassword" value="true">
                            <div class="modal-header bg-success">
                                <h5 class="modal-title text-start w-100" id="passwordModalLabel" style="color: #fff;">Enter your username:</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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