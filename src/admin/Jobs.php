<?php include_once '../../auth/control.php'; $info = getUsersInfo();
    $admin_info = $info['admin_info'];
    $getUsers = $info['getUsers'];
    $hasPending = $info['StatusPending'];
    $hasReject = $info['StatusRejected'];
    $StatusApproved = $info['StatusApproved'];
    $LoggedInHistory = $info['LoggedInHistory'];
    $count = $info['count'];
    $jobs = $info['jobs'];
    ?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JOB TITLE MANAGEMENT</title>
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
            <div class="jobs">
                <h2>JOB TITLES</h2>
                <button type="button" id="edit" onclick="addJobs()">ADD</button>
            </div>
            <div class="job-list">
            <div class="jobHeader">   
                 <h2 id="id">ID</h2>
                 <h2 id="jobsId">JOBS</h2>
                 <h2 id="actions">Action</h2>
             </div>
             <div class="rowJobs">
                <?php
                    echo' <ul class="idList">';
                        foreach($jobs as $row){
                            echo '<h3> ' . $row["id"] . '</h3>';
                        }
                        echo'</ul>';

                        echo' <ul class="jobLists">';
                        foreach($jobs as $row){
                            echo '<h3> ' . $row["jobs"] . '</h3>';
                        }
                        echo'</ul>';

                        echo' <ul class="actionList">';
                        foreach($jobs as $row){
                            echo '<button type="button" onclick="deleteJob(' . $row["id"] . ')"><i class="fa-solid fa-trash"></i></button>';
                        }
                            echo'</ul>';
                    
                    ?>
                    <div class="deleteJob" id="deleteJobs" style="display: none;">
                        <p>Are You sure you want to delete this Job Title?</p>
                        <div class="buttonsCenter">
                            <form action="" id="deleteForm" method="post">
                                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION["csrf_token"]; ?>">
                                <input type="hidden" name="job" value="delete">
                                <input type="hidden" id="jobID" name="id" value="">
                                <button id="delete">Yes</button> 
                            </form>
                            <button type="button" id="view" onclick="CancelJob()">No</button>
                        </div>
                        
                    </div>
             </div>
                
            </div>
            <div class="hiddenMJ" id="jl" style="display: none;">
                <h2>ADD A JOB TITLES:</h2>
                <form action="../../auth/authentications.php" method="post">
                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION["csrf_token"]; ?>">
                    <input type="hidden" name="addJobs" value="admin">
                    <input type="text" name="jobs" placeholder="Job Title: ">
                    <div class="buttonJob">
                    <button id="edit">Add</button>
                    </div>
                </form>
            </div>
        </div>
        <?php
            approvedSuccess();
        ?>
    </div>
   
    <script src="../../assets/js/hr/hr.js"></script>
    <script src="../../assets/js/hr/hrJ.js"></script>
</body>
</html>