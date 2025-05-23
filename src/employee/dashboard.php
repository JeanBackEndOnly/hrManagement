<?php include_once '../../auth/control.php'; $info = getUsersInfo();
    $admin_info = $info['admin_info'];
    $getUsers = $info['getUsers'];
    $hasPending = $info['StatusPending'];
    $hasReject = $info['StatusRejected'];
    $StatusApproved = $info['StatusApproved'];
    $LoggedInHistory = $info['LoggedInHistory'];
    $count = $info['count'];
    $school = $info['school'];
    $hospital = $info['hospital'];
    $profileE = $info['profileE'];
    $rejectCounts = $info['rejectCounts'];
    $approvedCounts = $info['approvedCounts'];
    $SalaryRange = $info['SalaryRange'];
    ?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DASHBOARD</title>
    <!-- <link rel="stylesheet" href="../../assets/css/main_frontend.css?v=<?php echo time(); ?>"> -->
    <link rel="stylesheet" href="../../assets/css/hr.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"/>
    <style>
      @import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css');
    </style>
    <script src="../../assets/js/main.js"></script>
</head>
<body>
    <div class="header">
        <div class="logo">
            <h3>ZAMBOANGA PUERICULTURE CENTER ORG.</h3>
        </div>
        <div class="otherButtons">
            <button type="submit" onclick="profileMenu()" id="buttonpfpmenu">
                <img src="../../assets/image/upload/<?php echo $profileE["user_profile"] ?>" alt="pfp" id="pfpOnTop">
                <p><?php echo $profileE["Lname"] .", " . $profileE["Fname"]; ?><i class="fa-solid fa-caret-down"></i></p>
            </button>
            
            <div class="profileMenu" id="profileMenu" style="display: none;">
                <li id="borderBottom"><a href="profile.php"><p><i class="fa-solid fa-user"></i>PROFILE</p></a></li>
                <li id="borderBottom"><a href="settings.php"><p><i class="fa-solid fa-gear"></i>SETTINGS</p></a></li>
                <li><a href="../logout.php" id="l"><p><i class="fa-solid fa-right-from-bracket"></i>LOGOUT</p></a></li>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="sideNav">
            <div class="sideContents" id="sideContents">
                <div class="profileBox">
                <img src="../../assets/image/pueri-logo.png" alt="pfp" id="pfpOnTop">
                    <h4>Since 1913</h4>
                    <p>Zamboanga Peninsula Region IX</p>
                </div>
                <div class="menuBox">
                    <ul>
                    <a href="dashboard.php" id="dashboard-a"><button><i class="fa-solid fa-house-user"></i>DASHBOARD</button></a>
                        <button type="submit" onclick="getHrNavs()">EMPLOYEES<i class="fa-solid fa-caret-down" id="iLeft"></i></button>
                        <ul style="display: none;" id="hrNavs" class="hrNavs">
                            <a href=""><p><i class="fa-solid fa-code-pull-request"></i>FILING REQUEST</p></a>
                            <a href="leave.php"><p><i class="fa-solid fa-file-export"></i>LEAVE REQUEST</p></a>
                        </ul>
                        <button type="submit" onclick="getPayrollNavs()">TRANSACTIONS<i class="fa-solid fa-caret-down" id="iLeft"></i></button>
                        <ul style="display: none;" id="payrollNavs">
                            <a href=""><p>PAYROLL  PROCESS</a>
                            <a href=""><p>PAYROLL CONFIG</a>
                            <a href=""><p>PAYROLL REPORTS</a>
                            <a href=""><p>DEDUCTIONS SLIP</a>
                            <a href=""><p>LOAN REQUEST</a>
                        </ul>
                        <button type="submit" onclick="getBioNavs()">BIOMETRICS<i class="fa-solid fa-caret-down" id="iLeft"></i></button>
                        <ul style="display: none;" id="bioNavs">
                            <a href=""><p>ENROLL DATA</p></a>
                            <a href=""><p>DTR MANAGEMENT</p></a>
                            <a href=""><p>TIME CONFIGURATION</p></a>
                            <a href=""><p>SYSTEM SETTING</p></a>
                            <a href=""><p>HISTORY</p></a>
                        </ul>
                    </ul>
                </div>
            </div>
        </div>
        <div class="contents">
            <div class="employeeInfo">
                <div class="counts">
                    <h3>TOTAL LEAVE APPROVED</h3>
                    <h1 id="number"><?php echo $approvedCounts; ?></h1>
                    <h5>Leave</h5>
                </div>
                <div class="counts">
                    <h3>TOTAL LEAVE REJECT</h3>
                    <h1 id="number"><?php echo $rejectCounts; ?></h1>
                    <h5>Leave</h5>
                </div>
                <div class="counts">
                    <h3>SALARY RANGE</h3>
                    <h1 id="number"><?php echo $SalaryRange["salary_Range_From"] . " - " . $SalaryRange["salary_Range_To"]; ?></h1>
                    <h5>Leave</h5>
                </div>
            </div>
        </div>
    </div>
    <script src="../../assets/js/hr/hrLL.js"></script>
</body>
</html>