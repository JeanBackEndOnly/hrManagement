<?php

declare(strict_types=1);


function signup_inputs(){  
    $pdo = db_connect();
   
echo '<div class="AddEmployee" id="AddEmployees">';
            $csrf_token = $_SESSION['csrf_token'] ?? '';
            echo '<form action = "../auth/authentications.php" id="registerForm" method="post" enctype="multipart/form-data">';
            getErrors_signups(); 
            echo '<div class="back">';
            echo '<button type="button" id="bb"><a href="index.php"><i class="fa-solid fa-arrow-left" style="font-size: 20px;"></i></a></button>';
            echo '<h3 id="h3WithBack">PERSONAL INFORMATION</h3>';
echo '</div>';
                echo '<input type="hidden" name="addeemployee" value="admin">';
                echo '<input type="hidden" name="csrf_token" value="' . $csrf_token . '">';

echo '<div class="CenterInfo">';
echo '<div class="rowAddEmployee">';

echo '<div class="four-div" id="inputDivFour">';
                echo '<li>';
                echo '<label for="Lname" id="required">required*</label>';
                if (isset($_SESSION["admin_signup"]["Lname"]) && !isset($_SESSION["signup_errors"])) {
                    echo '<input type="text" id="Lname" name="Lname" placeholder="Surname:" value = "' . $_SESSION["admin_signup"]["Lname"] . '" >';
                } else {
                    echo '<input type="text" id="Lname" name="Lname" placeholder="Surname:" >';
                }
                echo '</li>';

                echo '<li>';
                echo '<label for="Fname" id="required">required*</label>';
                if (isset($_SESSION["admin_signup"]["Fname"]) && !isset($_SESSION["signup_errors"])) {
                    echo '<input type="text" id="Fname" name="Fname" placeholder="First Name:" value = "' . $_SESSION["admin_signup"]["Fname"] . '" >';
                } else {
                    echo '<input type="text" id="Fname" name="Fname" placeholder="First Name:" >';
                } 
                echo '</li>';

                echo '<li>';
                echo '<label for="Mname" id="required">required*</label>';
                if (isset($_SESSION["admin_signup"]["Mname"]) && !isset($_SESSION["signup_errors"])) {
                    echo '<input type="text" id="Mname" name="Mname" placeholder="Middle Name:" value = "' . $_SESSION["admin_signup"]["Mname"] . '" >';
                } else {
                    echo '<input type="text" id="Mname" name="Mname" placeholder="Middle Name:" >';
                }
                echo '</li>';

                echo '<li>';
                echo '<label for="suffix" id="optional">optional*</label>';
                echo '<select name="suffix" id="suffix">';
                echo    '<option value="NONE">Name Extention</option>';
                echo    '<option value="N/A" ' . (isset($_SESSION["admin_signup"]["suffix"]) && $_SESSION["admin_signup"]["suffix"] == "N/A" ? 'selected' : '') . '>N/A</option>';
                echo    '<option value="Jr." ' . (isset($_SESSION["admin_signup"]["suffix"]) && $_SESSION["admin_signup"]["suffix"] == "Jr." ? 'selected' : '') . '>Jr.</option>';
                echo    '<option value="Sr." ' . (isset($_SESSION["admin_signup"]["suffix"]) && $_SESSION["admin_signup"]["suffix"] == "Sr." ? 'selected' : '') . '>Sr.</option>';
                echo    '<option value="II" ' . (isset($_SESSION["admin_signup"]["suffix"]) && $_SESSION["admin_signup"]["suffix"] == "II" ? 'selected' : '') . '>II</option>';
                echo    '<option value="III" ' . (isset($_SESSION["admin_signup"]["suffix"]) && $_SESSION["admin_signup"]["suffix"] == "III" ? 'selected' : '') . '>III</option>';
                echo    '<option value="IV" ' . (isset($_SESSION["admin_signup"]["suffix"]) && $_SESSION["admin_signup"]["suffix"] == "IV" ? 'selected' : '') . '>IV</option>';
                echo    '<option value="V" ' . (isset($_SESSION["admin_signup"]["suffix"]) && $_SESSION["admin_signup"]["suffix"] == "V" ? 'selected' : '') . '>V</option>';
                echo '</select>';
                echo '</li>';
echo '</div>'; // four div para sa row

echo '<div class="profileP">';
                echo '<label for="profile">';
                    echo '<img src="../assets/image/users.png" alt="Profile Picture" class="profilePict">';
                echo '</label>';

                echo '<p>PROFILE</p>';
                echo '<input type="file" name="user_profile" id="profile" accept="image/*" style="display: none;" >';
echo '</div>'; // profile
echo '</div>'; //row div para sa dalawang div
echo '<div class="surname-email">';
                    
                    echo '<li id="employeeInputID">';
                echo '<label for="employeeID" id="required">required*</label>';
                    if (isset($_SESSION["admin_signup"]["employeeID"]) && !isset($_SESSION["signup_errors"])) {
                        echo '<input type="text" name="employeeID" placeholder="Employee ID:" value = "' . $_SESSION["admin_signup"]["employeeID"] . '" id="employeeId" >';
                        } else {
                        echo '<input type="text" name="employeeID" placeholder="Employee ID:" id="employeeID" >';
                    }
                echo '</li>';
                
                $department = $_SESSION["admin_signup"]["department"] ?? '';
                $schedule_from_value = ($_SESSION["admin_signup"]["schedule_from"] ?? '');
                $schedule_to_value = ($_SESSION["admin_signup"]["schedule_to"] ?? '');
                ?>

        <!-- Department Dropdown -->
<li>
    <label for="department" id="required">required*</label>
    <select name="department" id="departmentss" onchange="toggleScheduleFields()">
        <option value="NONE">Select Department</option>
        <option value="HOSPITAL" <?= $department === "HOSPITAL" ? 'selected' : '' ?>>HOSPITAL</option>
        <option value="SCHOOL" <?= $department === "SCHOOL" ? 'selected' : '' ?>>SCHOOL</option>
    </select>
</li>

<!-- SCHOOL Schedule Fields -->
<div id="school_schedule_field" style="display: none;" style="display: none; width: 65%;">
    <li style="width: 50%;">
        <label for="school_schedule_from" id="required">required*(Time Schedule From)</label>
        <select name="schedule_from" id="school_schedule_from" style="width: 14rem;">
            <option value="07:30:00" <?= $schedule_from_value === "07:30:00" ? 'selected' : '' ?>>07:30:00</option>
        </select>
    </li>
    <li style="width: 50%;">
        <label for="school_schedule_to" id="required">required*(Time Schedule To)</label>
        <select name="schedule_to" id="school_schedule_to" style="width: 14rem;">
            <option value="04:30:00" <?= $schedule_to_value === "04:30:00" ? 'selected' : '' ?>>04:30:00</option>
        </select>
    </li>
</div>

<!-- HOSPITAL Schedule Fields -->
<div id="hospital_schedule_field" class="editDivBg" style="display: none; width: 65%;">
    <li style="width: 50%;">
        <label for="hospital_schedule_from" id="required">required*(Time Schedule From)</label>
        <select name="schedule_from" id="hospital_schedule_from" style="width: 14rem;">
            <option value="07:00:00" <?= $schedule_from_value === "07:00:00" ? 'selected' : '' ?>>07:00:00</option>
            <option value="03:00:00" <?= $schedule_from_value === "03:00:00" ? 'selected' : '' ?>>03:00:00</option>
            <option value="11:00:00" <?= $schedule_from_value === "11:00:00" ? 'selected' : '' ?>>11:00:00</option>
        </select>
    </li>
    <li style="width: 50%;">
        <label for="hospital_schedule_to" id="required">required*(Time Schedule To)</label>
        <select name="schedule_to" id="hospital_schedule_to"  style="width: 14rem;">
            <option value="03:00:00" <?= $schedule_to_value === "03:00:00" ? 'selected' : '' ?>>03:00:00</option>
            <option value="11:00:00" <?= $schedule_to_value === "11:00:00" ? 'selected' : '' ?>>11:00:00</option>
            <option value="07:00:00" <?= $schedule_to_value === "07:00:00" ? 'selected' : '' ?>>07:00:00</option>
        </select>
    </li>
</div>
                <?php

                    echo '<li>';
                    
                    echo '<label for="job_Title" id="required">required*</label>';
                    echo '<select name="job_Title" id="RegisterJobTitle">';
                        echo '<option value="">Loading job titles...</option>';
                    echo '</select>';
                echo '</li>';
                    echo '</li>';
                    
                    echo '<li id="rateT">';
                    echo '<label for="rateType" id="required">required*</label>';
                    echo '<select name="rateType" id="rateType">';
                    echo    '<option value="NONE">Select Rate Type</option>';
                    echo    '<option value="MONTHLY" ' . (isset($_SESSION["admin_signup"]["rateType"]) && $_SESSION["admin_signup"]["rateType"] == "MONTHLY" ? 'selected' : '') . '>MONTHLY</option>';
                    echo    '<option value="DAILY" ' . (isset($_SESSION["admin_signup"]["rateType"]) && $_SESSION["admin_signup"]["rateType"] == "DAILY" ? 'selected' : '') . '>DAILY</option>';
                    echo    '<option value="HOURLY" ' . (isset($_SESSION["admin_signup"]["rateType"]) && $_SESSION["admin_signup"]["rateType"] == "HOURLY" ? 'selected' : '') . '>HOURLY</option>';
                    echo '</select>';
                    echo '</li>';
                    
                        
                    echo '<li id="salaryInput">';
                        echo '<label for="salary_Range_From" id="required">required*</label>';
                        if (isset($_SESSION["admin_signup"]["salary_Range_From"]) && !isset($_SESSION["signup_errors"])) {
                            echo '<input type="number" step="0.01" id="salary_Range_From" name="salary_Range_From" placeholder="Salary Range From:" value = "' . $_SESSION["admin_signup"]["salary_Range_From"] . '" >';
                            } else {
                            echo '<input type="number" step="0.01" id="salary_Range_From" name="salary_Range_From" placeholder="Salary Range From:" >';
                        }
                    echo '</li>';
                    echo '<li id="salaryInput">';
                        echo '<label for="salary_Range_To" id="required">required*</label>';
                        if (isset($_SESSION["admin_signup"]["salary_Range_To"]) && !isset($_SESSION["signup_errors"])) {
                            echo '<input type="number" step="0.01" id="salary_Range_To" name="salary_Range_To" placeholder="Salary Range To:" value = "' . $_SESSION["admin_signup"]["salary_Range_To"] . '" >';
                            } else {
                            echo '<input type="number" step="0.01" id="salary_Range_To" name="salary_Range_To" placeholder="Salary Range To:" >';
                        }
                    echo '</li>';
                    echo '<li>';
                    echo '<label for="gender" id="required">required*</label>';
                    echo '<select name="gender" id="gender">';
                    echo    '<option value="NONE">Select Rate Type</option>';
                    echo    '<option value="MALE" ' . (isset($_SESSION["admin_signup"]["gender"]) && $_SESSION["admin_signup"]["gender"] == "MALE" ? 'selected' : '') . '>MALE</option>';
                    echo    '<option value="FEMALE" ' . (isset($_SESSION["admin_signup"]["gender"]) && $_SESSION["admin_signup"]["gender"] == "FEMALE" ? 'selected' : '') . '>FEMALE</option>';
                    echo '</select>';
                    echo '</li>';
                    echo '<li>';
                        echo '<label for="Citizenship" id="required">required*</label>';
                        echo '<select id="Citizenship" name="Citizenship">';
                        echo    '<option value="">Select Citizenship</option>';
                        $citizenships = ["Natural-born", "Naturalized ", "Dual", "By election"];
                        foreach ($citizenships as $citizenship) {
                            $selected = (isset($_SESSION["admin_signup"]["Citizenship"]) && $_SESSION["admin_signup"]["Citizenship"] == $citizenship) ? 'selected' : '';
                            echo '<option value="' . $citizenship . '" ' . $selected . '>' . $citizenship . '</option>';
                        }
                        echo '</select>';
                    echo '</li>';
                    echo '<li>';
                    echo '<label for="" id="optional">optional</label>';
                    if (isset($_SESSION["admin_signup"]["age"]) && !isset($_SESSION["signup_errors"])) {
                        echo '<input type="text" id="age" name="age" placeholder="Age:" value = "' . $_SESSION["admin_signup"]["age"] . '" >';
                    } else {
                        echo '<input type="text" id="age" name="age" placeholder="Age:" >';
                    }
                    echo '</li>';
                    
                    echo '<li>';
                    echo '<label for="civil_Status" id="required">required*</label>';
                    echo '<select name="civil_Status" id="civil_Status">';
                    echo    '<option value="NONE">Select Civil Status</option>';
                    echo    '<option value="SINGLE" ' . (isset($_SESSION["admin_signup"]["civil_Status"]) && $_SESSION["admin_signup"]["civil_Status"] == "SINGLE" ? 'selected' : '') . '>SINGLE</option>';
                    echo    '<option value="MARRIED" ' . (isset($_SESSION["admin_signup"]["civil_Status"]) && $_SESSION["admin_signup"]["civil_Status"] == "MARRIED" ? 'selected' : '') . '>MARRIED</option>';
                    echo    '<option value="WIDOWED" ' . (isset($_SESSION["admin_signup"]["civil_Status"]) && $_SESSION["admin_signup"]["civil_Status"] == "WIDOWED" ? 'selected' : '') . '>WIDOWED</option>';
                    echo    '<option value="DIVORCED" ' . (isset($_SESSION["admin_signup"]["civil_Status"]) && $_SESSION["admin_signup"]["civil_Status"] == "DIVORCED" ? 'selected' : '') . '>DIVORCED</option>';
                    echo    '<option value="SEPARATED" ' . (isset($_SESSION["admin_signup"]["civil_Status"]) && $_SESSION["admin_signup"]["civil_Status"] == "SEPARATED" ? 'selected' : '') . '>SEPARATED</option>';
                    echo    '<option value="ANNULLED" ' . (isset($_SESSION["admin_signup"]["civil_Status"]) && $_SESSION["admin_signup"]["civil_Status"] == "ANNULLED" ? 'selected' : '') . '>ANNULLED</option>';
                    echo '</select>';
                    echo '</li>';
                    echo '</li>';
                    echo '<li>';
                    echo '<label for="" id="optional">optional</label>';
                    echo '<select name="Religion" id="Religion">';
                    $religions = ["Roman Catholic", "Iglesia ni Cristo", "Islam", "Protestant", "Evangelical", "Buddhism", "Hinduism", "Others"];
                    foreach ($religions as $religion) {
                        $selected = (isset($_SESSION["admin_signup"]["Religion"]) && $_SESSION["admin_signup"]["Religion"] == $religion) ? 'selected' : '';
                        echo '<option value="' . $religion . '" ' . $selected . '>' . $religion . '</option>';
                    }
                    echo '</select>';
                    echo '</li>';
                    echo '<li>';
                    echo '<label for="" id="optional">optional(Birth Day)</label>';
                    if (isset($_SESSION["admin_signup"]["birthday"]) && !isset($_SESSION["signup_errors"])) {
                        echo '<input type="date" name="birthday" placeholder="Birthday:" value = "' . $_SESSION["admin_signup"]["birthday"] . '" >';
                    } else {
                        echo '<input type="date" name="birthday" placeholder="Birthday:" >';
                    } 
                    echo '</li>';
                    echo '<li>';
                    echo '<label for="" id="optional">optional</label>';
                    if (isset($_SESSION["admin_signup"]["birth_Place"]) && !isset($_SESSION["signup_errors"])) {
                        echo '<input type="text" name="birth_Place" placeholder="Birth Place:" value = "' . $_SESSION["admin_signup"]["birth_Place"] . '" >';
                    } else {
                        echo '<input type="text" name="birth_Place" placeholder="Birth Place:" >';
                    }
                    echo '</li>';
                    
                
                    echo '<li>';
                        echo '<label for="Contact_No" id="required">required*</label>';
                        if (isset($_SESSION["admin_signup"]["Contact_No"]) && !isset($_SESSION["signup_errors"])) {
                            echo '<input type="text" id="Contact_No" name="Contact_No" placeholder="Contact No:" value = "' . $_SESSION["admin_signup"]["Contact_No"] . '" >';
                        } else {
                            echo '<input type="text" id="Contact_No" name="Contact_No" placeholder="Contact No:" >';
                        } 
                    echo '</li>';
                
                    echo '<li>';
                        echo '<label for="email" id="required">required*</label>';
                        if (isset($_SESSION["admin_signup"]["email"]) && !isset($_SESSION["signup_errors"]["invalid_email"])) {
                            echo '<input type="email" id="email" name="email" placeholder="E-mail: " value = "' . $_SESSION["admin_signup"]["email"] . '" >';
                        } else {
                            echo '<input type="email" id="email" name="email" placeholder="E-mail:" >';
                        }
                    echo '</li>';
echo '</div>'; // surname to email div
echo '</div>'; // center personal information
                    echo '<h3 id="h3Add">ADDRESS</h3>';
echo '<div class="address-div">';
                    echo '<li>';
                    echo '<label for="" id="optional">optional</label>';
                    if (isset($_SESSION["admin_signup"]["house_block"]) && !isset($_SESSION["signup_errors"])) {
                        echo '<input type="text" name="house_block" placeholder="House Block:" value = "' . $_SESSION["admin_signup"]["house_block"] . '" >';
                    } else {
                        echo '<input type="text" name="house_block" placeholder="House Block:" >';
                    }
                    echo '</li>';
                    echo '<li>';
                        echo '<label for="street" id="required">required*</label>';
                        if (isset($_SESSION["admin_signup"]["street"]) && !isset($_SESSION["signup_errors"])) {
                            echo '<input type="text" id="street" name="street" placeholder="Street:" value = "' . $_SESSION["admin_signup"]["street"] . '" >';
                        } else {
                            echo '<input type="text" id="street" name="street" placeholder="Street:" >';
                        } 
                    echo '</li>';
                    echo '<li>';
                    echo '<label for="" id="optional">optional</label>';
                    if (isset($_SESSION["admin_signup"]["subdivision"]) && !isset($_SESSION["signup_errors"])) {
                        echo '<input type="text" name="subdivision" placeholder="Subdivision: " value = "' . $_SESSION["admin_signup"]["subdivision"] . '" >';
                    } else {
                        echo '<input type="text" name="subdivision" placeholder="Subdivision:" >';
                    }
                    echo '</li>';
                    echo '<li>';
                        echo '<label for="barangay" id="required">required*</label>';
                        if (isset($_SESSION["admin_signup"]["barangay"]) && !isset($_SESSION["signup_errors"])) {
                            echo '<input type="text" id="barangay" name="barangay" placeholder="Barangay:" value = "' . $_SESSION["admin_signup"]["barangay"] . '" >';
                        } else {
                            echo '<input type="text" id="barangay" name="barangay" placeholder="Barangay:" >';
                        }
                    echo '</li>';
                    
                    echo '<li>';
                        echo '<label for="city_muntinlupa" id="required">required*</label>';
                        if (isset($_SESSION["admin_signup"]["city_muntinlupa"]) && !isset($_SESSION["signup_errors"])) {
                            echo '<input type="text" id="city_muntinlupa" name="city_muntinlupa" placeholder="City Muntinlupa:" value = "' . $_SESSION["admin_signup"]["city_muntinlupa"] . '" >';
                        } else {
                            echo '<input type="text" id="city_muntinlupa" name="city_muntinlupa" placeholder="City Muntinlupa:" >';
                        } 
                    echo '</li>';
                    
                    echo '<li>';
                        echo '<label for="province" id="required">required*</label>';
                        if (isset($_SESSION["admin_signup"]["province"]) && !isset($_SESSION["signup_errors"])) {
                            echo '<input type="text" id="province" name="province" placeholder="Province: " value = "' . $_SESSION["admin_signup"]["province"] . '" >';
                        } else {
                            echo '<input type="text" id="province" name="province" placeholder="Province:" >';
                        }
                    echo '</li>';
                        
                    echo '<li>';
                        echo '<label for="zip_code" id="required">required*</label>';
                        if (isset($_SESSION["admin_signup"]["zip_code"]) && !isset($_SESSION["signup_errors"])) {
                            echo '<input type="text" id="zip_code" name="zip_code" placeholder="Zip Code: " value = "' . $_SESSION["admin_signup"]["zip_code"] . '" >';
                        } else {
                            echo '<input type="text" id="zip_code" name="zip_code" placeholder="Zip Code:" >';
                        }
                    echo '</li>';
echo '</div>'; // address div
                    echo '<h3 id="h3Add">ACCOUNT AUTHENTICATION</h3>';
echo '<div class="account-auth">'; 
                    echo '<li>';
                        echo '<label for="username" id="required">required*</label>';
                        if (isset($_SESSION["admin_signup"]["username"]) && !isset($_SESSION["signup_errors"]["username_taken"])) {
                            echo '<input type="text" id="username" name="username" placeholder="Username: " value = "' . $_SESSION["admin_signup"]["username"] . '" >';
                        } else {
                            echo '<input type="text" id="username" name="username" placeholder="Username:"  >';
                        }
                        echo '</li>';
                    
                        echo '<li>';
                            echo '<label for="password" id="required">required*</label>';
                            echo '<input type="password" id="password" name="password" placeholder="Password" id="required" required >';
                        echo '</li>';
                        
                        echo '<li>';
                            echo '<label for="confirm_password" id="required">required*</label>';
                            echo '<input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm Password" id="required" required >';
                        echo '</li>';
echo '</div>';// account auth 
echo '</div>'; // AddEmployee
}

