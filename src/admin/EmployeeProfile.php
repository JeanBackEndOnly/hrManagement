<?php include_once '../../auth/control.php'; if(isset($_GET["id"])){
    $_SESSION["profileId"] = $_GET["id"];
}else{
    null;
}

    $info = getUsersInfo();
    $admin_info = $info['admin_info'];
    $getUsers = $info['getUsers'];
    $hasPending = $info['StatusPending'];
    $hasReject = $info['StatusRejected'];
    $StatusApproved = $info['StatusApproved'];
    $LoggedInHistory = $info['LoggedInHistory'];
    $count = $info['count'];
    $school = $info['school'];
    $hospital = $info['hospital'];
    $profile = $info['profile'];
    // isset($_GET["id"]) ? $_SESSION["profileId"] = $_GET["id"] : null;  
    ?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EMPLOYEE PROFILE</title>
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
        <form action="../../auth/authentications.php?id=<?php echo $profile["id"]; ?>" id="UpdateForm" method="post" enctype="multipart/form-data">
            <?php isset($_SESSION["csrf_token"]) && $_SESSION["csrf_token"] !== "" ? $csrf = $_SESSION["csrf_token"] : " null "; ?>
            <input type="hidden" name="csrf_token" value="<?php echo $csrf; ?>">
            <input type="hidden" name="update" id="updateID" value="Nani">
            <div class="rowProfile">
                <div class="columnProfile">
                
                    <div class="userProfileInfo">
                        <?php echo isset($profile["user_profile"]) && $profile["user_profile"] !== "" ? ' <label for="Naniiiii"><img src="../../assets/image/upload/' . $profile["user_profile"] . ' " alt="profile picture" class="previewsss">
                        </label> <input type="file" name="user_profile" id="Naniiiii" onchange="previewImage(event)">'
                        : '<img src="../../assets/image/users.png" alt="profile picture" class="imagePFP" > <input type="file" name="user_profile" id="imageProfile">';
                        
                        if($profile["suffix"] !== null && $profile["suffix"] !== "N/A" && $profile["suffix"] !== "NONE") {
                            echo '<h4>' . $profile["Lname"] . " " . $profile["suffix"] . ", " . $profile["Fname"] . " " . $profile["Mname"] .' </h4>';
                        }else{
                            echo '<h4>' . $profile["Lname"] . ", " . $profile["Fname"] . " " . $profile["Mname"] .' </h4>';
                        }
                        ?>
                       
                        <p><?php echo $profile["employeeID"];?></p>
                        <p><?php echo $profile["job_Title"];?></p>
                        <p><?php echo $profile["department"] . " DEPARTMENT";?></p>
                    </div>
                    <ul class="ulClass">
                        <button type="button" id="pi" onclick="pibutton()">PERSONAL INFORMATION</button>
                        <button type="button" id="eb" onclick="edbutton()">EDUCATIONAL BACKGROUND</button>
                        <button type="button" id="fb" onclick="febutton()">FAMILY BACKGROUND</button>
                    </ul>
                </div>
                <div class="employeeInformation">
                    <h2>EMPLOYEE INFOTMATION</h2>
                    <div class="employe-informations" id="ei">
                        <li>
                            <label for="Lname">Last Name</label>
                            <input type="text" name="Lname" id="Lname" value="<?php echo $profile["Lname"];?>">
                        </li>
                        <li>
                            <label for="Fname">First Name</label>
                            <input type="text" name="Fname" id="Fname" value="<?php echo $profile["Fname"];?>">
                        </li>
                        <li>
                            <label for="Mname">Middle Name</label>
                            <input type="text" name="Mname" id="Mname" value="<?php echo $profile["Mname"];?>">
                        </li>
                        <li>
                            <label for="suffix">Name Ext.</label>
                            <select name="suffix" id="suffix">
                                <option value="NONE" <?php echo (isset($profile["suffix"]) && $profile["suffix"] == "NONE") ? 'selected' : ''; ?>>Name Extension</option>
                                <option value="N/A" <?php echo (isset($profile["suffix"]) && $profile["suffix"] == "N/A") ? 'selected' : ''; ?>>N/A</option>
                                <option value="Jr." <?php echo (isset($profile["suffix"]) && $profile["suffix"] == "Jr.") ? 'selected' : ''; ?>>Jr.</option>
                                <option value="Sr." <?php echo (isset($profile["suffix"]) && $profile["suffix"] == "Sr.") ? 'selected' : ''; ?>>Sr.</option>
                                <option value="II" <?php echo (isset($profile["suffix"]) && $profile["suffix"] == "II") ? 'selected' : ''; ?>>II</option>
                                <option value="III" <?php echo (isset($profile["suffix"]) && $profile["suffix"] == "III") ? 'selected' : ''; ?>>III</option>
                                <option value="IV" <?php echo (isset($profile["suffix"]) && $profile["suffix"] == "IV") ? 'selected' : ''; ?>>IV</option>
                                <option value="V" <?php echo (isset($profile["suffix"]) && $profile["suffix"] == "V") ? 'selected' : ''; ?>>V</option>
                            </select>
                        </li>

                        <li>
                            <label for="employeeID">Employee ID</label>
                            <input type="text" name="employeeID" id="employeeID" value="<?php echo isset($profile["employeeID"]) ? $profile["employeeID"] : ''; ?>">
                        </li>
                        <li>
                            <label for="rateType">Rate Type</label>
                            <select name="rateType" id="rateType">
                                <option value="NONE" <?php echo (isset($profile["rateType"]) && $profile["rateType"] == "NONE") ? 'selected' : ''; ?>>Select Rate Type</option>
                                <option value="MONTHLY" <?php echo (isset($profile["rateType"]) && $profile["rateType"] == "MONTHLY") ? 'selected' : ''; ?>>MONTHLY</option>
                                <option value="DAILY" <?php echo (isset($profile["rateType"]) && $profile["rateType"] == "DAILY") ? 'selected' : ''; ?>>DAILY</option>
                                <option value="HOURLY" <?php echo (isset($profile["rateType"]) && $profile["rateType"] == "HOURLY") ? 'selected' : ''; ?>>HOURLY</option>
                            </select>
                        </li>
                        <li>
                            <label for="salary_Range_From">Salary Range From</label>
                            <input type="text" name="salary_Range_From" id="salary_Range_From" value="<?php echo isset($profile["salary_Range_From"]) ? $profile["salary_Range_From"] : ''; ?>">
                        </li>
                        <li>
                            <label for="salary_Range_To">Salary Range To</label>
                            <input type="text" name="salary_Range_To" id="salary_Range_To" value="<?php echo isset($profile["salary_Range_To"]) ? $profile["salary_Range_To"] : ''; ?>">
                        </li>
                        <li>
                            <label for="department">Department</label>
                            <select name="department" id="departmentss">
                                <option value="NONE" <?php echo (isset($profile["department"]) && $profile["department"] == "NONE") ? 'selected' : ''; ?>>Select Department</option>
                                <option value="HOSPITAL" <?php echo (isset($profile["department"]) && $profile["department"] == "HOSPITAL") ? 'selected' : ''; ?>>HOSPITAL</option>
                                <option value="SCHOOL" <?php echo (isset($profile["department"]) && $profile["department"] == "SCHOOL") ? 'selected' : ''; ?>>SCHOOL</option>
                            </select>
                        </li>
                        <li>
                            <label for="job_Title">Job Title</label>
                            <select name="job_Title" id="UpdateJobTitle">
                                <?php
                                if (!empty($profile["job_Title"])) {
                                    echo '<option value="' . htmlspecialchars($profile["job_Title"]) . '" selected>' . htmlspecialchars($profile["job_Title"]) . '</option>';
                                } else {
                                    echo '<option value="" disabled selected>Loading job titles...</option>';
                                }
                                ?>
                            </select>
                        </li>
                        <li>
                            <label for="schedule_from">Time Schedule From</label>
                            <select name="schedule_from" id="UpdateJobTitle">
                                <?php
                               if($profile["department"] == "HOSPITAL"){
                                if (!empty($profile["schedule_to"])) {
                                    echo '<option value="' . htmlspecialchars($profile["schedule_from"]) . '" selected>' . htmlspecialchars($profile["schedule_from"]) . '</option>';
                                    echo '<option value="07:00:00" ' . ($schedule_to_value === "07:00:00" ? 'selected' : '') . '>07:00:00</option>';
                                    echo '<option value="03:00:00" ' . ($schedule_to_value === "03:00:00" ? 'selected' : '') . '>03:00:00</option>';
                                    echo '<option value="11:00:00" ' . ($schedule_to_value === "11:00:00" ? 'selected' : '') . '>11:00:00</option>';

                                }
                            }else if ($profile["department"] == "SCHOOL") {
                                echo '<option value="' . htmlspecialchars($profile["schedule_from"]) . '" selected>' . htmlspecialchars($profile["schedule_from"]) . '</option>';
                                echo '<option value="08:00:00" ' . ($schedule_to_value === "08:00:00" ? 'selected' : '') . '>08:00:00</option>';
                            }
                                ?>
                            </select>
                        </li>
                        <li>
                            <label for="schedule_to">Time Schedule To</label>
                            <select name="schedule_to" id="UpdateJobTitle">
                                <?php
                                if($profile["department"] == "HOSPITAL"){
                                    if (!empty($profile["schedule_to"])) {
                                        echo '<option value="' . htmlspecialchars($profile["schedule_to"]) . '" selected>' . htmlspecialchars($profile["schedule_to"]) . '</option>';
                                        echo '<option value="03:00:00" ' . ($schedule_to_value === "03:00:00" ? 'selected' : '') . '>03:00:00</option>';
                                        echo '<option value="11:00:00" ' . ($schedule_to_value === "11:00:00" ? 'selected' : '') . '>11:00:00</option>';
                                        echo '<option value="07:00:00" ' . ($schedule_to_value === "07:00:00" ? 'selected' : '') . '>07:00:00</option>';

                                    }
                                }else if ($profile["department"] == "SCHOOL") {
                                    echo '<option value="' . htmlspecialchars($profile["schedule_to"]) . '" selected>' . htmlspecialchars($profile["schedule_to"]) . '</option>';
                                    echo '<option value="04:30:00" ' . ($schedule_to_value === "04:30:00" ? 'selected' : '') . '>04:30:00</option>';
                                }
                                
                                ?>
                            </select>
                        </li>
                        <li>
                            <label for="gender">Gender</label>
                            <select name="gender" id="gender">
                                <option value="NONE" <?php echo (isset($profile["gender"]) && $profile["gender"] == "NONE") ? 'selected' : ''; ?>>Select Gender</option>
                                <option value="MALE" <?php echo (isset($profile["gender"]) && $profile["gender"] == "MALE") ? 'selected' : ''; ?>>MALE</option>
                                <option value="FEMALE" <?php echo (isset($profile["gender"]) && $profile["gender"] == "FEMALE") ? 'selected' : ''; ?>>FEMALE</option>
                            </select>
                        </li>
                        <li>
                            <label for="birthday">Date of Birth</label>
                            <input type="text" name="birthday" id="birthday" value="<?php echo isset($profile["birthday"]) && $profile["birthday"] !== "" ? $profile["birthday"] : "N/A";?>">
                        </li>
                        <li>
                            <label for="birth_Place">Birth Place</label>
                            <input type="text" name="birth_Place" id="birth_Place" value="<?php echo isset($profile["birth_Place"]) && $profile["birth_Place"] !== "" ? $profile["birth_Place"] : "N/A";?>">
                        </li>
                        <li>
                            <label for="civil_Status">Civil Status</label>
                            <select name="civil_Status" id="civil_Status">
                                <option value="NONE" <?php echo (isset($profile["civil_Status"]) && $profile["civil_Status"] == "NONE") ? 'selected' : ''; ?>>Select Civil Status</option>
                                <option value="SINGLE" <?php echo (isset($profile["civil_Status"]) && $profile["civil_Status"] == "SINGLE") ? 'selected' : ''; ?>>SINGLE</option>
                                <option value="MARRIED" <?php echo (isset($profile["civil_Status"]) && $profile["civil_Status"] == "MARRIED") ? 'selected' : ''; ?>>MARRIED</option>
                                <option value="WIDOWED" <?php echo (isset($profile["civil_Status"]) && $profile["civil_Status"] == "WIDOWED") ? 'selected' : ''; ?>>WIDOWED</option>
                                <option value="DIVORCED" <?php echo (isset($profile["civil_Status"]) && $profile["civil_Status"] == "DIVORCED") ? 'selected' : ''; ?>>DIVORCED</option>
                                <option value="SEPARATED" <?php echo (isset($profile["civil_Status"]) && $profile["civil_Status"] == "SEPARATED") ? 'selected' : ''; ?>>SEPARATED</option>
                                <option value="ANNULLED" <?php echo (isset($profile["civil_Status"]) && $profile["civil_Status"] == "ANNULLED") ? 'selected' : ''; ?>>ANNULLED</option>
                            </select>
                        </li>

                        <li>
                            <label for="religion">Religion</label>
                            <select name="Religion" id="religion">
                                <option value="NONE" <?php echo (isset($profile["Religion"]) && $profile["Religion"] == "NONE") ? 'selected' : ''; ?>>Select Religion</option>
                                <option value="Roman Catholic" <?php echo (isset($profile["Religion"]) && $profile["Religion"] == "Roman Catholic") ? 'selected' : ''; ?>>Roman Catholic</option>
                                <option value="Iglesia ni Cristo" <?php echo (isset($profile["Religion"]) && $profile["Religion"] == "Iglesia ni Cristo") ? 'selected' : ''; ?>>Iglesia ni Cristo</option>
                                <option value="Islam" <?php echo (isset($profile["Religion"]) && $profile["Religion"] == "Islam") ? 'selected' : ''; ?>>Islam</option>
                                <option value="Protestant" <?php echo (isset($profile["Religion"]) && $profile["Religion"] == "Protestant") ? 'selected' : ''; ?>>Protestant</option>
                                <option value="Buddhism" <?php echo (isset($profile["Religion"]) && $profile["Religion"] == "Buddhism") ? 'selected' : ''; ?>>Buddhism</option>
                                <option value="Others" <?php echo (isset($profile["Religion"]) && $profile["Religion"] == "Others") ? 'selected' : ''; ?>>Others</option>
                            </select>
                        </li>
                        <li>
                            <label for="citizenship">Citizenship</label>
                            <select name="Citizenship" id="citizenship">
                                <option value="NONE" <?php echo (isset($profile["Citizenship"]) && $profile["Citizenship"] == "NONE") ? 'selected' : ''; ?>>Select Citizenship</option>
                                <option value="Natural-born" <?php echo (isset($profile["Citizenship"]) && $profile["Citizenship"] == "Natural-born") ? 'selected' : ''; ?>>Natural-born</option>
                                <option value="Naturalized" <?php echo (isset($profile["Citizenship"]) && $profile["Citizenship"] == "Naturalized") ? 'selected' : ''; ?>>Naturalized</option>
                                <option value="Dual" <?php echo (isset($profile["Citizenship"]) && $profile["Citizenship"] == "Dual") ? 'selected' : ''; ?>>Dual</option>
                                <option value="By election" <?php echo (isset($profile["Citizenship"]) && $profile["Citizenship"] == "By election") ? 'selected' : ''; ?>>By election</option>
                                <option value="Others" <?php echo (isset($profile["Citizenship"]) && $profile["Citizenship"] == "Others") ? 'selected' : ''; ?>>Others</option>
                            </select>
                        </li>
                        <li>
                            <label for="email">Email</label>
                            <input type="text" name="email" id="email" value="<?php echo isset($profile["email"]) && $profile["email"] !== "" ? $profile["email"] : "N/A";?>">
                        <li>
                            <label for="Contact_No">Contact Number</label>
                            <input type="text" name="Contact_No" id="Contact_No" value="<?php echo isset($profile["Contact_No"]) && $profile["Contact_No"] !== "" ? $profile["Contact_No"] : "N/A";?>">
                        </li>
                        <li>
                            <label for="age">Age</label>
                            <input type="text" name="age" id="age" value="<?php echo isset($profile["age"]) && $profile["age"] !== "" ? $profile["age"] : "N/A";?>">
                        </li>

                        <h3>ADDRESS</h3>

                        <li>
                            <label for="house_block">House Block</label>
                            <input type="text" name="house_block" id="house_block" value="<?php echo isset($profile["house_block"]) && $profile["house_block"] !== "" ? $profile["house_block"] : "N/A"; ?>">
                        </li>
                        <li>
                            <label for="street">Street</label>
                            <input type="text" name="street" id="street" value="<?php echo isset($profile["street"]) && $profile["street"] !== "" ? $profile["street"] : "N/A";?>">
                        </li>
                        <li>
                            <label for="subdivision">Subdivision</label>
                            <input type="text" name="subdivision" id="subdivision" value="<?php echo isset($profile["subdivision"]) && $profile["subdivision"] !== "" ? $profile["subdivision"] : "N/A";?>">
                        </li>
                        <li>
                            <label for="barangay">Barangay</label>
                            <input type="text" name="barangay" id="barangay" value="<?php echo isset($profile["barangay"]) && $profile["barangay"] !== "" ? $profile["barangay"] : "N/A";?>">
                        </li>

                        <li>
                            <label for="city_muntinlupa">City Muntinlupa</label>
                            <input type="text" name="city_muntinlupa" id="city_muntinlupa" value="<?php echo isset($profile["city_muntinlupa"]) && $profile["city_muntinlupa"] !== "" ? $profile["city_muntinlupa"] : "N/A";?>">
                        </li>
                        <li>
                            <label for="province">Province</label>
                            <input type="text" name="province" id="province" value="<?php echo isset($profile["province"]) && $profile["province"] !== "" ? $profile["province"] : "N/A";?>">
                        </li>
                        <li>
                            <label for="zip_code">Zip Code</label>
                            <input type="text" name="zip_code" id="zip_code" value="<?php echo isset($profile["zip_code"]) && $profile["zip_code"] !== "" ? $profile["zip_code"] : "N/A";?>">
                        </li>
                        <div class="buttonConfirmation" id="buttonConfirmation" style="display: none;">
                            <h5 id="upadteP">Are You sure you want to update this profile?</h5>
                            <div class="nanii">
                                <button id="edit">Yes</button>
                                </form>
                                <button type="button" id="view" onclick="CancelUPdate()">No</button>
                            </div>
                        </div>
                        <div class="editButton">
                            <button type="button" onclick="updateButton()">Update</button>
                        </div>
                    </div>
                    <div class="educationalBG" id="ebg" style="display: none">
                        <h1>EDUCATION</h1>
                    </div>
                    <div class="familyBG" id="fbg" style="display: none">
                    <h1>FAMILY</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
        approvedSuccess();
    ?>
    
    <script src="../../assets/js/hr/hr.js"></script>
    <script src="../../assets/js/hr/hrP.js"></script>
    <script>
function previewImage(event) {
    const file = event.target.files[0];
    console.log("✅ hr.js loaasdasdasdded");
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            console.log("Image Loaded: ", e.target.result);
            document.getElementById("previewsss").src = e.target.result;
        };
        reader.readAsDataURL(file);
    } else {
        console.log("No file selected");
    }
}
    </script>
</body>
</html>