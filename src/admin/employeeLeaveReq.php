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
               <div class="header-employee col-md-12 d-flex flex-wrap flex-row justify-content-between align-items-center" style="width: 95%; height: 7rem;">
                    <div class="h1 col-md-7 col-10">
                        <h3 class="h3-employee" style="margin-left: 0;">EMPLOYEE LEAVE REQUEST</h3>
                    </div>
                </div>
                <div class="container rounded-2 shadow py-3">
                    <div class="title w-100 h-auto d-flex flex-column justify-content-center align-items-center p-0 m-0">
                        <h5 class="text-center">ZAMBOANGA PUERICULTURE CENTER ORG. NO.144 INC.</h5>
                        <h5 style="border-bottom: solid 1px #000;">APPLICATION FOR LEAVE</h5>
                    </div>
                    <div class="form col-md-12 col-12 d-flex justify-content-center align-items-center m-0 py-3 h-auto">
                        <form action="../../auth/authentications.php" method="post" clas="d-flex justify-content-center align-items-center py-3 m-0 w-100 mt-1">
                            <?php isset($_SESSION["csrf_token"]) && $_SESSION["csrf_token"] !== "" ? $csrf = $_SESSION["csrf_token"] : " null "; ?>
                            <input type="hidden" name="csrf_token" value="<?php echo $csrf; ?>">
                            <input type="hidden" name="LeaveAdminApproval" value="true">
                            <input type="hidden" name="users_id" value="<?php echo $employeeName["users_id"] ?>">
                            <input type="hidden" name="leave_id" value="<?php echo $leavePending["leave_id"]; ?>">
                            <input type="hidden" name="reportID" value="<?php echo $_GET["reportsID"] ?? ''; ?>">
                            <input type="hidden" name="leaveType" value="<?php echo $leavePending["leaveType"] ?? ''; ?>">
                            <input type="hidden" name="numberOfDays" value="<?php echo $leavePending["numberOfDays"] ?? ''; ?>">
                            <div class="col-md-12 d-flex flex-row justify-content-center align-items-center flex-wrap">
                                <div class="col-md-10 col-11 d-flex flex-row justify-content-between flex-wrap">
                                    <div class="col-md-4 d-flex flex-column col-12">
                                        <label class="ms-1" for="lname">Last Name</label>
                                        <input type="text" name="lname" id="lname" class="form-control" value="<?php echo $employeeName["lname"] ?>">
                                    </div>
                                    <div class="col-md-4 col-11 d-flex flex-column col-12">
                                        <label class="ms-1" for="fname">First Name</label>
                                        <input type="text" name="fname" id="fname" class="form-control" value="<?php echo $employeeName["fname"] ?>">
                                    </div>
                                    <div class="col-md-4 col-11 d-flex flex-column col-12">
                                        <label class="ms-1" for="mname">M.I.</label>
                                        <input type="text" name="mname" id="mname" class="form-control" value="<?php echo $employeeName["mname"] ?>">
                                    </div>
                                </div>
                                <div class="col-md-2 col-11 d-flex flex-column justify-content-center">
                                    <label class="ms-1" for="dateLeave">DATE OF FILING</label>
                                    <input required type="date" name="dateLeave" id="dateLeave" class="form-control"  value="<?php echo $leavePending["leaveDate"] ?>" value="<?php echo $leavePending["leaveDate"] ?>">
                                </div>
                            </div>
                            <div class="positionDept col-md-12 col-12 d-flex flex-row justify-content-center align-items-center p-0 m-0 mt-3 flex-wrap">
                                <div class="position col-md-6 d-flex flex-column col-11">
                                    <label class="ms-1" for="position">POSITION</label>
                                    <input required type="text" name="position" class="form-control"  value="<?php echo $employeeName["jobTitle"] ?>" id="position">
                                </div>
                                <div class="position col-md-6 d-flex flex-column col-11">
                                    <label class="ms-1" for="Dept">DEPARTMENT/SECTION</label>
                                    <input required type="text" name="department" class="form-control"  value="<?php echo $employeeName["department"] . " DEPARTMENT" ?>" id="Dept">
                                </div>
                            </div>
                            <div class="applied col-md-12 col-12 d-flex flex-row h-auto justify-content-between align-items-center p-0 m-0 mt-2 flex-wrap">
                                <div class="label col-md-2">
                                    <label for="" class="fw-bold">LEAVE APPLIED FOR</label>
                                </div>
                                <style>
                                    .radio-selected   { background:#e7f3ff; font-weight:600; border-radius:4px; }
                                    .others-selected  { border:2px solid #0d6efd; }
                                </style>
                                <?php
                                    $currentType  = $leavePending['leaveType'] ?? '';
                                    $currentOther = $leavePending['Others']     ?? '';
                                    $isOther = $currentOther && !in_array($currentType, ['vacation', 'sick', 'special'], true);
                                ?>
                                <div class="row col-md-10 col-12">
                                    <div class="col-md-3 col-11 d-flex flex-row">
                                        <label
                                            for="vacation"
                                            class="<?php echo $currentType === 'vacation' ? 'radio-selected' : '';?>"
                                        >
                                            <input
                                                required
                                                type="radio"
                                                class="me-1"
                                                id="vacation"
                                                name="leaveType"
                                                value="vacation"
                                                <?php echo $currentType === 'vacation' ? 'checked' : '';?>
                                            >
                                            Vacation Leave
                                        </label>
                                    </div>

                                    <div class="col-md-3 col-11 d-flex flex-row">
                                        <label
                                            for="sick"
                                            class="<?php echo $currentType === 'sick' ? 'radio-selected' : '';?>"
                                        >
                                            <input
                                                required
                                                type="radio"
                                                class="me-1"
                                                id="sick"
                                                name="leaveType"
                                                value="sick"
                                                <?php echo $currentType === 'sick' ? 'checked' : '';?>
                                            >
                                            Sick Leave
                                        </label>
                                    </div>

                                    <div class="col-md-3 col-11 d-flex flex-row">
                                        <label
                                            for="special"
                                            class="<?php echo $currentType === 'special' ? 'radio-selected' : '';?>"
                                        >
                                            <input
                                                required
                                                type="radio"
                                                class="me-1"
                                                id="special"
                                                name="leaveType"
                                                value="special"
                                                <?php echo $currentType === 'special' ? 'checked' : '';?>
                                            >
                                            Special Leave
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-12 col-12 d-flex flex-column mt-2">
                                    <label for="others">Others specify</label>
                                    <input
                                        type="text"
                                        class="form-control me-1 <?php echo $isOther ? 'others-selected' : '';?>"
                                        id="others"
                                        name="others"
                                        value="<?php echo htmlspecialchars($currentOther, ENT_QUOTES); ?>"
                                    >
                                </div>
                            </div>
                            <div class="applied col-md-12 col-12 d-flex flex-row h-auto justify-content-center align-items-center p-0 m-0 mt-2 flex-wrap">
                                <label for="cp" class="fw-bold col-md-12 col-11">COURSE/PURPOSE<input required type="text" class="form-control col-11 col-md-11"  value="<?php echo $leavePending["Purpose"] ?>" id="cp" name="purpose"></label>
                            </div>
                            <div class="applied col-md-12 col-12 d-flex flex-row h-auto justify-content-center align-items-center p-0 m-0 mt-3 flex-wrap">
                                <div class="inclusiveDateFrom d-flex flex-column col-md-3 col-11">
                                    <label for="inclusiveDates">INCLUSIVE DATE FROM:</label>
                                    <input required type="date" name="inclusiveDateFrom" id="inclusiveDateFrom" class="form-control" value="<?php echo $leavePending["InclusiveFrom"] ?>">  
                                </div>
                                <div class="inclusiveDates d-flex flex-column col-md-3 col-11">
                                    <label for="inclusiveDateTo">INCLUSIVE DATES TO:</label>
                                    <input required type="date" name="inclusiveDateTo" id="inclusiveDateTo" class="form-control" value="<?php echo $leavePending["InclusiveTo"] ?>">  
                                </div>
                                <div class="noDays d-flex flex-column col-md-6 col-11">
                                    <label for="daysOfLeave">NO. OF DAYS</label>
                                    <input required type="number" name="daysOfLeave" id="daysOfLeave" class="form-control" value="<?php echo $leavePending["numberOfDays"] ?>">  
                                </div>   
                            </div>
                            <div class="applied col-md-12 col-12 d-flex flex-row h-auto justify-content-center align-items-center p-0 m-0 mt-2 flex-wrap">
                                <label for="cp" class="fw-bold col-md-12 col-11">CONTACT NO. WHILE ON LEAVE<input required type="text" class="form-control col-11 col-md-11"  value="<?php echo $leavePending["contact"] ?>" id="cp" name="contact"></label>
                            </div>
                            <div class="text col-md-12 col-11">
                                <p class="text-start">
                                    I hereby pledge to report for work immediately the following day after expiration of my approved leave of absence unless <br>
                                    otherwise duly extended. MMy failure to do so shall subject me to disciplinary action
                                </p>
                            </div>
                            <div class="recommending col-md-12 col-11 d-flex flex-row justify-content-between m-0 mt-4 p-0">
                                <p class="fw-bold">Reommending Approval: </p>
                                <div class="signiture col-md-5 col-5">
                                    <p style="border-bottom: solid 1px #000;" class="m-0"></p>
                                    <p class="text-center">Signiture of Applicant</p>
                                </div>
                            </div>
                            <div class="recommending col-md-12 col-11 d-flex flex-row justify-content-start m-0 mt-4 p-0 flex-wrap gap-2">
                                <div class="sectionHEad col-md-4 col-11">
                                    <label class="fw-bold" for="sectionHead">Section Head</label>
                                    <input required type="text" class="form-control"  value="<?php echo $leavePending["sectionHead"] ?>" id="sectionHead" name="sectionHead">
                                </div>
                                <div class="departmentHead col-md-4 col-11">
                                    <label class="fw-bold" for="departmentHead">Department Head</label>
                                    <input required type="text" class="form-control"  value="<?php echo $leavePending["departmentHead"] ?>" id="departmentHead" name="departmentHead">
                                </div>
                            </div>
                            <!-- ======================  ADMIN ONLY  ====================== -->
                            <div id="approvalContent" class="approvalContent col-md-12 col-11 p-0 m-0 mt-4 d-flex flex-column h-auto"
                                style="border:solid 1px #000;">

                                <h5 class="text-center my-1" style="border-bottom:solid 1px #000;">DETAILS OF ACTION ON APPLICATION</h5>

                                <!-- ❶  Printable table  -->
                                <table id="admin-print-table" class="table table-bordered table-sm mb-0 d-flex flex-column">
                                    <thead class="text-center w-100">
                                        <tr class="w-100">
                                            <th style="width:15.3rem;"></th>
                                            <th style="width:25%">VACATION</th>
                                            <th style="width:25%">SICK</th>
                                            <th style="width:25%">SPECIAL</th>
                                        </tr>
                                    </thead>
                                    <tbody class="col-md-12">
                                       <?php
                                        $VacationBalance  = $leaveCounts['VacationBalance'] ?? 0;
                                        $SickBalance      = $leaveCounts['SickBalance']     ?? 0;
                                        $SpecialBalance   = $leaveCounts['SpecialBalance']  ?? 0;

                                        $NumberOfLeave    = $leavePending['numberOfDays']    ?? 0;     
                                        $leaveTypeFiled   = $leavePending['leaveType']       ?? '';   

                                        $pdo = db_connection();

                                        $sql = "
                                            SELECT leaveDate
                                            FROM   leavereq
                                            WHERE  users_id    = :users_id
                                            AND  leaveStatus = 'approved'
                                            AND  leaveType   = :leaveType
                                            ORDER BY leaveDate DESC
                                            LIMIT 1
                                        ";
                                        $stmt = $pdo->prepare($sql);
                                        $stmt->execute([
                                            ':users_id'  => $leavePending['users_id'],
                                            ':leaveType' => $leaveTypeFiled,
                                        ]);
                                        $prev = $stmt->fetchColumn();        

                                        $earnedSick = $earnedVacation = $earnedSpecial = 0;

                                        if ($prev) {
                                            $lastLeave   = new DateTime($prev);
                                            $thisLeave   = new DateTime($leavePending['leaveDate']);
                                            $daysPassed  = $lastLeave->diff($thisLeave)->days;

                                            $periods15d  = intdiv($daysPassed, 15);   
                                            $earnedUnits = 0.5 * $periods15d;        

                                            $earnedSick =
                                            $earnedVacation =
                                            $earnedSpecial  = $earnedUnits;
                                        }

                                        $VacationCredits = $VacationBalance + $earnedVacation;
                                        $SickCredits     = $SickBalance     + $earnedSick;
                                        $SpecialCredits  = $SpecialBalance  + $earnedSpecial;

                                        $vacationLessLeave = ($leaveTypeFiled === 'vacation') ? $NumberOfLeave : 0;
                                        $sickLessLeave     = ($leaveTypeFiled === 'sick')     ? $NumberOfLeave : 0;
                                        $specialLessLeave  = ($leaveTypeFiled === 'special')  ? $NumberOfLeave : 0;

                                        $vacationBalanceToDate = $VacationCredits - $vacationLessLeave;
                                        $sickBalanceToDate     = $SickCredits     - $sickLessLeave;
                                        $specialBalanceToDate  = $SpecialCredits  - $specialLessLeave;
                                        ?>

                                        <tr class="col-md-12">
                                            <td style="width: 20.1rem;">Balance&nbsp;as&nbsp;of</td>
                                            <td class="col-md-3"><input type="text" name="vacationBalance" class="form-control-plaintext p-1" value="<?= $VacationBalance ?> DAYS"></td>
                                            <td class="col-md-3"><input type="text" name="sickBalance" class="form-control-plaintext p-1" value="<?= $SickBalance ?> DAYS"></td>
                                            <td class="col-md-3"><input type="text" name="specialBalance" class="form-control-plaintext p-1" value="<?= $SpecialBalance ?> DAYS"></td>
                                        </tr>
                                        <tr class="col-md-12">
                                            <td>Leave&nbsp;Earned</td>
                                            <td><input type="text" name="vacationEarned" class="form-control-plaintext p-1" value="+<?= $earnedVacation ?>"></td>
                                            <td><input type="text" name="sickEarned" class="form-control-plaintext p-1" value="+<?= $earnedSick ?>"></td>
                                            <td><input type="text" name="specialEarned" class="form-control-plaintext p-1" value="+<?= $earnedSpecial ?>"></td>
                                        </tr>
                                        <tr>
                                            <td>Total&nbsp;Leave&nbsp;Credits&nbsp;as&nbsp;of</td>
                                            <td><input type="text" name="vacationCredits" class="form-control-plaintext p-1" value="<?= $VacationCredits ?>"></td>
                                            <td><input type="text" name="sickCredits" class="form-control-plaintext p-1" value="<?= $SickCredits ?>"></td>
                                            <td><input type="text" name="specialCredits" class="form-control-plaintext p-1" value="<?= $SpecialCredits ?>"></td>
                                        </tr>
                                        <tr>
                                            <td>Less&nbsp;this&nbsp;Leave</td>
                                            <td><input type="text" name="vacationLessLeave" class="form-control-plaintext p-1" value="<?= ($leaveTypeFiled === 'vacation') ? "-$NumberOfLeave DAYS" : '0' ?>"></td>
                                            <td><input type="text" name="sickLessLeave" class="form-control-plaintext p-1" value="<?= ($leaveTypeFiled === 'sick') ? "-$NumberOfLeave DAYS" : '0' ?>"></td>
                                            <td><input type="text" name="specialLessLeave" class="form-control-plaintext p-1" value="<?= ($leaveTypeFiled === 'special') ? "-$NumberOfLeave DAYS" : '0' ?>"></td>
                                        </tr>
                                        <tr>
                                            <td>Balance&nbsp;to&nbsp;Date</td>
                                            <td><input type="number" name="vacationBalanceToDate" class="form-control-plaintext p-1" value="<?= ($leaveTypeFiled === 'vacation') ? $VacationCredits - $NumberOfLeave : $VacationCredits ?>"></td>
                                            <td><input type="number" name="sickBalanceToDate" class="form-control-plaintext p-1" value="<?= ($leaveTypeFiled === 'sick') ? $SickCredits - $NumberOfLeave : $SickCredits ?>"></td>
                                            <td><input type="number" name="specialBalanceToDate" class="form-control-plaintext p-1" value="<?= ($leaveTypeFiled === 'special') ? $SpecialCredits - $NumberOfLeave : $SpecialCredits ?>"></td>
                                        </tr>

                                    </tbody>
                                </table>

                                <div id="admin-screen-controls" class="recommendation col-md-12 col-12 mt-4">
                                    <div class="d-flex flex-column col-md-12 col-11">
                                        <label for="" class="fw-bold ms-3">Reommendation for:</label>
                                        <div class="row d-flex col-md-11 col-11 flex-row justify-content-start align-items-center m-0 p-0">
                                            <input type="radio" class="col-md-1 col-1" id="approved" name="leaveStatus" value="approved">
                                            <label class="col-md-1 col-1 text-start" for="approved">Approved</label>
                                        </div>
                                        <div class="row d-flex col-md-11 col-11 flex-row justify-content-start align-items-center m-0 p-0">
                                            <input type="radio" class="col-md-1 col-1" id="Disapproval" name="leaveStatus" value="disapprove">
                                            <label class="col-md-7 col-9 text-start" for="Disapproval">Disapproval due to:</label>
                                            <textarea id="" class="form-control ms-3" name="disapprovalDetails" required></textarea>
                                        </div>
                                        <div class="admin mt-5 d-flex flex-row col-md-12 justify-content-center align-items-center gap-5">
                                            <div class="hrdo col-md-5">
                                                <p style="border-bottom: solid 1px #000" class="m-0"></p>
                                                <p class="text-center">HRDO</p>
                                            </div>
                                            <div class="admin col-md-5">
                                                <p style="border-bottom: solid 1px #000" class="m-0"></p>
                                                <p class="text-center">Administrator</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="updateModalEBG" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-md modal-dialog-start">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="updateModalLabel">Leave Request</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modalConfirmation px-3 py-4 text-center">
                                            <h5 class="mb-0">Are you sure you want to submit Leave request??</h5>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-success">Save Changes</button>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="buttonSubmit mt-3 col-md-12 col-12">
                        <button type="button" id="updateButtonEBG" class="btn btn-success col-md-12 col-12" data-bs-toggle="modal" data-bs-target="#updateModalEBG">
                            Submit
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        if (leave) {
            console.log("Showing updateReq toast");
            Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'error',
            title: 'Not enough credits.',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            customClass: { popup: 'swal2-row-toast' }
            });
            removeUrlParams(['leave']);
        }
        function removeUrlParams(params) {
            const url = new URL(window.location);
            params.forEach(param => url.searchParams.delete(param));
            window.history.replaceState({}, document.title, url.toString());
        }
    });
</script>
<?php include '../../templates/Ufooter.php'?>