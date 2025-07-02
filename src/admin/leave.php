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
            <div class="contents w-100 h-100 d-flex flex-column align-items-center p-0 m-0">
               <div class="header-employee d-flex flex-row justify-content-start align-items-center col-md-3 col-md-11 flex-wrap m-0" style="height:7rem;">
                    <div class="h1 col-md-3 col-12">
                        <h3 class="m-0">EMPLOYEE PROFILE</h3>
                    </div>
                </div>
                <div class="content col-md-11 col-11 h-75 shadow rounded-2 d-flex flex-column align-items-center p-2 m-0 mt-1">
                    <div class="title w-100 h-auto d-flex flex-column justify-content-center align-items-center p-0 m-0">
                        <h5 class="text-center">ZAMBOANGA PUERICULTURE CENTER ORG. NO.144 INC.</h5>
                        <h5 style="border-bottom: solid 1px #000;">APPLICATION FOR LEAVE</h5>
                    </div>
                    <div class="form d-flex flex-row justify-content-between align-items-center p-0 m-0 w-100 mt-1 h-auto flex-wrap">
                        <div class="col-md-11 d-flex flex-row flex-row justify-content-between align-items-center flex-wrap">
                            <div class="col-md-10 col-11 d-flex flex-row justify-content-between flex-wrap">
                                <div class="col-md-4 d-flex flex-column col-12">
                                    <label class="ms-3" for="lname">Last Name</label>
                                    <input type="text" name="lname" id="lname" class="form-control">
                                </div>
                                <div class="col-md-4 col-11 d-flex flex-column col-12">
                                    <label class="ms-3" for="fname">First Name</label>
                                    <input type="text" name="fname" id="fname" class="form-control">
                                </div>
                                <div class="col-md-4 col-11 d-flex flex-column col-12">
                                    <label class="ms-3" for="mname">Middle Name</label>
                                    <input type="text" name="mname" id="mname" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-2 d-flex flex-column">
                                <label class="ms-1" for="dateLeave">DATE OF FILING</label>
                                <input type="text" name="dateLeave" id="dateLeave" class="form-control">
                            </div>
                        </div>
                        <div class="positionDept col-md-11 col-12 d-flex flex-row justify-content-between align-items-center p-0 m-0 mt-3 flex-wrap">
                            <div class="position col-md-6 d-flex flex-column col-12">
                                <label class="ms-1" for="position">POSITION</label>
                                <input type="text" name="position" class="form-control" id="position">
                            </div>
                            <div class="position col-md-6 d-flex flex-column col-12">
                                <label class="ms-1" for="Dept">DEPARTMENT/SECTION</label>
                                <input type="text" name="department" class="form-control" id="Dept">
                            </div>
                        </div>
                        <div class="applied col-md-11 col-12 d-flex flex-row h-auto justify-content-between align-items-center p-0 m-0 mt-2 flex-wrap">
                            <div class="label col-md-2 ms-2">
                                <label for="">LEAVE APPLIED FOR</label>
                            </div>
                            <div class="row col-md-2 d-flex flex-row">
                                <label for="vacation"><input type="radio" class="me-1" id="vacation">Vacation Leave</label>
                            </div>
                            <div class="row col-md-2 d-flex flex-row">
                                <label for="sick"><input type="radio" class="me-1" id="sick">Sick Leave</label>
                            </div>
                            <div class="row col-md-2 d-flex flex-row">
                                <label for="special"><input type="radio" class="me-1" id="special">Special Leave</label>
                            </div>
                            <div class="row col-md-3 d-flex flex-row">
                                <label for="others">Others Specify</label>
                                <input type="text" class="form-control me-1" id="others">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?php include '../../templates/Ufooter.php'?>