function Add_Employee(){    
echo '<div class="AddEmployee" id="AddEmployee">';
adminEmployee();
echo '<div class="back">';
                echo '<button type="button" id="bb" onclick="backButton()"><i class="fa-solid fa-arrow-left" style="font-size: 20px;"></i></button>';
                echo '<h3 id="h3WithBack">PERSONAL INFORMATION</h3>';
echo '</div>';
                $csrf_token = $_SESSION['csrf_token'] ?? '';
                echo '<form action = "../../auth/authentications.php" id="registerForm" method="post">';
                echo '<input type="hidden" name="addeemployee" value="Byadmin">';
                echo '<input type="hidden" name="csrf_token" value="' . $csrf_token . '">';

echo '<div class="CenterInfo">';
// echo '<div class="rowAddEmployee">';
echo '<div class="surname-email" id="se">';
// echo '<div class="four-div" id="inputDivFours">';
                echo '<li>';
                echo '<label for="Lname" id="required">required*</label>';
                if (isset($_SESSION["admin_signup"]["Lname"]) && !isset($_SESSION["signup_errors"])) {
                    echo '<input type="text" id="Lname" name="Lname" placeholder="Surname:" value = "' . $_SESSION["admin_signup"]["Lname"] . '" >';
                } else {
                    echo '<input type="text" id="Lname" name="Lname" placeholder="Surname:" >';
                }
                echo '</li>';

                echo '<li>';
                echo '<label for="Fname" id="required">required*</label>';
                if (isset($_SESSION["admin_signup"]["Fname"]) && !isset($_SESSION["signup_errors"])) {
                    echo '<input type="text" id="Fname" name="Fname" placeholder="First Name:" value = "' . $_SESSION["admin_signup"]["Fname"] . '" >';
                } else {
                    echo '<input type="text" id="Fname" name="Fname" placeholder="First Name:" >';
                } 
                echo '</li>';

                echo '<li>';
                echo '<label for="Mname" id="required">required*</label>';
                if (isset($_SESSION["admin_signup"]["Mname"]) && !isset($_SESSION["signup_errors"])) {
                    echo '<input type="text" id="Mname" name="Mname" placeholder="Middle Name:" value = "' . $_SESSION["admin_signup"]["Mname"] . '" >';
                } else {
                    echo '<input type="text" id="Mname" name="Mname" placeholder="Middle Name:" >';
                }
                echo '</li>';

                echo '<li>';
                echo '<label for="suffix" id="optional">optional*</label>';
                echo '<select name="suffix" id="suffix">';
                echo    '<option value="NONE">Name Extention</option>';
                echo    '<option value="N/A" ' . (isset($_SESSION["admin_signup"]["suffix"]) && $_SESSION["admin_signup"]["suffix"] == "N/A" ? 'selected' : '') . '>N/A</option>';
                echo    '<option value="Jr." ' . (isset($_SESSION["admin_signup"]["suffix"]) && $_SESSION["admin_signup"]["suffix"] == "Jr." ? 'selected' : '') . '>Jr.</option>';
                echo    '<option value="Sr." ' . (isset($_SESSION["admin_signup"]["suffix"]) && $_SESSION["admin_signup"]["suffix"] == "Sr." ? 'selected' : '') . '>Sr.</option>';
                echo    '<option value="II" ' . (isset($_SESSION["admin_signup"]["suffix"]) && $_SESSION["admin_signup"]["suffix"] == "II" ? 'selected' : '') . '>II</option>';
                echo    '<option value="III" ' . (isset($_SESSION["admin_signup"]["suffix"]) && $_SESSION["admin_signup"]["suffix"] == "III" ? 'selected' : '') . '>III</option>';
                echo    '<option value="IV" ' . (isset($_SESSION["admin_signup"]["suffix"]) && $_SESSION["admin_signup"]["suffix"] == "IV" ? 'selected' : '') . '>IV</option>';
                echo    '<option value="V" ' . (isset($_SESSION["admin_signup"]["suffix"]) && $_SESSION["admin_signup"]["suffix"] == "V" ? 'selected' : '') . '>V</option>';
                echo '</select>';
                echo '</li>';
                    
                    echo '<li id="employeeInputID">';
                echo '<label for="employeeID" id="required">required*</label>';
                    if (isset($_SESSION["admin_signup"]["employeeID"]) && !isset($_SESSION["signup_errors"])) {
                        echo '<input type="text" name="employeeID" placeholder="Employee ID:" value = "' . $_SESSION["admin_signup"]["employeeID"] . '" id="employeeId" >';
                        } else {
                        echo '<input type="text" name="employeeID" placeholder="Employee ID:" id="employeeID" >';
                    }
                echo '</li>';
                
                $department = $_SESSION["admin_signup"]["department"] ?? '';
                $schedule_from_value = ($_SESSION["admin_signup"]["schedule_from"] ?? '');
                $schedule_to_value = ($_SESSION["admin_signup"]["schedule_to"] ?? '');
                ?>

        <!-- Department Dropdown -->
<li>
    <label for="department" id="required">required*</label>
    <select name="department" id="departmentss" onchange="toggleScheduleFields()">
        <option value="NONE">Select Department</option>
        <option value="HOSPITAL" <?= $department === "HOSPITAL" ? 'selected' : '' ?>>HOSPITAL</option>
        <option value="SCHOOL" <?= $department === "SCHOOL" ? 'selected' : '' ?>>SCHOOL</option>
    </select>
</li>

<!-- SCHOOL Schedule Fields -->
<div id="school_schedule_field" style="display: none;" style="display: none; width: 65%;">
    <li style="width: 50%;">
        <label for="school_schedule_from" id="required">required*(Time Schedule From)</label>
        <select name="schedule_from" id="school_schedule_from" style="width: 14rem;">
            <option value="07:30:00" <?= $schedule_from_value === "07:30:00" ? 'selected' : '' ?>>07:30:00</option>
        </select>
    </li>
    <li style="width: 50%;">
        <label for="school_schedule_to" id="required">required*(Time Schedule To)</label>
        <select name="schedule_to" id="school_schedule_to" style="width: 14rem;">
            <option value="04:30:00" <?= $schedule_to_value === "04:30:00" ? 'selected' : '' ?>>04:30:00</option>
        </select>
    </li>
</div>

<!-- HOSPITAL Schedule Fields -->
<div id="hospital_schedule_field" class="editDivBg" style="display: none; width: 65%;">
    <li style="width: 50%;">
        <label for="hospital_schedule_from" id="required">required*(Time Schedule From)</label>
        <select name="schedule_from" id="hospital_schedule_from" style="width: 14rem;">
            <option value="07:00:00" <?= $schedule_from_value === "07:00:00" ? 'selected' : '' ?>>07:00:00</option>
            <option value="03:00:00" <?= $schedule_from_value === "03:00:00" ? 'selected' : '' ?>>03:00:00</option>
            <option value="11:00:00" <?= $schedule_from_value === "11:00:00" ? 'selected' : '' ?>>11:00:00</option>
        </select>
    </li>
    <li style="width: 50%;">
        <label for="hospital_schedule_to" id="required">required*(Time Schedule To)</label>
        <select name="schedule_to" id="hospital_schedule_to"  style="width: 14rem;">
            <option value="03:00:00" <?= $schedule_to_value === "03:00:00" ? 'selected' : '' ?>>03:00:00</option>
            <option value="11:00:00" <?= $schedule_to_value === "11:00:00" ? 'selected' : '' ?>>11:00:00</option>
            <option value="07:00:00" <?= $schedule_to_value === "07:00:00" ? 'selected' : '' ?>>07:00:00</option>
        </select>
    </li>
</div>
                <?php

                    echo '<li>';
                    
                    echo '<label for="job_Title" id="required">required*</label>';
                    echo '<select name="job_Title" id="job_TitleSelect" >';
                        echo '<option value="">Loading job titles...</option>';
                    echo '</select>';
                echo '</li>';
                echo '<li>';
                echo '<label for="salary_Range_From" id="required">required*</label>';
                if (isset($_SESSION["admin_signup"]["salary_Range_From"]) && !isset($_SESSION["signup_errors"])) {
                    echo '<input type="number" step="0.01" id="salary_Range_From" name="salary_Range_From" placeholder="Salary Range From:" value = "' . $_SESSION["admin_signup"]["salary_Range_From"] . '" >';
                    } else {
                    echo '<input type="number" step="0.01" id="salary_Range_From" name="salary_Range_From" placeholder="Salary Range From:" >';
                }
            echo '</li>';
            echo '<li>';
                echo '<label for="salary_Range_To" id="required">required*</label>';
                if (isset($_SESSION["admin_signup"]["salary_Range_To"]) && !isset($_SESSION["signup_errors"])) {
                    echo '<input type="number" step="0.01" id="salary_Range_To" name="salary_Range_To" placeholder="Salary Range To:" value = "' . $_SESSION["admin_signup"]["salary_Range_To"] . '" >';
                    } else {
                    echo '<input type="number" step="0.01" id="salary_Range_To" name="salary_Range_To" placeholder="Salary Range To:" >';
                }
            echo '</li>';
                    echo '<li id="rateT">';
                    echo '<label for="rateType" id="required">required*</label>';
                    echo '<select name="rateType" id="rateType">';
                    echo    '<option value="NONE">Select Rate Type</option>';
                    echo    '<option value="MONTHLY" ' . (isset($_SESSION["admin_signup"]["rateType"]) && $_SESSION["admin_signup"]["rateType"] == "MONTHLY" ? 'selected' : '') . '>MONTHLY</option>';
                    echo    '<option value="DAILY" ' . (isset($_SESSION["admin_signup"]["rateType"]) && $_SESSION["admin_signup"]["rateType"] == "DAILY" ? 'selected' : '') . '>DAILY</option>';
                    echo    '<option value="HOURLY" ' . (isset($_SESSION["admin_signup"]["rateType"]) && $_SESSION["admin_signup"]["rateType"] == "HOURLY" ? 'selected' : '') . '>HOURLY</option>';
                    echo '</select>';
                    echo '</li>';
                        
                    echo '<li>';
                    echo '<label for="gender" id="required">required*</label>';
                    echo '<select name="gender" id="gender">';
                    echo    '<option value="NONE">Select Gender</option>';
                    echo    '<option value="MALE" ' . (isset($_SESSION["admin_signup"]["gender"]) && $_SESSION["admin_signup"]["gender"] == "MALE" ? 'selected' : '') . '>MALE</option>';
                    echo    '<option value="FEMALE" ' . (isset($_SESSION["admin_signup"]["gender"]) && $_SESSION["admin_signup"]["gender"] == "FEMALE" ? 'selected' : '') . '>FEMALE</option>';
                    echo '</select>';
                    echo '</li>';
                    echo '<li>';
                        echo '<label for="Citizenship" id="required">required*</label>';
                        echo '<select id="Citizenship" name="Citizenship">';
                        echo    '<option value="">Select Citizenship</option>';
                        $citizenships = ["Natural-born", "Naturalized ", "Dual", "By election"];
                        foreach ($citizenships as $citizenship) {
                            $selected = (isset($_SESSION["admin_signup"]["Citizenship"]) && $_SESSION["admin_signup"]["Citizenship"] == $citizenship) ? 'selected' : '';
                            echo '<option value="' . $citizenship . '" ' . $selected . '>' . $citizenship . '</option>';
                        }
                        echo '</select>';
                    echo '</li>';
                    echo '<li>';
                    echo '<label for="" id="optional">optional</label>';
                    if (isset($_SESSION["admin_signup"]["age"]) && !isset($_SESSION["signup_errors"])) {
                        echo '<input type="text" id="age" name="age" placeholder="Age:" value = "' . $_SESSION["admin_signup"]["age"] . '" >';
                    } else {
                        echo '<input type="text" id="age" name="age" placeholder="Age:" >';
                    }
                    echo '</li>';
                    
                    echo '<li>';
                    echo '<label for="civil_Status" id="required">required*</label>';
                    echo '<select name="civil_Status" id="civil_Status">';
                    echo    '<option value="NONE">Select Civil Status</option>';
                    echo    '<option value="SINGLE" ' . (isset($_SESSION["admin_signup"]["civil_Status"]) && $_SESSION["admin_signup"]["civil_Status"] == "SINGLE" ? 'selected' : '') . '>SINGLE</option>';
                    echo    '<option value="MARRIED" ' . (isset($_SESSION["admin_signup"]["civil_Status"]) && $_SESSION["admin_signup"]["civil_Status"] == "MARRIED" ? 'selected' : '') . '>MARRIED</option>';
                    echo    '<option value="WIDOWED" ' . (isset($_SESSION["admin_signup"]["civil_Status"]) && $_SESSION["admin_signup"]["civil_Status"] == "WIDOWED" ? 'selected' : '') . '>WIDOWED</option>';
                    echo    '<option value="DIVORCED" ' . (isset($_SESSION["admin_signup"]["civil_Status"]) && $_SESSION["admin_signup"]["civil_Status"] == "DIVORCED" ? 'selected' : '') . '>DIVORCED</option>';
                    echo    '<option value="SEPARATED" ' . (isset($_SESSION["admin_signup"]["civil_Status"]) && $_SESSION["admin_signup"]["civil_Status"] == "SEPARATED" ? 'selected' : '') . '>SEPARATED</option>';
                    echo    '<option value="ANNULLED" ' . (isset($_SESSION["admin_signup"]["civil_Status"]) && $_SESSION["admin_signup"]["civil_Status"] == "ANNULLED" ? 'selected' : '') . '>ANNULLED</option>';
                    echo '</select>';
                    echo '</li>';
                    echo '</li>';
                    echo '<li>';
                    echo '<label for="" id="optional">optional</label>';
                    echo '<select name="Religion" id="Religion">';
                    $religions = ["Roman Catholic", "Iglesia ni Cristo", "Islam", "Protestant", "Evangelical", "Buddhism", "Hinduism", "Others"];
                    foreach ($religions as $religion) {
                        $selected = (isset($_SESSION["admin_signup"]["Religion"]) && $_SESSION["admin_signup"]["Religion"] == $religion) ? 'selected' : '';
                        echo '<option value="' . $religion . '" ' . $selected . '>' . $religion . '</option>';
                    }
                    echo '</select>';
                    echo '</li>';
                    echo '<li>';
                    echo '<label for="" id="optional">optional(Birth Day)</label>';
                    if (isset($_SESSION["admin_signup"]["birthday"]) && !isset($_SESSION["signup_errors"])) {
                        echo '<input type="date" name="birthday" placeholder="Birthday:" value = "' . $_SESSION["admin_signup"]["birthday"] . '" >';
                    } else {
                        echo '<input type="date" name="birthday" placeholder="Birthday:" >';
                    } 
                    echo '</li>';
                    echo '<li>';
                    echo '<label for="" id="optional">optional</label>';
                    if (isset($_SESSION["admin_signup"]["birth_Place"]) && !isset($_SESSION["signup_errors"])) {
                        echo '<input type="text" name="birth_Place" placeholder="Birth Place:" value = "' . $_SESSION["admin_signup"]["birth_Place"] . '" >';
                    } else {
                        echo '<input type="text" name="birth_Place" placeholder="Birth Place:" >';
                    }
                    echo '</li>';
                    
                
                    echo '<li>';
                        echo '<label for="Contact_No" id="required">required*</label>';
                        if (isset($_SESSION["admin_signup"]["Contact_No"]) && !isset($_SESSION["signup_errors"])) {
                            echo '<input type="text" id="Contact_No" name="Contact_No" placeholder="Contact No:" value = "' . $_SESSION["admin_signup"]["Contact_No"] . '" >';
                        } else {
                            echo '<input type="text" id="Contact_No" name="Contact_No" placeholder="Contact No:" >';
                        } 
                    echo '</li>';
                
                    echo '<li>';
                        echo '<label for="email" id="required">required*</label>';
                        if (isset($_SESSION["admin_signup"]["email"]) && !isset($_SESSION["signup_errors"]["invalid_email"])) {
                            echo '<input type="email" id="email" name="email" placeholder="E-mail: " value = "' . $_SESSION["admin_signup"]["email"] . '" >';
                        } else {
                            echo '<input type="email" id="email" name="email" placeholder="E-mail:" >';
                        }
                    echo '</li>';
echo '</div>'; // surname to email div
echo '</div>'; // center personal information
                    echo '<h3 id="h3Add">ADDRESS</h3>';
echo '<div class="address-div" id="se">';
                    echo '<li>';
                    echo '<label for="" id="optional">optional</label>';
                    if (isset($_SESSION["admin_signup"]["house_block"]) && !isset($_SESSION["signup_errors"])) {
                        echo '<input type="text" name="house_block" placeholder="House Block:" value = "' . $_SESSION["admin_signup"]["house_block"] . '" >';
                    } else {
                        echo '<input type="text" name="house_block" placeholder="House Block:" >';
                    }
                    echo '</li>';
                    echo '<li>';
                        echo '<label for="street" id="required">required*</label>';
                        if (isset($_SESSION["admin_signup"]["street"]) && !isset($_SESSION["signup_errors"])) {
                            echo '<input type="text" id="street" name="street" placeholder="Street:" value = "' . $_SESSION["admin_signup"]["street"] . '" >';
                        } else {
                            echo '<input type="text" id="street" name="street" placeholder="Street:" >';
                        } 
                    echo '</li>';
                    echo '<li>';
                    echo '<label for="" id="optional">optional</label>';
                    if (isset($_SESSION["admin_signup"]["subdivision"]) && !isset($_SESSION["signup_errors"])) {
                        echo '<input type="text" name="subdivision" placeholder="Subdivision: " value = "' . $_SESSION["admin_signup"]["subdivision"] . '" >';
                    } else {
                        echo '<input type="text" name="subdivision" placeholder="Subdivision:" >';
                    }
                    echo '</li>';
                    echo '<li>';
                        echo '<label for="barangay" id="required">required*</label>';
                        if (isset($_SESSION["admin_signup"]["barangay"]) && !isset($_SESSION["signup_errors"])) {
                            echo '<input type="text" id="barangay" name="barangay" placeholder="Barangay:" value = "' . $_SESSION["admin_signup"]["barangay"] . '" >';
                        } else {
                            echo '<input type="text" id="barangay" name="barangay" placeholder="Barangay:" >';
                        }
                    echo '</li>';
                    
                    echo '<li>';
                        echo '<label for="city_muntinlupa" id="required">required*</label>';
                        if (isset($_SESSION["admin_signup"]["city_muntinlupa"]) && !isset($_SESSION["signup_errors"])) {
                            echo '<input type="text" id="city_muntinlupa" name="city_muntinlupa" placeholder="City Muntinlupa:" value = "' . $_SESSION["admin_signup"]["city_muntinlupa"] . '" >';
                        } else {
                            echo '<input type="text" id="city_muntinlupa" name="city_muntinlupa" placeholder="City Muntinlupa:" >';
                        } 
                    echo '</li>';
                    
                    echo '<li>';
                        echo '<label for="province" id="required">required*</label>';
                        if (isset($_SESSION["admin_signup"]["province"]) && !isset($_SESSION["signup_errors"])) {
                            echo '<input type="text" id="province" name="province" placeholder="Province: " value = "' . $_SESSION["admin_signup"]["province"] . '" >';
                        } else {
                            echo '<input type="text" id="province" name="province" placeholder="Province:" >';
                        }
                    echo '</li>';
                        
                    echo '<li>';
                        echo '<label for="zip_code" id="required">required*</label>';
                        if (isset($_SESSION["admin_signup"]["zip_code"]) && !isset($_SESSION["signup_errors"])) {
                            echo '<input type="text" id="zip_code" name="zip_code" placeholder="Zip Code: " value = "' . $_SESSION["admin_signup"]["zip_code"] . '" >';
                        } else {
                            echo '<input type="text" id="zip_code" name="zip_code" placeholder="Zip Code:" >';
                        }
                    echo '</li>';
echo '</div>'; // address div
                    echo '<h3 id="h3Add">ACCOUNT AUTHENTICATION</h3>';
echo '<div class="account-auth" id="se">'; 
                    echo '<li>';
                        echo '<label for="username" id="required">required*</label>';
                        if (isset($_SESSION["admin_signup"]["username"]) && !isset($_SESSION["signup_errors"]["username_taken"])) {
                            echo '<input type="text" id="username" name="username" placeholder="Username: " value = "' . $_SESSION["admin_signup"]["username"] . '" >';
                        } else {
                            echo '<input type="text" id="username" name="username" placeholder="Username:"  >';
                        }
                        echo '</li>';
                    
                        echo '<li>';
                            echo '<label for="password" id="required">required*</label>';
                            echo '<input type="password" id="password" name="password" placeholder="Password" id="required" required >';
                        echo '</li>';
                        
                        echo '<li>';
                            echo '<label for="confirm_password" id="required">required*</label>';
                            echo '<input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm Password" id="required" required >';
                        echo '</li>';
echo '</div>';// account auth 
echo '</div>'; // AddEmployee
}

