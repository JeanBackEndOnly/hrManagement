<?php include '../../templates/Uheader.php'; include '../../templates/adminAuth.php';?>

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
            <div class="contents w-100 h-100 d-flex flex-column align-items-center p-0 m-0">
                <div class="header-employee d-flex flex-row justify-content-between align-items-center " style="height: 7rem; width: 95%;">
                    <div class="h1">
                        <h3 class="m-0">DASHBOARD</h3>
                    </div>
                </div>
                <div class="d-flex col-ms-12 flex-row justify-content-start align-items-center flex-wrap" style="height: 7rem; width: 95%;">
                   <a href="employee.php" class="pending shadow-sm rounded-4 p-4 d-flex flex-column justify-content-center align-items-center bg-white me-3 mt-3 col-md-3 col-12" style="min-height: 100px; text-decoration: none;">
                        <div class="d-flex align-items-center mb-3">
                            <div class="text-center me-3">
                                <h1 class="fw-bold text-primary m-0"><?php echo $validatedCount; ?></h1>
                                <small class="text-muted">Users</small>
                            </div>
                            <div class="text-start">
                                <h5 class="m-0 fw-semibold text-dark">Validated</h5>
                                <h6 class="m-0 text-secondary">Employees</h6>
                            </div>
                        </div>
                    </a>
                    <a href="employee.php?tab=request" class="pending shadow-sm rounded-4 p-4 d-flex flex-column justify-content-center align-items-center bg-white me-3 mt-3 col-md-3 col-12" style="min-height: 100px; text-decoration: none;">
                        <div class="d-flex align-items-center mb-3">
                            <div class="text-center me-3">
                                <h1 class="fw-bold text-primary m-0"><?php echo $pendingCount; ?></h1>
                                <small class="text-muted">Users</small>
                            </div>
                            <div class="text-start">
                                <h5 class="m-0 fw-semibold text-dark">Pending</h5>
                                <h6 class="m-0 text-secondary">Employees</h6>
                            </div>
                        </div>
                    </a>
                    <a href="reports.php" class="pending shadow-sm rounded-4 p-4 d-flex flex-column justify-content-center align-items-center bg-white me-3 mt-3 col-md-3 col-12" style="min-height: 100px; text-decoration: none;">
                        <div class="d-flex align-items-center mb-3">
                            <div class="text-center me-3">
                                <h1 class="fw-bold text-primary m-0">
                                    <span id="reportsCountDisplay">0</span>
                                </h1>
                                <small class="text-muted">reports</small>
                            </div>
                            <div class="text-start">
                                <h5 class="m-0 fw-semibold text-dark">Today</h5>
                                <h6 class="m-0 text-secondary">Reports</h6>
                            </div>
                        </div>
                    </a>

                    <div class="reports shadow-sm rounded-4 p-4 d-flex flex-column justify-content-center align-items-center bg-white me-3 mt-3 col-md-3 col-12" style="min-height: 100px;">
                        <div class="d-flex align-items-center mb-3">
                            <div class="text-center me-3">
                                <h1 class="fw-bold text-primary m-0">3</h1>
                                <small class="text-muted">request</small>
                            </div>
                            <div class="text-start">
                                <h5 class="m-0 fw-semibold text-dark">Leave</h5>
                                <h6 class="m-0 text-secondary">Request</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<script>
    fetchReportsCount(); 
</script>
<?php include '../../templates/Ufooter.php'?>