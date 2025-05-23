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
    $profileE = $info['profileE'];
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
        <form action="../../auth/authentications.php?id=<?php echo $profileE["id"]; ?>" id="UpdateForm" method="post" enctype="multipart/form-data">
            <?php isset($_SESSION["csrf_token"]) && $_SESSION["csrf_token"] !== "" ? $csrf = $_SESSION["csrf_token"] : " null "; ?>
            <input type="hidden" name="csrf_token" value="<?php echo $csrf; ?>">
            <input type="hidden" name="update" id="updateID" value="Employee">
            <div class="rowProfile">
                <div class="columnProfile">
                
                    <div class="userProfileInfo">
                        <?php echo isset($profileE["user_profile"]) && $profileE["user_profile"] !== "" ? ' <label for="Naniiiii"><img src="../../assets/image/upload/' . $profileE["user_profile"] . ' " alt="profile picture" id="previewsss">
                        </label> <input type="file" name="user_profile" id="Naniiiii" onchange="previewImage(event)">'
                        : '<img src="../../assets/image/users.png" alt="profile picture" class="imagePFP" > <input type="file" name="user_profile" id="imageProfile">';
                        
                        if($profileE["suffix"] !== null && $profileE["suffix"] !== "N/A" && $profileE["suffix"] !== "NONE") {
                            echo '<h4>' . $profileE["Lname"] . " " . $profileE["suffix"] . ", " . $profileE["Fname"] . " " . $profileE["Mname"] .' </h4>';
                        }else{
                            echo '<h4>' . $profileE["Lname"] . ", " . $profileE["Fname"] . " " . $profileE["Mname"] .' </h4>';
                        }
                        ?>
                       
                        <p><?php echo $profileE["employeeID"];?></p>
                        <p><?php echo $profileE["job_Title"];?></p>
                        <p><?php echo $profileE["department"] . " DEPARTMENT";?></p>
                    </div>
                    <ul class="ulClass">
                        <button type="button" id="pi" onclick="pibutton()">PERSONAL INFORMATION</button>
                        <button type="button" id="eb" onclick="edbutton()">EDUCATIONAL BACKGROUND</button>
                        <button type="button" id="fb" onclick="febutton()">PERSONAL DATA SHEET</button>
                    </ul>
                </div>
                <div class="employeeInformation">
                    <h2>EMPLOYEE INFOTMATION</h2>
                    <div class="employe-informations" id="ei">
                        <li>
                            <label for="Lname">Last Name</label>
                            <input type="text" name="Lname" id="Lname" value="<?php echo $profileE["Lname"];?>">
                        </li>
                        <li>
                            <label for="Fname">First Name</label>
                            <input type="text" name="Fname" id="Fname" value="<?php echo $profileE["Fname"];?>">
                        </li>
                        <li>
                            <label for="Mname">Middle Name</label>
                            <input type="text" name="Mname" id="Mname" value="<?php echo $profileE["Mname"];?>">
                        </li>
                        <li>
                            <label for="suffix">Name Ext.</label>
                            <select name="suffix" id="suffix">
                                <option value="NONE" <?php echo (isset($profileE["suffix"]) && $profileE["suffix"] == "NONE") ? 'selected' : ''; ?>>Name Extension</option>
                                <option value="N/A" <?php echo (isset($profileE["suffix"]) && $profileE["suffix"] == "N/A") ? 'selected' : ''; ?>>N/A</option>
                                <option value="Jr." <?php echo (isset($profileE["suffix"]) && $profileE["suffix"] == "Jr.") ? 'selected' : ''; ?>>Jr.</option>
                                <option value="Sr." <?php echo (isset($profileE["suffix"]) && $profileE["suffix"] == "Sr.") ? 'selected' : ''; ?>>Sr.</option>
                                <option value="II" <?php echo (isset($profileE["suffix"]) && $profileE["suffix"] == "II") ? 'selected' : ''; ?>>II</option>
                                <option value="III" <?php echo (isset($profileE["suffix"]) && $profileE["suffix"] == "III") ? 'selected' : ''; ?>>III</option>
                                <option value="IV" <?php echo (isset($profileE["suffix"]) && $profileE["suffix"] == "IV") ? 'selected' : ''; ?>>IV</option>
                                <option value="V" <?php echo (isset($profileE["suffix"]) && $profileE["suffix"] == "V") ? 'selected' : ''; ?>>V</option>
                            </select>
                        </li>

                        <li>
                            <label for="employeeID">Employee ID</label>
                            <input type="text" name="employeeID" id="employeeID" value="<?php echo isset($profileE["employeeID"]) ? $profileE["employeeID"] : ''; ?>">
                        </li>
                        <li>
                            <label for="rateType">Rate Type</label>
                            <select name="rateType" id="rateType">
                                <option value="NONE" <?php echo (isset($profileE["rateType"]) && $profileE["rateType"] == "NONE") ? 'selected' : ''; ?>>Select Rate Type</option>
                                <option value="MONTHLY" <?php echo (isset($profileE["rateType"]) && $profileE["rateType"] == "MONTHLY") ? 'selected' : ''; ?>>MONTHLY</option>
                                <option value="DAILY" <?php echo (isset($profileE["rateType"]) && $profileE["rateType"] == "DAILY") ? 'selected' : ''; ?>>DAILY</option>
                                <option value="HOURLY" <?php echo (isset($profileE["rateType"]) && $profileE["rateType"] == "HOURLY") ? 'selected' : ''; ?>>HOURLY</option>
                            </select>
                        </li>
                        <li>
                            <label for="salary_Range_From">Salary Range From</label>
                            <input type="text" name="salary_Range_From" id="salary_Range_From" value="<?php echo isset($profileE["salary_Range_From"]) ? $profileE["salary_Range_From"] : ''; ?>">
                        </li>
                        <li>
                            <label for="salary_Range_To">Salary Range To</label>
                            <input type="text" name="salary_Range_To" id="salary_Range_To" value="<?php echo isset($profileE["salary_Range_To"]) ? $profileE["salary_Range_To"] : ''; ?>">
                        </li>
                        <li>
                            <label for="department">Department</label>
                            <select name="department" id="departmentss">
                                <option value="NONE" <?php echo (isset($profileE["department"]) && $profileE["department"] == "NONE") ? 'selected' : ''; ?>>Select Department</option>
                                <option value="HOSPITAL" <?php echo (isset($profileE["department"]) && $profileE["department"] == "HOSPITAL") ? 'selected' : ''; ?>>HOSPITAL</option>
                                <option value="SCHOOL" <?php echo (isset($profileE["department"]) && $profileE["department"] == "SCHOOL") ? 'selected' : ''; ?>>SCHOOL</option>
                            </select>
                        </li>
                        <li>
                            <label for="job_Title">Job Title</label>
                            <select name="job_Title" id="UpdateJobTitle">
                                <?php
                                if (!empty($profileE["job_Title"])) {
                                    echo '<option value="' . htmlspecialchars($profileE["job_Title"]) . '" selected>' . htmlspecialchars($profileE["job_Title"]) . '</option>';
                                } else {
                                    echo '<option value="" disabled selected>Loading job titles...</option>';
                                }
                                ?>
                            </select>
                        </li>



                        <li>
                            <label for="gender">Gender</label>
                            <select name="gender" id="gender">
                                <option value="NONE" <?php echo (isset($profileE["gender"]) && $profileE["gender"] == "NONE") ? 'selected' : ''; ?>>Select Gender</option>
                                <option value="MALE" <?php echo (isset($profileE["gender"]) && $profileE["gender"] == "MALE") ? 'selected' : ''; ?>>MALE</option>
                                <option value="FEMALE" <?php echo (isset($profileE["gender"]) && $profileE["gender"] == "FEMALE") ? 'selected' : ''; ?>>FEMALE</option>
                            </select>
                        </li>
                        <li>
                            <label for="birthday">Date of Birth</label>
                            <input type="text" name="birthday" id="birthday" value="<?php echo isset($profileE["birthday"]) && $profileE["birthday"] !== "" ? $profileE["birthday"] : "N/A";?>">
                        </li>
                        <li>
                            <label for="birth_Place">Birth Place</label>
                            <input type="text" name="birth_Place" id="birth_Place" value="<?php echo isset($profileE["birth_Place"]) && $profileE["birth_Place"] !== "" ? $profileE["birth_Place"] : "N/A";?>">
                        </li>
                        <li>
                            <label for="civil_Status">Civil Status</label>
                            <select name="civil_Status" id="civil_Status">
                                <option value="NONE" <?php echo (isset($profileE["civil_Status"]) && $profileE["civil_Status"] == "NONE") ? 'selected' : ''; ?>>Select Civil Status</option>
                                <option value="SINGLE" <?php echo (isset($profileE["civil_Status"]) && $profileE["civil_Status"] == "SINGLE") ? 'selected' : ''; ?>>SINGLE</option>
                                <option value="MARRIED" <?php echo (isset($profileE["civil_Status"]) && $profileE["civil_Status"] == "MARRIED") ? 'selected' : ''; ?>>MARRIED</option>
                                <option value="WIDOWED" <?php echo (isset($profileE["civil_Status"]) && $profileE["civil_Status"] == "WIDOWED") ? 'selected' : ''; ?>>WIDOWED</option>
                                <option value="DIVORCED" <?php echo (isset($profileE["civil_Status"]) && $profileE["civil_Status"] == "DIVORCED") ? 'selected' : ''; ?>>DIVORCED</option>
                                <option value="SEPARATED" <?php echo (isset($profileE["civil_Status"]) && $profileE["civil_Status"] == "SEPARATED") ? 'selected' : ''; ?>>SEPARATED</option>
                                <option value="ANNULLED" <?php echo (isset($profileE["civil_Status"]) && $profileE["civil_Status"] == "ANNULLED") ? 'selected' : ''; ?>>ANNULLED</option>
                            </select>
                        </li>

                        <li>
                            <label for="religion">Religion</label>
                            <select name="Religion" id="religion">
                                <option value="NONE" <?php echo (isset($profileE["Religion"]) && $profileE["Religion"] == "NONE") ? 'selected' : ''; ?>>Select Religion</option>
                                <option value="Roman Catholic" <?php echo (isset($profileE["Religion"]) && $profileE["Religion"] == "Roman Catholic") ? 'selected' : ''; ?>>Roman Catholic</option>
                                <option value="Iglesia ni Cristo" <?php echo (isset($profileE["Religion"]) && $profileE["Religion"] == "Iglesia ni Cristo") ? 'selected' : ''; ?>>Iglesia ni Cristo</option>
                                <option value="Islam" <?php echo (isset($profileE["Religion"]) && $profileE["Religion"] == "Islam") ? 'selected' : ''; ?>>Islam</option>
                                <option value="Protestant" <?php echo (isset($profileE["Religion"]) && $profileE["Religion"] == "Protestant") ? 'selected' : ''; ?>>Protestant</option>
                                <option value="Buddhism" <?php echo (isset($profileE["Religion"]) && $profileE["Religion"] == "Buddhism") ? 'selected' : ''; ?>>Buddhism</option>
                                <option value="Others" <?php echo (isset($profileE["Religion"]) && $profileE["Religion"] == "Others") ? 'selected' : ''; ?>>Others</option>
                            </select>
                        </li>
                        <li>
                            <label for="citizenship">Citizenship</label>
                            <select name="Citizenship" id="citizenship">
                                <option value="NONE" <?php echo (isset($profileE["Citizenship"]) && $profileE["Citizenship"] == "NONE") ? 'selected' : ''; ?>>Select Citizenship</option>
                                <option value="Natural-born" <?php echo (isset($profileE["Citizenship"]) && $profileE["Citizenship"] == "Natural-born") ? 'selected' : ''; ?>>Natural-born</option>
                                <option value="Naturalized" <?php echo (isset($profileE["Citizenship"]) && $profileE["Citizenship"] == "Naturalized") ? 'selected' : ''; ?>>Naturalized</option>
                                <option value="Dual" <?php echo (isset($profileE["Citizenship"]) && $profileE["Citizenship"] == "Dual") ? 'selected' : ''; ?>>Dual</option>
                                <option value="By election" <?php echo (isset($profileE["Citizenship"]) && $profileE["Citizenship"] == "By election") ? 'selected' : ''; ?>>By election</option>
                                <option value="Others" <?php echo (isset($profileE["Citizenship"]) && $profileE["Citizenship"] == "Others") ? 'selected' : ''; ?>>Others</option>
                            </select>
                        </li>
                        <li>
                            <label for="email">Email</label>
                            <input type="text" name="email" id="email" value="<?php echo isset($profileE["email"]) && $profileE["email"] !== "" ? $profileE["email"] : "N/A";?>">
                        <li>
                            <label for="Contact_No">Contact Number</label>
                            <input type="text" name="Contact_No" id="Contact_No" value="<?php echo isset($profileE["Contact_No"]) && $profileE["Contact_No"] !== "" ? $profileE["Contact_No"] : "N/A";?>">
                        </li>
                        <li>
                            <label for="age">Age</label>
                            <input type="text" name="age" id="age" value="<?php echo isset($profileE["age"]) && $profileE["age"] !== "" ? $profileE["age"] : "N/A";?>">
                        </li>

                        <h3>ADDRESS</h3>

                        <li>
                            <label for="house_block">House Block</label>
                            <input type="text" name="house_block" id="house_block" value="<?php echo isset($profileE["house_block"]) && $profileE["house_block"] !== "" ? $profileE["house_block"] : "N/A"; ?>">
                        </li>
                        <li>
                            <label for="street">Street</label>
                            <input type="text" name="street" id="street" value="<?php echo isset($profileE["street"]) && $profileE["street"] !== "" ? $profileE["street"] : "N/A";?>">
                        </li>
                        <li>
                            <label for="subdivision">Subdivision</label>
                            <input type="text" name="subdivision" id="subdivision" value="<?php echo isset($profileE["subdivision"]) && $profileE["subdivision"] !== "" ? $profileE["subdivision"] : "N/A";?>">
                        </li>
                        <li>
                            <label for="barangay">Barangay</label>
                            <input type="text" name="barangay" id="barangay" value="<?php echo isset($profileE["barangay"]) && $profileE["barangay"] !== "" ? $profileE["barangay"] : "N/A";?>">
                        </li>

                        <li>
                            <label for="city_muntinlupa">City Muntinlupa</label>
                            <input type="text" name="city_muntinlupa" id="city_muntinlupa" value="<?php echo isset($profileE["city_muntinlupa"]) && $profileE["city_muntinlupa"] !== "" ? $profileE["city_muntinlupa"] : "N/A";?>">
                        </li>
                        <li>
                            <label for="province">Province</label>
                            <input type="text" name="province" id="province" value="<?php echo isset($profileE["province"]) && $profileE["province"] !== "" ? $profileE["province"] : "N/A";?>">
                        </li>
                        <li>
                            <label for="zip_code">Zip Code</label>
                            <input type="text" name="zip_code" id="zip_code" value="<?php echo isset($profileE["zip_code"]) && $profileE["zip_code"] !== "" ? $profileE["zip_code"] : "N/A";?>">
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
                    <h2 id="h2Hehe">Family Background</h2>
                    <form action="submit_education.php" method="post">
                            <table class="education-table">
                                <thead>
                                    <tr>
                                        <th>Level</th>
                                        <th>School Name</th>
                                        <th>Address</th>
                                        <th>Course / Strand</th>
                                        <th>Year Started</th>
                                        <th>Year Graduated</th>
                                        <th>Status</th>
                                        <th>Honors</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Elementary -->
                                    <tr>
                                        <td data-label="Level">Elementary</td>
                                        <td data-label="School Name"><input type="text" name="elementary[school]" required></td>
                                        <td data-label="Address"><input type="text" name="elementary[address]"></td>
                                        <td data-label="Course / Strand"><input type="text" name="elementary[course]" placeholder="N/A"></td>
                                        <td data-label="Year Started"><input type="number" name="elementary[start]" min="1900" max="2099" required></td>
                                        <td data-label="Year Graduated"><input type="number" name="elementary[end]" min="1900" max="2099"></td>
                                        <td data-label="Status">
                                            <select name="elementary[status]">
                                                <option value="Graduated">Graduated</option>
                                                <option value="Undergraduate">Undergraduate</option>
                                            </select>
                                        </td>
                                        <td data-label="Honors"><input type="text" name="elementary[honors]"></td>
                                    </tr>

                                    <!-- Junior High School -->
                                    <tr>
                                        <td data-label="Level">Junior High School</td>
                                        <td><input type="text" name="junior[school]"></td>
                                        <td><input type="text" name="junior[address]"></td>
                                        <td><input type="text" name="junior[course]"></td>
                                        <td><input type="number" name="junior[start]" min="1900" max="2099"></td>
                                        <td><input type="number" name="junior[end]" min="1900" max="2099"></td>
                                        <td>
                                            <select name="junior[status]">
                                                <option value="Graduated">Graduated</option>
                                                <option value="Undergraduate">Undergraduate</option>
                                                <option value="Currently Enrolled">Currently Enrolled</option>
                                            </select>
                                        </td>
                                        <td><input type="text" name="junior[honors]"></td>
                                    </tr>

                                    <!-- Senior High School -->
                                    <tr>
                                        <td data-label="Level">Senior High School</td>
                                        <td><input type="text" name="senior[school]"></td>
                                        <td><input type="text" name="senior[address]"></td>
                                        <td><input type="text" name="senior[course]"></td>
                                        <td><input type="number" name="senior[start]" min="1900" max="2099"></td>
                                        <td><input type="number" name="senior[end]" min="1900" max="2099"></td>
                                        <td>
                                            <select name="senior[status]">
                                                <option value="Graduated">Graduated</option>
                                                <option value="Undergraduate">Undergraduate</option>
                                                <option value="Currently Enrolled">Currently Enrolled</option>
                                            </select>
                                        </td>
                                        <td><input type="text" name="senior[honors]"></td>
                                    </tr>

                                    <!-- College -->
                                    <tr>
                                        <td data-label="Level">College</td>
                                        <td><input type="text" name="college[school]"></td>
                                        <td><input type="text" name="college[address]"></td>
                                        <td><input type="text" name="college[course]"></td>
                                        <td><input type="number" name="college[start]" min="1900" max="2099"></td>
                                        <td><input type="number" name="college[end]" min="1900" max="2099"></td>
                                        <td>
                                            <select name="college[status]">
                                                <option value="Graduated">Graduated</option>
                                                <option value="Undergraduate">Undergraduate</option>
                                                <option value="Currently Enrolled">Currently Enrolled</option>
                                                <option value="Dropped Out">Dropped Out</option>
                                            </select>
                                        </td>
                                        <td><input type="text" name="college[honors]"></td>
                                    </tr>
                                </tbody>
                            </table>

                            <div class="submit-btn">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>

                        <!-- =================== family BG ========================= -->

                        <form action="submit_family_background.php" method="post">
                            <h2 id="h2Hehe">Family Background</h2>
                            <table class="family-BG">
                                <tr>
                                    <td>
                                        <label for="spouseName">Spouse's Full Name</label>
                                        <input type="text" name="spouseName" id="spouseName">
                                    </td>
                                    <td>
                                        <label for="spouseOccupation">Spouse's Occupation</label>
                                        <input type="text" name="spouseOccupation" id="spouseOccupation">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="fatherName">Father's Full Name</label>
                                        <input type="text" name="fatherName" id="fatherName">
                                    </td>
                                    <td>
                                        <label for="fatherOccupation">Father's Occupation</label>
                                        <input type="text" name="fatherOccupation" id="fatherOccupation">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="motherName">Mother's Full Maiden Name</label>
                                        <input type="text" name="motherName" id="motherName">
                                    </td>
                                    <td>
                                        <label for="motherOccupation">Mother's Occupation</label>
                                        <input type="text" name="motherOccupation" id="motherOccupation">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label for="numChildren">Number of Children</label>
                                        <input type="number" name="numChildren" id="numChildren" min="0">
                                    </td>
                                    <td>
                                        <label for="childrenNames">Names of Children (optional)</label>
                                        <input type="text" name="childrenNames" id="childrenNames" placeholder="Separate names with commas">
                                    </td>
                                </tr>
                            </table>

                            <div class="submit-btn">
                                <button type="submit">update</button>
                            </div>
                        </form>

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
</body>
</html>