function getErrors_signups(){
    if(isset($_SESSION['signup_errors'])){
        $errors = $_SESSION['signup_errors'];
        
        foreach($errors as $error){
            echo '<div class="errors-register">';
                echo '<p><li>*' . $error . '</li></p>';
            echo '</div>';
        }

        unset($_SESSION['signup_errors']);
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                document.getElementById('AddEmployee').style.display = 'flex';
            });
          </script>";
    }
}

function adminEmployee(){
    if(isset($_SESSION['admin_Errors'])){
        $errors = $_SESSION['admin_Errors'];
        echo '<div class="errors-admin">';
        foreach($errors as $error){
            
                echo '<ul class="errors-register">';
                    echo '<p><li>*' . $error . '</li></p>';
                echo '</ul>';
            
        }
        echo '</div>';
        unset($_SESSION['admin_Errors']);
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                document.getElementById('addmamhen').style.display = 'flex';
            });
          </script>";
    }
}
function leaveEmployee(){
    if(isset($_SESSION['leaveForm_errors'])){
        $errors = $_SESSION['leaveForm_errors'];
        echo '<div class="errors-admin">';
        foreach($errors as $error){
            
                echo '<ul class="errors-register">';
                    echo '<p><li>*' . $error . '</li></p>';
                echo '</ul>';
            
        }
        echo '</div>';
        unset($_SESSION['leaveForm_errors']);
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                document.getElementById('hiddenBreavement').style.display = 'flex';
            });
          </script>";
    }
}
function approvedSuccess() {
    $messages = [
        "approve"  => "Account Approved successfully!",
        "rejected" => "Account Rejected successfully!",
        "deleted"  => "Account deleted successfully!",
        "add"      => "Employee Account Added successfully!",
        "password" => "Password Changed successfully!",
        "job"      => [
            "success" => "Job Title Added successfully!",
            "empty"   => "Empty Input, Try again!"
        ],
        "admin"    => "Register successfully!",
        "update"   => "Profile Updated successfully!",
        "signup"   => "Register successfully!",
        "leave"    => "Employee Leave Successfully!",
        "rejectedL"    => "Employee Leave Rejected Successfully!",
        "leaveAksep"    => "Employee Leave Accepted Successfully!",
        "leaveE"    => "Leave Request Successfully!",
        "deleted"  => [
            "job" => "Job Title deleted successfully!"
        ]
    ];

    foreach ($messages as $key => $value) {
        if (is_array($value)) {
            foreach ($value as $subkey => $msg) {
                if (isset($_GET[$key]) && $_GET[$key] === $subkey) {
                    echo '<div class="' . ($subkey === "empty" ? 'unsuccess-registers' : 'success-register') . '" id="sideSuccess">';
                    echo "<p>$msg</p>";
                    echo '</div>';
                }
            }
        } else {
            if (isset($_GET[$key]) && $_GET[$key] === "success") {
                $customClass = ($key === "admin" || $key === "signup") ? "success-registers" : "success-register";
                echo '<div class="' . $customClass . '" id="sideSuccess">';
                echo "<p>$value</p>";
                echo '</div>';
            }
        }
    }

    // Fade out script if any message was shown
    if (!empty(array_intersect(array_keys($_GET), array_keys($messages)))) {
        echo '<script>
            setTimeout(function() {
                var successDiv = document.getElementById("sideSuccess");
                if(successDiv) {
                    successDiv.style.display = "none";
                }
            }, 2000);
        </script>';
    }
}


