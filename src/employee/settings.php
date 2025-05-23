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
    $usersAccount = $info['usersAccount'];
    $historyLogs = $info['historyLogs'];
    ?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DASHBOARD</title>
    <!-- <link rel="stylesheet" href="../../assets/css/main_frontend.css?v=<?php echo time(); ?>"> -->
    <link rel="stylesheet" href="../../assets/css/hr.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="../../assets/css/profile.css?v=<?php echo time(); ?>">
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
        <div class="contents" id="logsHehe">
            
            <div class="chnage-password">
                <?php
                echo '<div class="change">';
                    getErrors_signups();
                echo '</div>';
                
                ?>
            
                <h3>CHANGE PASSWORD HERE</h3>
                    <form action="../../auth/authentications.php?id=<?php echo $usersAccount['id']; ?>" method="post">
                        <input type="hidden" name="password" value="employee">
                        <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                        
                        <input type="password" name="current_password" placeholder="Current Password:" required>
                        <input type="password" name="new_password" placeholder="New Password:" required>
                        <input type="password" name="confirm_password" placeholder="Confirm Password: " required>
                        <div class="buttonDiv">
                            <button>Change password</button>
                        </div>
                        
                    </form>

            </div>
            <div class="historyLogs">
                <h2>HISTORY LOGS</h2>
                <div class="history">
                    <?php
                        foreach($historyLogs as $logs){
                            if (!empty($logs["Logged_in"])) {
                                echo '<li>
                                    <p>Login at - ' . $logs["Logged_in"] . '</p>                            
                                    <p>' . $logs["inOut_at"] . '</p>
                                </li>';
                            }
                            
                            if (!empty($logs["logged_out"])) {
                                echo '<li>
                                    <p>Logout at - ' . $logs["logged_out"] . '</p>                            
                                    <p>' . $logs["inOut_at"] . '</p>
                                </li>';
                            }
                        }
                        
                    ?>
                </div>
            </div>
    </div>
    <?php approvedSuccess(); ?>
    <script src="../../assets/js/hr/hrLL.js"></script>
    
    <script src="../../assets/js/main.js"></script>
    <script>
        function profileMenu(){
            const sd = document.getElementById("profileMenu");
            console.log("button clicked!")
            if(sd.style.display == 'none'){
                sd.style.display = 'flex';
            }else{
                sd.style.display = 'none';
            }
        }
        function menuBar(){
            const buttonMenu = document.getElementById("sideContents");
            console.log("button clicked!")
            if(buttonMenu.style.display == 'none'){
            buttonMenu.style.display = 'flex';
            }else{
            buttonMenu.style.display = 'none';
            }
        }
    </script>
</body>
</html>