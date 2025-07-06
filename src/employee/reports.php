<?php include '../../templates/Uheader.php';?>
<?php if (isset($_GET['open_pdf']) && $_GET['open_pdf'] == '1') : ?>
<script>
    window.onload = function () {
        window.open('../admin/pdfGenerator.php?users_id=<?php echo $_GET["users_id"]; ?>&leave_id=<?php echo $_GET["leave_id"]; ?>', '_blank');
    };
</script>
<?php endif;  ?>
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
                        <a href="#" class="p-0 m-0 w-100 h-100 d-flex align-items-center">
                            <i class="fa-solid me-2 fa-gear"></i>
                            <p class="text-start side-text" id="ps">Settings</p>
                        </a>
                    </li>
                </div>
                
            </div>
            <div class="contents w-100 h-100 d-flex flex-column align-items-center p-0 m-0">
                <div class="header-employee m-0 d-flex flex-row justify-content-start align-items-center col-md-11 flex-wrap" style="height: 5rem !important;">
                    <div class="h1 col-md-4 col-12 m-0">
                        <h3 class="h3-employee m-0">REPORTS</h3>
                    </div>
                </div>
                <div class="container col-md-11 col-11 d-flex justify-content-start align-items-start h-auto m-0 flex-wrap">
                    <?php foreach ($leaveEmployeeResult as $leave) : ?>
                        <?php if ($leave['leaveStatus'] == 'approved') : ?>
                            <div class="reportContainers shadow rounded-2 h-auto col-md-5 col-12 d-flex flex-row justify-content-center align-items-center flex-wrap p-4 m-1">
                                <h5 class="text-start w-100" style="color: green;">Congratiolations! </h5> <p class="text-start w-100 mb-1">your leave have been approved!</p>
                                <p class="m-0 w-100 text-start">You can see the details here: <a href="reports.php?users_id=<?= $leave["users_id"] ?? '' ?>&leave_id=<?= $leave["leave_id"] ?? ''?>&open_pdf=1" class="btn btn-primary">view</a></p>
                            </div>
                        <?php endif ?>
                        <?php if ($leave['leaveStatus'] == 'disapprove') : ?>
                            <div class="reportContainers shadow rounded-2 h-auto col-md-5 col-12 d-flex flex-row justify-content-center align-items-center flex-wrap p-4 m-1">
                                <h5 class="text-start w-100" style="color: red;">We were sorry but, </h5> <p class="text-start w-100 mb-1">your leave have been disapproved!</p>
                                <p class="m-0 w-100 txt-start">You can see the details here: <a href="reports.php?users_id=<?= $leave["users_id"] ?? '' ?>&leave_id=<?= $leave["leave_id"] ?? ''?>&open_pdf=1" class="btn btn-primary">view</a></p>
                            </div>
                         <?php endif ?>
                    <?php endforeach ?>
                </div>
            </div>
        </div>
    </div>
</main>
<?php include '../../templates/Ufooter.php'?>