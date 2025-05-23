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
                <img src="../../assets/image/users.png" alt="pfp" id="pfpOnTop">
                <p><?php echo $admin_info["firstname"] ." "; ?><i class="fa-solid fa-caret-down"></i></p>
            </button>
            
            <div class="profileMenu" id="profileMenu" style="display: none;">
                <li id="borderBottom"><a href="profile.php"><p><i class="fa-solid fa-user"></i>PROFILE</p></a></li>
                <li id="borderBottom"><a href="settings.php"><p><i class="fa-solid fa-gear"></i>SETTINGS</p></a></li>
                <li><a href="../adminLogout.php" id="l"><p><i class="fa-solid fa-right-from-bracket"></i>LOGOUT</p></a></li>
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
                            <a href="employee.php"><p><i class="fa-solid fa-users"></i>RECRUITMENTS</p></a>
                            <a href="fillReq.php"><p><i class="fa-solid fa-code-pull-request"></i>FILING REQUEST</p></a>
                            <a href="leave.php"><p><i class="fa-solid fa-file-export"></i>LEAVE REQUEST</p></a>
                            <a href="Jobs.php"><p><i class="fa-solid fa-briefcase"></i>JOB TITLES</p></a>
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
                    <h3>TOTAL EMPLOYEES</h3>
                    <h1 id="number"><?php echo $count; ?></h1>
                    <h5>Verified Users</h5>
                </div>
                <div class="counts">
                    <h3>HOSPITAL DEPARTMENT</h3>
                    <h1 id="number"><?php echo $hospital; ?></h1>
                    <h5>Employees</h5>
                </div>
                <div class="counts">
                    <h3>SCHOOL DEPARTMENT</h3>
                    <h1 id="number"><?php echo $school; ?></h1>
                    <h5>Employees</h5>
                </div>
            </div>

            <?php
             echo '<div class="activeStatus">';
             echo '<div class="activeHeader">';
                                echo '<h5 id="name">NAME</h5>';
                                echo '<h5 id="department">DEPARTMENT</h5>';
                                echo '<h5 id="active">ACTIVE</h5>';
                            echo '</div>';
           $latestEntries = [];
            foreach ($LoggedInHistory as $row) {
                $userId = $row['users_id'];
                if (!isset($latestEntries[$userId]) || strtotime($row['inOut_at']) > strtotime($latestEntries[$userId]['inOut_at'])) {
                    $latestEntries[$userId] = $row;
                }
            }
            if($latestEntries){
                foreach ($latestEntries as $row) {
                    $loginActive = $row["Logged_in"];
                    $loginOffline = $row["logged_out"];
                    $userId = $row["users_id"];
                   
                    foreach ($getUsers as $user) {
                        if ($user["id"] == $userId) {
                            if (strtotime($loginActive) && strtotime($loginActive) > strtotime($loginOffline)) {
                          
                                 
                                 echo '<div class="activeUser">';
                                     echo '<ul>';
                                        echo ' <li id="names">' . $user["Lname"] . ", " . $user["Fname"] .'</li>';
                                        echo ' <li id="departments">' . $user["department"] .'</li>';
                                        echo ' <li id="actives"><i class="fa-solid fa-circle" style="color: #1EFF00;"></i></li>';
                                     echo '</ul>';
                                 echo '</div>';
                            
                            }
                            
                        }
                    }
             }
            }else{
            echo '<div class="no_activeUser">';
                           echo '<p>NO USER ACTIVE</p>';
                    echo '</div>';
        }
           
        echo '</div>';
            ?>

        </div>
    </div>
    <script src="../../assets/js/hr/hrLL.js"></script>
</body>
</html>