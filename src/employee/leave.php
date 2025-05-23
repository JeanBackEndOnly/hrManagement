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
    $leavCounts = $info['leavCounts'];
    $profileE = $info['profileE'];
    ?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LEAVE</title>
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
        <div class="contents">
        <div class="headerL">
                <h3 id="hs">LEAVE MANAGEMENT</h3>
            </div>
            
            <div class="leaveColumn">
                <div class="headLeave">
                    <h5>Leave Type</h5>
                    <h5>Credit</h5>
                    <h5>Used Credit</h5>
                    <h5>Remaining Credit</h5>
                    <h5>Action</h5>
                </div>
                <div class="breavement-leave">
                    <p>breavement-leave</p>
                    <p>9</p>
                    <p><?php echo 9 - $leavCounts["Breavement"] ?></p>
                    <p><?php echo $leavCounts["Breavement"] ?></p>
                    <p><button type="button" onclick="hiddenFormB()"><i class="fa-solid fa-right-from-bracket"></i></button></p>
                    <div class="hiddenBreavement" id="hiddenBreavement" style="display: none;">
                        
                    <div class="backening">
                            <button type="button" onclick="backPOW()"><i class="fa-solid fa-arrow-left"></i></button>
                            <button type="button" id="buttonDAte" onclick="addDateInput('leaveDatesContainer')">ADD DATE</button>
                        </div>
                        <form action="../../auth/authentications.php" method="post" enctype="multipart/form-data">
                            <div class="errors">
                                <?php
                                    leaveEmployee();
                                ?>
                            </div>
                        
                            <input type="hidden" name="leave" value="employee">
                            <input type="hidden" name="employeeID" value="<?php echo $leavCounts["employeeID"]; ?>">
                            <?php isset($_SESSION["csrf_token"]) && $_SESSION["csrf_token"] !== "" ?  $csrf_token = $_SESSION["csrf_token"] : null ?>
                            <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                            <ul id="leaveDatesContainer">
                                <li>
                                    <label for="leave_dates">Leave Date</label>
                                    <input type="date" name="Leave_Date[]" id="leave_dates">
                                </li>
                            </ul>
                            <li>
                                <label for="picture">Picture Of Proof</label>
                                <input type="file" name="prof" onchange="previewImage(event)" data-preview-id="imageProfB">
                                <img src="../../assets/image/image.png" alt="Prof Image Here" id="imageProfB">
                            </li>
                            <input type="hidden" name="leave_Type" value="Breavement">
                            <button id="leaveBUtton">Submit Leave</button>
                        </form>
                    </div>
                </div>
                <div class="breavement-leave">
                    <p>Maternity Leave</p>
                    <p>120</p>
                    <p><?php echo 120 - $leavCounts["Maternity"] ?></p>
                    <p><?php echo $leavCounts["Maternity"] ?></p>
                    <p><button type="button" onclick="hiddenFormM()"><i class="fa-solid fa-right-from-bracket"></i></button></p>
                    <div class="hiddenBreavement" id="hiddenMaternity" style="display: none;">
                        
                    <div class="backening">
                            <button type="button" onclick="backPOW()"><i class="fa-solid fa-arrow-left"></i></button>
                            <button type="button" id="buttonDAte" onclick="addDateInput('leaveDatesContainerM')">ADD DATE</button>
                        </div>
                        <form action="../../auth/authentications.php" method="post" enctype="multipart/form-data">
                            <div class="errors">
                                <?php
                                    leaveEmployee();
                                ?>
                            </div>
                        
                            <input type="hidden" name="leave" value="employee">
                            <input type="hidden" name="employeeID" value="<?php echo $leavCounts["employeeID"]; ?>">
                            <?php isset($_SESSION["csrf_token"]) && $_SESSION["csrf_token"] !== "" ?  $csrf_token = $_SESSION["csrf_token"] : null ?>
                            <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                            <ul id="leaveDatesContainerM">
                                <li id="hsd">
                                    <label for="leave_dates">Leave Date</label>
                                    <input type="date" name="Leave_Date[]" id="leave_dates">
                                </li>
                            </ul>
                            <li>
                                <label for="picture">Picture Of Proof</label>
                                <input type="file" name="prof" onchange="previewImage(event)" data-preview-id="imageProfM">
                                <img src="../../assets/image/image.png" alt="Prof Image Here" id="imageProfM">
                            </li>
                            <input type="hidden" name="leave_Type" value="Maternity">
                            <button id="leaveBUtton">Submit Leave</button>
                        </form>
                    </div>
                </div>
                <div class="breavement-leave">
                    <p>Paternity Leave</p>
                    <p>7</p>
                    <p><?php echo 7 - $leavCounts["Paternity"] ?></p>
                    <p><?php echo $leavCounts["Paternity"] ?></p>
                    <p><button type="button" onclick="hiddenFormP()"><i class="fa-solid fa-right-from-bracket"></i></button></p>
                    <div class="hiddenBreavement" id="hiddenPaternity" style="display: none;">
                        
                    <div class="backening">
                            <button type="button" onclick="backPOW()"><i class="fa-solid fa-arrow-left"></i></button>
                            <button type="button" id="buttonDAte" onclick="addDateInput('leaveDatesContainerP')">ADD DATE</button>
                        </div>
                        <form action="../../auth/authentications.php" method="post" enctype="multipart/form-data">
                            <div class="errors">
                                <?php
                                    leaveEmployee();
                                ?>
                            </div>
                        
                            <input type="hidden" name="leave" value="employee">
                            <input type="hidden" name="employeeID" value="<?php echo $leavCounts["employeeID"]; ?>">
                            <?php isset($_SESSION["csrf_token"]) && $_SESSION["csrf_token"] !== "" ?  $csrf_token = $_SESSION["csrf_token"] : null ?>
                            <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                            <ul id="leaveDatesContainerP">
                                <li>
                                    <label for="leave_dates">Leave Date</label>
                                    <input type="date" name="Leave_Date[]" id="leave_dates">
                                </li>
                            </ul>
                            <li>
                                <label for="picture">Picture Of Proof</label>
                                <input type="file" name="prof" onchange="previewImage(event)" data-preview-id="imageProfP">
                                <img src="../../assets/image/image.png" alt="Prof Image Here" id="imageProfP">
                            </li>
                            <input type="hidden" name="leave_Type" value="Paternity">
                            <button id="leaveBUtton">Submit Leave</button>
                        </form>
                    </div>
                </div>
                <div class="breavement-leave">
                    <p>Sick Leave</p>
                    <p>10</p>
                    <p><?php echo 10 - $leavCounts["Sick"] ?></p>
                    <p><?php echo $leavCounts["Sick"] ?></p>
                    <p><button type="button" onclick="hiddenFormS()"><i class="fa-solid fa-right-from-bracket"></i></button></p>
                    <div class="hiddenBreavement" id="hiddenSick" style="display: none;">
                        
                    <div class="backening">
                            <button type="button" onclick="backPOW()"><i class="fa-solid fa-arrow-left"></i></button>
                            <button type="button" id="buttonDAte" onclick="addDateInput('leaveDatesContainerS')">ADD DATE</button>
                        </div>
                        <form action="../../auth/authentications.php" method="post" enctype="multipart/form-data">
                            <div class="errors">
                                <?php
                                    leaveEmployee();
                                ?>
                            </div>
                        
                            <input type="hidden" name="leave" value="employee">
                            <input type="hidden" name="employeeID" value="<?php echo $leavCounts["employeeID"]; ?>">
                            <?php isset($_SESSION["csrf_token"]) && $_SESSION["csrf_token"] !== "" ?  $csrf_token = $_SESSION["csrf_token"] : null ?>
                            <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                            <ul id="leaveDatesContainerS">
                                <li>
                                    <label for="leave_dates">Leave Date</label>
                                    <input type="date" name="Leave_Date[]" id="leave_dates">
                                </li>
                            </ul>
                            <li>
                                <label for="picture">Picture Of Proof</label>
                                <input type="file" name="prof" onchange="previewImage(event)" data-preview-id="imageProfS">
                                <img src="../../assets/image/image.png" alt="Prof Image Here" id="imageProfS">
                            </li>
                            <input type="hidden" name="leave_Type" value="Sick">
                            <button id="leaveBUtton">Submit Leave</button>
                        </form>
                    </div>
                </div>
                <div class="breavement-leave">
                    <p>Vacation Leave</p>
                    <p>7</p>
                    <p><?php echo 7 - $leavCounts["Vacation"] ?></p>
                    <p><?php echo $leavCounts["Vacation"] ?></p>
                    <p><button type="button" onclick="hiddenFormV()"><i class="fa-solid fa-right-from-bracket"></i></button></p>
                    <div class="hiddenBreavement" id="hiddenVacation" style="display: none;">
                        
                    <div class="backening">
                            <button type="button" onclick="backPOW()"><i class="fa-solid fa-arrow-left"></i></button>
                            <button type="button" id="buttonDAte" onclick="addDateInput('leaveDatesContainerV')">ADD DATE</button>
                        </div>
                        <form action="../../auth/authentications.php" method="post" enctype="multipart/form-data">
                            <div class="errors">
                                <?php
                                    leaveEmployee();
                                ?>
                            </div>
                        
                            <input type="hidden" name="leave" value="employee">
                            <input type="hidden" name="employeeID" value="<?php echo $leavCounts["employeeID"]; ?>">
                            <?php isset($_SESSION["csrf_token"]) && $_SESSION["csrf_token"] !== "" ?  $csrf_token = $_SESSION["csrf_token"] : null ?>
                            <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                            <ul id="leaveDatesContainerV">
                                <li>
                                    <label for="leave_dates">Leave Date</label>
                                    <input type="date" name="Leave_Date[]" id="leave_dates">
                                </li>
                            </ul>
                            <li>
                                <label for="picture">Picture Of Proof</label>
                                <input type="file" name="prof" onchange="previewImage(event)" data-preview-id="imageProfV">
                                <img src="../../assets/image/image.png" alt="Prof Image Here" id="imageProfV">
                            </li>
                            <input type="hidden" name="leave_Type" value="Vacation">
                            <button id="leaveBUtton">Submit Leave</button>
                        </form>
                    </div>
                </div>
                <div class="breavement-leave">
                    <p>Wedding Leave</p>
                    <p>7</p>
                    <p><?php echo 7 - $leavCounts["Wedding"] ?></p>
                    <p><?php echo $leavCounts["Wedding"] ?></p>
                    <p><button type="button" onclick="hiddenFormW()"><i class="fa-solid fa-right-from-bracket"></i></button></p>
                    <div class="hiddenBreavement" id="hiddenWedding" style="display: none;">
                        
                        <div class="backening">
                            <button type="button" onclick="backPOW()"><i class="fa-solid fa-arrow-left"></i></button>
                            <button type="button" id="buttonDAte" onclick="addDateInput('leaveDatesContainerW')">ADD DATE</button>
                        </div>
                        <form action="../../auth/authentications.php?id=<?php echo $leavCounts["users_id"] ?>" method="post" enctype="multipart/form-data">
                            <div class="errors">
                                <?php
                                    leaveEmployee();
                                ?>
                            </div>
                        
                            <input type="hidden" name="leave" value="employee">
                            <?php isset($_SESSION["csrf_token"]) && $_SESSION["csrf_token"] !== "" ?  $csrf_token = $_SESSION["csrf_token"] : null ?>
                            <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                            <ul id="leaveDatesContainerW">
                                <li>
                                    <label for="leave_dates">Leave Date</label>
                                    <input type="date" name="Leave_Date[]" id="leave_dates">
                                </li>
                            </ul>
                            <li>
                                <label for="picture">Picture Of Proof</label>
                                <input type="file" name="prof" onchange="previewImage(event)" data-preview-id="imageProfW">
                                <img src="../../assets/image/image.png" alt="Prof Image Here" id="imageProfW">
                            </li>
                            <input type="hidden" name="leave_Type" value="Wedding">
                            <button id="leaveBUtton">Submit Leave</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="hiddenDeleteBUtton" id="hiddenDeleteBUtton" style="display:none;">
                <p id="updateP">Are you sure you want to Delete this Leave?</p>
                <?php isset($_SESSION["csrf_token"]) && $_SESSION["csrf_token"] !== "" ? $csrf_token = $_SESSION["csrf_token"] : null; ?>
                <form action="" id="deleteLeaveHistory" method="post">
                    <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                    <input type="hidden" value="adminLeave" name="delete">
                    <input type="hidden" value="" id="leaveID" name="leaveID">
                    <div class="nanii">
                    <button id="delete">Yes</button>
                </form>
                <button type="button" id="view" onclick="cancelThis()">no</button>
                </div>
            </div>
            <div class="LeaveHistory">
                <h3 id="h">My Leave History</h3>
                <div class="headerHistory">
                        <h5>#</h5>
                        <h5>ID</h5>
                        <h5>Surname</h5>
                        <h5>Leave Type</h5>
                        <h5>Proof</h5>
                        <h5>Date of Leave</h5>
                        <h5>Request At</h5>
                    </div>
                <div class="leaveList" id="leaveList">
                </div>
            </div>
        </div>
    </div>
    <?php
    approvedSuccess();
   ?>
    <script src="../../assets/js/hr/hrLL.js"></script>
    <script src="../../assets/js/hr/leaveE.js"></script>
</body>
</html>