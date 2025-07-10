
<?php function renderHeader() { ?>
    <div class="header d-flex align-items-center justify-content-between px-3" style="height: 60px; min-width: 100%;">
        <div class="logo d-flex align-items-center">
            <button type="button" onclick="sideNav();"><i class="fa-solid fa-bars fs-4 me-3" style="color: #fff;"></i></button>
            <img src="../../assets/image/pueri-logo.png" alt="Logo" style="height: 40px;" class="me-2">
            <h4 class="m-0">ZAMBOANGA PUERICULTURE CENTER</h4>
        </div>

        <div class="usersButton d-flex align-items-center">
            <a href="settings.php"><i class="fa-solid fa-gear" style="color: #fff;"></i></a>
            <button class="me-3" style="background: none; border:none; width: 20px;" onclick="logoutButton()"><i class="fa-solid fa-right-from-bracket ms-3" style="color: #fff;"></i></button>
            <button class="align-items-center" type="button" onclick="userButton()">
                <img src="../../assets/image/admin.jpg" class="rounded-circle me-2 ms-4" style="height: 35px; width: 35px;">
                <span class="fw-bold" style="color: #fff;">ADMIN</span>
            </button>
        </div>
    </div>
    <script>
        function logoutButton(){
            document.getElementById("logoutDiv").style.display = 'flex';
        }
        function logoutNo(){
            document.getElementById("logoutDiv").style.display = 'none';
        }
    </script>
    <div class="logout flex-column" id="logoutDiv" class="p-3" style="position: fixed; transform: translate(-50%, -50%); top:50%; left:50%; display: none; z-index: 55;">
        <div class="shadow rounded p-3" style="background-color:rgb(230, 230, 230);">
            <div class="question mb-3">
                <h5>Are you sure you want to logout?</h5>
            </div>
            <div class="buttons d-flex flex-row justify-content-evenly w-100 mt-1" style="border-top: solid 1px rgba(0,0,0,.4);">
                <a href="logout.php" id="logoutYes" class="col-md-5 btn btn-danger btn-sm mt-2">Yes</a>
                <button id="logoutNo" class="col-md-5 btn btn-secondary btn-sm mt-2" onclick="logoutNo()">No</button>
            </div>
        </div>
    </div>
<?php } ?>
<?php function renderNav() { ?>
    <div class="sideNav p-0" id="sideHEhe">
        <div class="navs p-0 m-0 mt-2 w-auto">
            <li class="dashboardLi d-flex align-items-center mb-2">
                <a class="p-2 d-flex m-0" href="dashboard.php" class="d-flex align-items-center w-100">
                    <i id="dashoardi" class="fa-solid fa-house fs-5 me-2 me-side-text2"></i>
                    <p class="text-start side-text m-0" id="pdashboard">Dashboard</p>
                </a>
            </li>
            <li class="hrLi d-flex align-items-center mb-2 w-100">
                <button type="button" onclick="hrButton()" class="p-0 m-0 w-100 h-100 d-flex align-items-center p-2">
                    <i id="hri" class="fa-solid me-2 fa-users"></i>
                    <p class="text-start side-text" id="phr">HR Management</p>
                    <i id="iLeftArrowHr" class="fa-solid fa-chevron-left" style="display:none;"></i>
                </button>
            </li>

            <ul id="hrUl" class="flex-column m-0 ps-4" style="display:none;">
                <li class="my-1"><a class="p-2 d-flex m-0" href="employee.php" class="d-flex justify-content-start"><i class="fa-solid me-1 fa-users-gear d-flex align-items-center"></i><p style="display:flex;" id="pNone" class="text-start">RECRUITMENTS</p></a></li>
                <li class="my-1"><a class="p-2 d-flex m-0" href="leave.php"  class="d-flex justify-content-start"><i class="fa-solid me-1 d-flex align-items-center fa-file-export"></i><p style="display:flex;" id="pNone" class="text-start">LEAVE REQUEST</p></a></li>
                <li class="my-1"><a class="p-2 d-flex m-0" href="job.php"  class="d-flex justify-content-start"><i class="fa-solid me-1 d-flex align-items-center fa-briefcase"></i><p style="display:flex;" id="pNone" class="text-start">JOB & SALARY</p></a></li>
                <li class="my-1"><a class="p-2 d-flex m-0" href="reports.php"  class="d-flex justify-content-start"><i class="fa-solid me-1 fa-flag" d-flex align-items-center></i><p style="display:flex;" id="pNone" class="text-start">Reports</p></a></li>
            </ul>

            <li class="payrollLi d-flex align-items-center mb-2">
                <button type="button" onclick="payrollButton()" class="p-0 m-0 w-100 h-100 d-flex align-items-center p-2">
                    <i id="payrolli" class="fa-solid me-2 fa-peso-sign"></i>
                    <p class="text-start side-text" id="ppr">Payroll Management</p>
                    <i id="iLeftArrowPr" class="fa-solid fa-chevron-left" style="display:none;"></i>
                </button>
            </li>

            <ul id="payrollUl" class="flex-column m-0 ps-4 " style="display:none;">
                <li class="my-1"><a class="p-2 d-flex m-0" href="payroll/process.php"><i class="fa-solid me-1 fa-users-gear"></i>PROCESS</a></li>
                <li class="my-1"><a class="p-2 d-flex m-0" href="payroll/Config.php"><i class="fa-solid me-1 fa-file-export"></i>CONFIG</a></li>
                <li class="my-1"><a class="p-2 d-flex m-0" href="payroll/Reports.php"><i class="fa-solid me-1 fa-briefcase"></i>REPORTS</a></li>
                <li class="my-1"><a class="p-2 d-flex m-0" href="payroll/Deduction Slip.php"><i class="fa-solid me-1 fa-file-export"></i>DEDUCTION SLIP</a></li>
                <li class="my-1"><a class="p-2 d-flex m-0" href="payroll/Loan Request.php"><i class="fa-solid me-1 fa-briefcase"></i>LOAN REQUEST</a></li>
            </ul>

            <li class="attendanceLi d-flex align-items-center mb-2">
                <a class="p-2 d-flex m-0" href="#" class="p-0 m-0 w-100 h-100 d-flex align-items-center">
                    <i class="fa-solid me-2 fa-clock"></i>
                    <p class="text-start side-text" id="pa">Attendance</p>
                </a>
            </li>

            <li class="settingsLi d-flex align-items-center mb-2">
                <a class="p-2 d-flex m-0" href="settings.php" class="p-0 m-0 w-100 h-100 d-flex align-items-center">
                    <i class="fa-solid me-2 fa-gear"></i>
                    <p class="text-start side-text" id="ps">Settings</p>
                </a>
            </li>
        </div>
                
            </div>
<?php } ?>
