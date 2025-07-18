<?php

declare(strict_types=1);
// ==================== REGISTER FOR EMPLOYEE ==================== //
function signup_inputs(){
    echo '<main class="main-container w-100" style="height: 85%;">';
       $csrf_token = $_SESSION['csrf_token'] ?? '';
       $signup_data = $_SESSION["user_signups"] ?? [];
       $errors = $_SESSION["signup_errors"] ?? [];
       
       unset($_SESSION["user_signups"]);
       unset($_SESSION["signup_errors"]);
       
        echo '<div class="column-container h-auto py-4 w-100 rounded-2 p-2 px-4 shadow" style="background-color: #fefefe;">';
            echo '<div class="col-md-12">';
                echo '<div class="back-button w-100">';
                    echo '<a href="index.php" class="text-start" style="z-index: 0;"><i class="fa-solid fa-arrow-left-long fs-4"></i></a>';
                echo '</div>';
               echo '<form id="signupFormEmp" action="../auth/authentications.php" method="post" enctype="multipart/form-data"
                    class="form-signup w-100 overflow-y-auto d-flex flex-column justify-content-start align-items-center m-0 p-0" style="max-height: 72.5vh; overflow-y: auto;">';
                    echo '<input type="hidden" name="csrf_token" value="' . $csrf_token . '">';
                    echo '<input type="hidden" name="register_user" value="true">';
                    // Display errors if they exist
                    if (!empty($errors)) {
                        echo '<div class="alert alert-danger">';
                        foreach ($errors as $error) {
                            echo '<p class="mb-1" style="color:#fff;">' . htmlspecialchars($error) . '</p>';
                        }
                        echo '</div>';
                    }
                    // ================= 1st step ============================ //
                    echo '<div class="form-group row w-100 justify-content-center align-items-start" id="st-step" style="display: flex;">';
                        echo '<div class="stepper mb-1">';
                            echo '<div class="step active">1</div>';
                            echo '<div class="lines"></div>';
                            echo '<div class="step">2</div>';
                            echo '<div class="lines"></div>';
                            echo '<div class="step">3</div>';
                        echo '</div>';
                        echo '<div class="col-md-4 px-1 d-flex flex-column w-31 mb-2 p-0">';
                            echo '<label for="surname" class="mb-0 text-start w-100" style="color:red; font-weight:400 !important;">Required</label>';
                            echo '<input type="text" name="lname" id="surname" class="form-control p-1 py-2 rounded-1" placeholder="Surname:" value="' . (isset($signup_data['lname']) ? htmlspecialchars($signup_data['lname']) : '') . '">';
                        echo '</div>';

                        echo '<div class="col-md-4 px-1 d-flex flex-column w-31 mb-2 p-0">';
                            echo '<label for="fname" class="mb-0 text-start w-100" style="color:red; font-weight:400 !important;">Required</label>';
                            echo '<input type="text" name="fname" id="fname" class="form-control p-1 py-2 rounded-1" placeholder="First Name:" value="' . (isset($signup_data['fname']) ? htmlspecialchars($signup_data['fname']) : '') . '">';
                        echo '</div>';

                        echo '<div class="col-md-4 px-1 d-flex flex-column w-31 mb-2 p-0">';
                            echo '<label for="mname" class="mb-0 text-start w-100" style="color:red; font-weight:400 !important;">Required</label>';
                            echo '<input type="text" name="mname" id="mname" class="form-control p-1 py-2 rounded-1" placeholder="Middle Name:" value="' . (isset($signup_data['mname']) ? htmlspecialchars($signup_data['mname']) : '') . '">';
                        echo '</div>';

                        echo '<div class="   d-flex flex-wrap w-100 px-0 justify-content-center">';
                            echo '<div class="col-12 col-md-6 mb-2 px-1">';
                                echo '<label for="employeeIDEmp" class="mb-0" style="color:red; font-weight:400 !important;">Required</label>';
                                echo '<input type="text" name="employeeID" id="employeeIDEmp" class="form-control p-1 py-2 rounded-1" placeholder="Employee ID:" value="' . (isset($signup_data['employeeID']) ? htmlspecialchars($signup_data['employeeID']) : '') . '">';
                            echo '</div>';

                            echo '<div class="col-12 col-md-6 mb-2 px-1">';
                                echo '<label for="mname" class="mb-0" style="color:red; font-weight:400 !important;">Required</label>';
                                echo '<select name="department" id="Department" class="form-select p-1 py-2 rounded-1" >';
                                    echo '<option value="NO DEPARTMENT"' . (isset($signup_data['department']) && $signup_data['department'] == 'NO DEPARTMENT' ? ' selected' : '') . '>Select Department</option>';
                                    echo '<option value="HOSPITAL"' . (isset($signup_data['department']) && $signup_data['department'] == 'HOSPITAL' ? ' selected' : '') . '>HOSPITAL</option>';
                                    echo '<option value="SCHOOL"' . (isset($signup_data['department']) && $signup_data['department'] == 'SCHOOL' ? ' selected' : '') . '>SCHOOL</option>';
                                echo '</select>';
                            echo '</div>';
                        echo '</div>';
                        echo '<div class="col-md-12 d-flex flex-wrap w-100 px-0 justify-content-center">';
                            echo '<div class="col-12 col-md-6 mb-2 px-1">';
                                echo '<label for="jobTitle" class="mb-0" style="color:red; font-weight:400 !important;">Required</label>';
                                echo '<select name="jobTitle" id="JobTitle" class="form-select p-1 py-2 rounded-1">';
                                    echo '<option value="">Select Job Title</option>';
                                    if (isset($signup_data['jobTitle'])) {
                                        echo '<option value="' . htmlspecialchars($signup_data['jobTitle']) . '" selected hidden>' . htmlspecialchars($signup_data['jobTitle']) . '</option>';
                                    }
                                echo '</select>';
                            echo '</div>';
                            echo '<div class="col-12 col-md-6 mb-2 px-1">';
                                echo '<label for="Slary_rate" class="mb-0" style="color:red; font-weight:400 !important;">Required</label>';
                                echo '<select name="slary_rate" id="Slary_rate" class="form-select p-1 py-2 rounded-1">';
                                    echo '<option value="NO SALARY RATE"' . (isset($signup_data['slary_rate']) && $signup_data['slary_rate'] == 'NO DALARY RATE' ? ' selected' : '') . '>Select Slary Rate</option>';
                                    echo '<option value="MONTHLY"' . (isset($signup_data['slary_rate']) && $signup_data['slary_rate'] == 'MONTHLY' ? ' selected' : '') . '>MONTHLY</option>';
                                    echo '<option value="DAILY"' . (isset($signup_data['slary_rate']) && $signup_data['slary_rate'] == 'DAILY' ? ' selected' : '') . '>DAILY</option>';
                                    echo '<option value="HOURLY"' . (isset($signup_data['slary_rate']) && $signup_data['slary_rate'] == 'HOURLY' ? ' selected' : '') . '>HOURLY</option>';
                                echo '</select>';
                            echo '</div>';
                        echo '</div>';
                        echo '<div class="col-md-12 d-flex flex-wrap w-100 px-0 justify-content-center">';
                            echo '<div class="col-12 col-md-6 mb-2 px-1">';
                                echo '<label for="age" class="mb-0" style="color:#000; font-weight: 400 !important">Optional</label>';
                                echo '<input type="text" name="age" id="age" class="form-control p-1 py-2 rounded-1" placeholder="Age:" value="' . (isset($signup_data['age']) ? htmlspecialchars($signup_data['age']) : '') . '">';
                            echo '</div>';
                            echo '<div class="col-12 col-md-6 mb-2 px-1">';
                                echo '<label for="Citizenship" class="mb-0" style="color:red; font-weight:400 !important;">Required</label>';
                                echo '<select name="citizenship" id="Citizenship" class="form-select p-1 py-2 rounded-1">';
                                    echo '<option value="NO Citizenship"' . (isset($signup_data['citizenship']) && $signup_data['citizenship'] == 'NO Citizenship' ? ' selected' : '') . '>Select Citizenship</option>';
                                    echo '<option value="NATURAL-BORN"' . (isset($signup_data['citizenship']) && $signup_data['citizenship'] == 'NATURAL-BORN' ? ' selected' : '') . '>NATURAL-BORN</option>';
                                    echo '<option value="NATURALIZED"' . (isset($signup_data['citizenship']) && $signup_data['citizenship'] == 'NATURALIZED' ? ' selected' : '') . '>NATURALIZED</option>';
                                    echo '<option value="DUAL"' . (isset($signup_data['citizenship']) && $signup_data['citizenship'] == 'DUAL' ? ' selected' : '') . '>DUAL</option>';
                                    echo '<option value="BY ELECTION"' . (isset($signup_data['citizenship']) && $signup_data['citizenship'] == 'BY ELECTION' ? ' selected' : '') . '>BY ELECTION</option>';
                                echo '</select>';
                            echo '</div>';
                        echo '</div>';
                        echo '<div class="col-md-12 d-flex flex-wrap w-100 px-0 justify-content-center">';
                            echo '<div class="col-12 col-md-6 mb-2 px-1">';
                                echo '<label for="gender" class="mb-0" style="color:red; font-weight:400 !important;">Required</label>';
                                echo '<select name="gender" id="gender" class="form-select p-1 py-2 rounded-1">';
                                    echo '<option value="NO GENDER"' . (isset($signup_data['gender']) && $signup_data['gender'] == 'NO GENDER' ? ' selected' : '') . '>Select Gender</option>';
                                    echo '<option value="MALE"' . (isset($signup_data['gender']) && $signup_data['gender'] == 'MALE' ? ' selected' : '') . '>MALE</option>';
                                    echo '<option value="FEMALE"' . (isset($signup_data['gender']) && $signup_data['gender'] == 'FEMALE' ? ' selected' : '') . '>FEMALE</option>';
                                echo '</select>';
                            echo '</div>';
                            echo '<div class="col-12 col-md-6 mb-2 px-1">';
                                echo '<label for="mname" class="mb-0" style="color:red; font-weight:400 !important;">Required</label>';
                                echo '<select name="civil_status" id="civil_status" class="form-select p-1 py-2 rounded-1">';
                                    echo '<option value=""' . (!isset($signup_data['civil_status']) ? ' selected' : '') . '>Select Civil Status</option>';
                                    echo '<option value="Single"' . (isset($signup_data['civil_status']) && $signup_data['civil_status'] == 'Single' ? ' selected' : '') . '>Single</option>';
                                    echo '<option value="Married"' . (isset($signup_data['civil_status']) && $signup_data['civil_status'] == 'Married' ? ' selected' : '') . '>Married</option>';
                                    echo '<option value="Widowed"' . (isset($signup_data['civil_status']) && $signup_data['civil_status'] == 'Widowed' ? ' selected' : '') . '>Widowed</option>';
                                    echo '<option value="Divorced"' . (isset($signup_data['civil_status']) && $signup_data['civil_status'] == 'Divorced' ? ' selected' : '') . '>Divorced</option>';
                                echo '</select>';
                            echo '</div>';
                        echo '</div>';
                        echo '<div class="col-md-12 d-flex flex-wrap w-100 px-0 justify-content-center">';
                            echo '<div class="col-12 col-md-12 px-1">';
                                echo '<label for="fname" class="mb-0" style="color:#000; font-weight: 400 !important">Optional</label>';
                                echo '<select name="religion" id="religion" class="form-select p-1 py-2 rounded-1">';
                                    echo '<option value=""' . (!isset($signup_data['religion']) ? ' selected' : '') . '>Select Religion</option>';
                                    echo '<option value="Roman Catholic"' . (isset($signup_data['religion']) && $signup_data['religion'] == 'Roman Catholic' ? ' selected' : '') . '>Roman Catholic</option>';
                                    echo '<option value="Iglesia ni Cristo"' . (isset($signup_data['religion']) && $signup_data['religion'] == 'Iglesia ni Cristo' ? ' selected' : '') . '>Iglesia ni Cristo</option>';
                                    echo '<option value="Evangelical"' . (isset($signup_data['religion']) && $signup_data['religion'] == 'Evangelical' ? ' selected' : '') . '>Evangelical</option>';
                                    echo '<option value="Islam"' . (isset($signup_data['religion']) && $signup_data['religion'] == 'Islam' ? ' selected' : '') . '>Islam</option>';
                                    echo '<option value="Seventh-day Adventist"' . (isset($signup_data['religion']) && $signup_data['religion'] == 'Seventh-day Adventist' ? ' selected' : '') . '>Seventh-day Adventist</option>';
                                    echo '<option value="Jehovah\'s Witness"' . (isset($signup_data['religion']) && $signup_data['religion'] == 'Jehovah\'s Witness' ? ' selected' : '') . '>Jehovah\'s Witness</option>';
                                    echo '<option value="Buddhism"' . (isset($signup_data['religion']) && $signup_data['religion'] == 'Buddhism' ? ' selected' : '') . '>Buddhism</option>';
                                    echo '<option value="Hinduism"' . (isset($signup_data['religion']) && $signup_data['religion'] == 'Hinduism' ? ' selected' : '') . '>Hinduism</option>';
                                    echo '<option value="None"' . (isset($signup_data['religion']) && $signup_data['religion'] == 'None' ? ' selected' : '') . '>None</option>';
                                    echo '<option value="Other"' . (isset($signup_data['religion']) && $signup_data['religion'] == 'Other' ? ' selected' : '') . '>Other</option>';
                                echo '</select>';
                            echo '</div>';
                        echo '</div>';
                    echo '</div>';
                    // ================= 2nd step ============================ //
                    echo '<div class="form-group row w-100 mb-1" id="nd-step" style="display: none;">';
                        echo '<div class="stepper mb-2">';
                            echo '<div class="step">1</div>';
                            echo '<div class="lines"></div>';
                            echo '<div class="step active">2</div>';
                            echo '<div class="lines"></div>';
                            echo '<div class="step">3</div>';
                        echo '</div>';
                        echo '<div class="col-md-12 d-flex flex-wrap w-100 px-0 justify-content-center">';
                            echo '<div class="col-12 col-md-6 px-1">';
                                echo '<label for="birthday" class="mb-0" style="color:red; font-weight:400 !important;">Required (Birthday)</label>';
                                echo '<input type="date" name="birthday" id="birthday" class="form-control p-1 py-2 rounded-1" placeholder="Birthday:" value="' . (isset($signup_data['birthday']) ? htmlspecialchars($signup_data['birthday']) : '') . '">';
                            echo '</div>';
                            echo '<div class="col-12 col-md-6 px-1">';
                                echo '<label for="birthPlace" class="mb-0" style="color:#000; font-weight: 400 !important">Optional</label>';
                                echo '<input type="text" name="birthPlace" id="birthPlace" class="form-control p-1 py-2 rounded-1" placeholder="Birth Place:" value="' . (isset($signup_data['birthPlace']) ? htmlspecialchars($signup_data['birthPlace']) : '') . '">';
                            echo '</div>';
                        echo '</div>';

                        echo '<div class="col-md-12 d-flex flex-wrap w-100 px-0 justify-content-center">';
                            echo '<div class="col-12 col-md-6 px-1">';
                                echo '<label for="contactEmp" class="mb-0" style="color:red; font-weight:400 !important;">Required</label>';
                                echo '<input type="text" name="contact" id="contactEmp" class="form-control p-1 py-2 rounded-1" placeholder="Contact Number:" value="' . (isset($signup_data['contact']) ? htmlspecialchars($signup_data['contact']) : '') . '">';
                            echo '</div>';

                            echo '<div class="col-12 col-md-6 px-1">';
                                echo '<label for="emailEmp" class="mb-0" style="color:red; font-weight:400 !important;">Required</label>';
                                echo '<input type="text" name="email" id="emailEmp" class="form-control p-1 py-2 rounded-1" placeholder="E-mail:" value="' . (isset($signup_data['email']) ? htmlspecialchars($signup_data['email']) : '') . '">';
                            echo '</div>';
                        echo '</div>';
                        echo '<div class="col-md-12 d-flex flex-wrap w-100 px-0 justify-content-center">';
                            echo '<div class="col-12 col-md-6 px-1">';
                                echo '<label for="scheduleFrom" class="mb-0" style="color:red; font-weight:400 !important;">Required (Schedule From)</label>';
                                echo '<select name="scheduleFrom" id="scheduleFrom" class="form-select p-1 py-2 rounded-1">';
                                    echo '<option value="">Select Schedule From</option>';
                                echo '</select>';
                            echo '</div>';

                            echo '<div class="col-12 col-md-6 px-1">';
                                echo '<label for="scheduleTo" class="mb-0" style="color:red; font-weight:400 !important;">Required (Schedule To)</label>';
                                echo '<select name="scheduleTo" id="scheduleTo" class="form-select p-1 py-2 rounded-1">';
                                    echo '<option value="">Select Schedule To</option>';
                                echo '</select>';
                            echo '</div>';

                        echo '</div>';
                        echo '<div class="col-md-12 d-flex flex-wrap w-100 px-0 justify-content-center">';
                            echo '<h3 class="w-100 text-start fs-4 my-1 mt-3 ms-2 fw-bold">Address</h3>';
                        echo '</div>';
                        echo '<div class="w-100 px-0 d-flex flex-row flex-wrap justify-content-center align-items-center">';
                            echo '<div class="col-12 col-md-4 d-flex flex-column px-1">';
                                echo '<label for="houseBlock" class="mb-0 text-start w-100" style="color:#000; font-weight: 400 !important">Optional</label>';
                                echo '<input type="text" name="houseBlock" id="houseBlock" class="form-control p-1 py-2 rounded-1" placeholder="House Block:" value="' . (isset($signup_data['houseBlock']) ? htmlspecialchars($signup_data['houseBlock']) : '') . '">';
                            echo '</div>';

                            echo '<div class="col-12 col-md-4 d-flex flex-column px-1">';
                                echo '<label for="street" class="mb-0 text-start w-100" style="color:red; font-weight:400 !important;">Required</label>';
                                echo '<input type="text" name="street" id="street" class="form-control p-1 py-2 rounded-1" placeholder="Street:" value="' . (isset($signup_data['street']) ? htmlspecialchars($signup_data['street']) : '') . '">';
                            echo '</div>';

                            echo '<div class="col-12 col-md-4 d-flex flex-column px-1">';
                                echo '<label for="Subdivision" class="mb-0 text-start w-100" style="color:#000; font-weight: 400 !important">Optional</label>';
                                echo '<input type="text" name="subdivision" id="Subdivision" class="form-control p-1 py-2 rounded-1" placeholder="Subdivision:" value="' . (isset($signup_data['subdivision']) ? htmlspecialchars($signup_data['subdivision']) : '') . '">';
                            echo '</div>';
                        echo '</div>';
                        echo '<div class="col-md-12 d-flex flex-wrap w-100 px-0 justify-content-center">';
                            echo '<div class="col-12 col-md-6 px-1">';
                                echo '<label for="Brangay" class="mb-0" style="color:red; font-weight:400 !important;">Required</label>';
                                echo '<input type="text" name="barangay" id="Brangay" class="form-control p-1 py-2 rounded-1" placeholder="Brangay:" value="' . (isset($signup_data['barangay']) ? htmlspecialchars($signup_data['barangay']) : '') . '">';
                            echo '</div>';

                            echo '<div class="col-12 col-md-6 px-1">';
                                echo '<label for="city_muntinlupa" class="mb-0" style="color:red; font-weight:400 !important;">Required</label>';
                                echo '<input type="text" name="city_muntinlupa" id="city_muntinlupa" class="form-control p-1 py-2 rounded-1" placeholder="City Muntinlupa:" value="' . (isset($signup_data['city_muntinlupa']) ? htmlspecialchars($signup_data['city_muntinlupa']) : '') . '">';
                            echo '</div>';
                        echo '</div>';
                        echo '<div class="col-md-12 d-flex flex-wrap w-100 px-0 justify-content-center">';
                            echo '<div class="col-12 col-md-6 px-1">';
                                echo '<label for="province" class="mb-0" style="color:red; font-weight:400 !important;">Required</label>';
                                echo '<input type="text" name="province" id="province" class="form-control p-1 py-2 rounded-1" placeholder="Province:" value="' . (isset($signup_data['province']) ? htmlspecialchars($signup_data['province']) : '') . '">';
                            echo '</div>';

                            echo '<div class="col-12 col-md-6 px-1">';
                                echo '<label for="zipCode" class="mb-0" style="color:red; font-weight:400 !important;">Required</label>';
                                echo '<input type="text" name="zipCode" id="zipCode" class="form-control p-1 py-2 rounded-1" placeholder="Zip Code:" value="' . (isset($signup_data['zipCode']) ? htmlspecialchars($signup_data['zipCode']) : '') . '">';
                            echo '</div>';
                        echo '</div>';
                    echo '</div>';
                    // ================= 3rd step ============================ //
                    echo '<div class="form-group row w-100 mb-5" id="rd-step" style="display: none; z-index: 3 !important">';
                        echo '<div class="stepper">';
                            echo '<div class="step">1</div>';
                            echo '<div class="lines"></div>';
                            echo '<div class="step">2</div>';
                            echo '<div class="lines"></div>';
                            echo '<div class="step active">3</div>';
                        echo '</div>';
                        echo '<div class="form-group col-md-12 d-flex flex-column justify-content-center align-items-center w-100 m-0" id="image">';
                            echo '<label for="profileEmp" class="mt-3"><img src="../assets/image/users.png" class="rounded-5 m-0" style="width: 200px; height: 200px; border-radius: 50% !important;" id="imageID"></label>';
                            echo '<input type="file" name="user_profile" style="display: none;" id="profileEmp" onchange="previewImage(event)">';
                            echo '<p class="mb-3">Profile Picture</p>';
                        echo  '</div>';
                        echo '<div class="col-md-12 w-100 d-flex flex-column px-0">';
                            echo '<div class="col-md-4 px-1 w-100">';
                                echo '<label for="usernameEmp" class="mb-0" style="color:red; font-weight:400 !important;">Required</label>';
                                echo '<input type="text" name="username" id="usernameEmp" class="form-control p-1 mb-2 py-2 rounded-1" placeholder="Username:" value="' . (isset($signup_data['username']) ? htmlspecialchars($signup_data['username']) : '') . '">';
                            echo '</div>';

                            echo '<div class="col-md-4 px-1 w-100 position-relative">'; 
                                echo '<li class="li-div w-100 flex-column" style="display: flex; list-style-type: none; align-items: center; position: relative;">'; 
                                    echo '<input type="password" class="form-control rounded-1 mb-2 pe-4" name="password" placeholder="Password" required id="passwordInputEmp" style="flex: 1;" value="' . (isset($signup_data['password']) ? htmlspecialchars($signup_data['password']) : '') . '">';

                                    echo '<button type="button" id="showPasswordEmp" style="background: none; border: none; position: absolute; right: 1.5rem; top: 50%; transform: translateY(-50%);">';
                                        echo '<i class="fa-solid fa-eye"></i>';
                                    echo '</button>';

                                    echo '<button type="button" id="hidePasswordEmp" style="background: none; border: none; position: absolute; right: 1.5rem; top: 50%; transform: translateY(-50%); display: none;">';
                                        echo '<i class="fa-solid fa-eye-slash"></i>';
                                    echo '</button>';
                                echo '</li>';
                            echo '</div>';

                            echo '<div class="col-md-4 px-1 w-100 position-relative">'; 
                                echo '<li class="li-div w-100 flex-column" style="display: flex; list-style-type: none; align-items: center; position: relative;">'; 
                                    echo '<input type="password" class="form-control rounded-1 pe-4" name="confirmPassword" placeholder="Confirm Password" required id="confirmPasswordInputEmp" style="flex: 1;" value="' . (isset($signup_data['confirmPassword']) ? htmlspecialchars($signup_data['confirmPassword']) : '') . '">';

                                    echo '<button type="button" id="showConfirmPasswordEmp" style="background: none; border: none; position: absolute; right: 1.5rem; top: 50%; transform: translateY(-50%);">';
                                        echo '<i class="fa-solid fa-eye"></i>';
                                    echo '</button>';

                                    echo '<button type="button" id="hideConfirmPasswordEmp" style="background: none; border: none; position: absolute; right: 1.5rem; top: 50%; transform: translateY(-50%); display: none;">';
                                        echo '<i class="fa-solid fa-eye-slash"></i>';
                                    echo '</button>';
                                echo '</li>';
                            echo '</div>';

                        echo '</div>';
                    echo '</div>';
                    // echo '<div class="col-md-12 w-100" mb-1 style="height: 35px; display: flex;"  id="button-signup">';
                    //     echo '<button class="col-12 col-md-12 border-0 mb-1 text-center rounded-1" style="height: 100%;" onclick="disable_Button()" id="button-signups">Sign-up</button>';
                    // echo '</div>';
                    echo '<div class="col-md-12 w-100" mb-1 style="height: 35px; display: none; margin-top: -1.5rem"  id="button-signup-rd">';
                        echo '<button class="col-12 col-md-12 border-0 mb-1 px-1 text-center col-12 h-auto" onclick="signUP()" type="submit" id="button-signup-rds">Sign-up</button>';
                    echo '</div>';
                echo '</form>';
            //====================== FIRST PAGE BUTTONS =============== //
            echo '<div class="buttons-div col-md-12 mt-1  flex-column justify-content-center align-items-center" id="stButton" style="display: flex;">';
                echo '<div class="firstPage-button col-md-12 col-12 d-flex justify-content-center align-items-center gap-1" id="stButton">';
                    // echo '<button type="button" id="backs" onclick="backst()" class="border-0 p-0 py-1 col-md-6 col-6">BACK</button>';
                    echo '<button type="button" id="next" onclick="nextst()" class="border-0 p-0 py-1 col-md-12 col-12">NEXT</button>';
                echo '</div>';
            echo '</div>';
            //====================== SECOND PAGE BUTTONS =============== //
            echo '<div class="buttons-div-second col-md-12 mt-1 flex-column justify-content-center align-items-center" style="display: none;" id="ndBUtton">';
                    echo '<div class="firstPage-button col-md-12 col-12 justify-content-center gap-1 flex-wrap justify-content-evenly" id="ndButton" style="display: flex;">';
                        echo '<button type="button" id="back" onclick="backnd()" class="border-0 p-0 py-1 col-md-5 col-12">BACK</button>';
                        echo '<button type="button" id="next" onclick="nextnd()" class="border-0 p-0 py-1 col-md-5 col-12">NEXT</button>';
                    echo '</div>';
                echo '</div>';
            echo '</div>';
            //====================== THIRD PAGE BUTTONS =============== //
            echo '<div class="buttons-div-second col-md-12 col-12 mt-1 flex-column justify-content-center align-items-center" style="display: none;" id="rdButton">';
                    echo '<div class="firstPage-button col-md-12 col-12 d-flex justify-content-center gap-1">';
                        echo '<button type="button" id="back" onclick="backrd()" class="border-0 p col-md-5 col-12">BACK</button>';
                    echo '</div>';
                echo '</div>';
            echo '</div>';

        echo '</div>';
       echo '<div id="loading-overlay" style="display:none;">';
            echo '<div class="loading-lines">';
                echo '<div class="line"></div>';
                echo '<div class="line"></div>';
                echo '<div class="line"></div>';
            echo '</div>';
        echo '</div>';
    echo '</main>';
}

// ====================== REGISTER AN EMPLOYEE(ADMIN) ====================== //
function registerEmployeeAdmin() {
    echo '<main class="main-container" style="height: 85%; width: 80%">';
       $csrf_token = $_SESSION['csrf_token'] ?? '';
       $signup_data = $_SESSION["user_signups"] ?? [];
       $errors = $_SESSION["signup_errors"] ?? [];
       
       unset($_SESSION["user_signups"]);
       unset($_SESSION["signup_errors"]);
       
        echo '<div class="column-container h-100 rounded-1 p-2 px-4" style="width: 50%">';
            echo '<div class="col-md-12">';
                echo '<div class="back-button w-100 mt-2">';
                    echo '<a href="employee.php" class="text-start "><i class="fa-solid fa-arrow-left-long fs-4"></i></a>';
                echo '</div>';
               echo '<form id="signupForm" novalidate action="../../auth/authentications.php" method="post" enctype="multipart/form-data"
                    class="form-signup w-100 overflow-y-auto" style="max-height: 72.5vh; overflow-y: auto;">';
                    echo '<input type="hidden" name="csrf_token" value="' . $csrf_token . '">';
                    echo '<input type="hidden" name="add_employee" value="true">';
                    // Display errors if they exist
                    if (!empty($errors)) {
                        echo '<div class="alert alert-danger">';
                        foreach ($errors as $error) {
                            echo '<p class="mb-1" style="color:#fff;">' . htmlspecialchars($error) . '</p>';
                        }
                        echo '</div>';
                    }
                    // ================= 1st step ============================ //
                    echo '<div class="form-group row w-100 ms-1" id="st-stepA">';
                        echo '<div class="stepper mb-1">';
                            echo '<div class="step active">1</div>';
                            echo '<div class="line"></div>';
                            echo '<div class="step">2</div>';
                            echo '<div class="line"></div>';
                            echo '<div class="step">3</div>';
                        echo '</div>';
                        echo '<div class="col-md-4 px-1 d-flex flex-column w-31">';
                            echo '<label for="surname" class="mb-0 text-start w-100" style="color:red; font-weight:400 !important;">Required</label>';
                            echo '<input type="text" name="lname" id="surname" class="form-control p-1 py-2 rounded-1" placeholder="Surname:" value="' . (isset($signup_data['lname']) ? htmlspecialchars($signup_data['lname']) : '') . '">';
                        echo '</div>';

                        echo '<div class="col-md-4 px-1 d-flex flex-column w-31">';
                            echo '<label for="fname" class="mb-0 text-start w-100" style="color:red; font-weight:400 !important;">Required</label>';
                            echo '<input type="text" name="fname" id="fname" class="form-control p-1 py-2 rounded-1" placeholder="First Name:" value="' . (isset($signup_data['fname']) ? htmlspecialchars($signup_data['fname']) : '') . '">';
                        echo '</div>';

                        echo '<div class="col-md-4 px-1 d-flex flex-column w-31">';
                            echo '<label for="mname" class="mb-0 text-start w-100" style="color:red; font-weight:400 !important;">Required</label>';
                            echo '<input type="text" name="mname" id="mname" class="form-control p-1 py-2 rounded-1" placeholder="Middle Name:" value="' . (isset($signup_data['mname']) ? htmlspecialchars($signup_data['mname']) : '') . '">';
                        echo '</div>';
                        echo '<div class="col-md-12 d-flex flex-wrap w-100 px-0 justify-content-center">';
                            echo '<div class="col-12 col-md-6 px-1">';
                                echo '<label for="Citizenship" class="mb-0" style="color:red; font-weight:400 !important;">Required</label>';
                                    echo '<select name="citizenship" id="Citizenship" class="form-select p-1 py-2 rounded-1">';
                                    echo '<option value="NO Citizenship"' . (isset($signup_data['citizenship']) && $signup_data['citizenship'] == 'NO Citizenship' ? ' selected' : '') . '>Select Citizenship</option>';
                                    echo '<option value="NATURAL-BORN"' . (isset($signup_data['citizenship']) && $signup_data['citizenship'] == 'NATURAL-BORN' ? ' selected' : '') . '>NATURAL-BORN</option>';
                                    echo '<option value="NATURALIZED"' . (isset($signup_data['citizenship']) && $signup_data['citizenship'] == 'NATURALIZED' ? ' selected' : '') . '>NATURALIZED</option>';
                                    echo '<option value="DUAL"' . (isset($signup_data['citizenship']) && $signup_data['citizenship'] == 'DUAL' ? ' selected' : '') . '>DUAL</option>';
                                    echo '<option value="BY ELECTION"' . (isset($signup_data['citizenship']) && $signup_data['citizenship'] == 'BY ELECTION' ? ' selected' : '') . '>BY ELECTION</option>';
                                echo '</select>';
                            echo '</div>';
                            echo '<div class="col-12 col-md-6 px-1">';
                                echo '<label for="gender" class="mb-0" style="color:red; font-weight:400 !important;">Required</label>';
                                echo '<select name="gender" id="gender" class="form-select p-1 py-2 rounded-1">';
                                    echo '<option value="NO GENDER"' . (isset($signup_data['gender']) && $signup_data['gender'] == 'NO GENDER' ? ' selected' : '') . '>Select Gender</option>';
                                    echo '<option value="MALE"' . (isset($signup_data['gender']) && $signup_data['gender'] == 'MALE' ? ' selected' : '') . '>MALE</option>';
                                    echo '<option value="FEMALE"' . (isset($signup_data['gender']) && $signup_data['gender'] == 'FEMALE' ? ' selected' : '') . '>FEMALE</option>';
                                echo '</select>';
                            echo '</div>';
                        echo '</div>';
                        echo '<div class="col-md-12 d-flex flex-wrap w-100 px-0 justify-content-center">';
                            echo '<div class="col-12 col-md-6 px-1">';
                                echo '<label for="mname" class="mb-0" style="color:red; font-weight:400 !important;">Required</label>';
                                echo '<select name="civil_status" id="civil_status" class="form-select p-1 py-2 rounded-1">';
                                    echo '<option value=""' . (!isset($signup_data['civil_status']) ? ' selected' : '') . '>Select Civil Status</option>';
                                    echo '<option value="Single"' . (isset($signup_data['civil_status']) && $signup_data['civil_status'] == 'Single' ? ' selected' : '') . '>Single</option>';
                                    echo '<option value="Married"' . (isset($signup_data['civil_status']) && $signup_data['civil_status'] == 'Married' ? ' selected' : '') . '>Married</option>';
                                    echo '<option value="Widowed"' . (isset($signup_data['civil_status']) && $signup_data['civil_status'] == 'Widowed' ? ' selected' : '') . '>Widowed</option>';
                                    echo '<option value="Divorced"' . (isset($signup_data['civil_status']) && $signup_data['civil_status'] == 'Divorced' ? ' selected' : '') . '>Divorced</option>';
                                echo '</select>';
                            echo '</div>';
                            echo '<div class="col-12 col-md-6 px-1">';
                                echo '<label for="fname" class="mb-0" style="color:#000; font-weight: 400 !important">Optional</label>';
                                echo '<select name="religion" id="religion" class="form-select p-1 py-2 rounded-1">';
                                    echo '<option value=""' . (!isset($signup_data['religion']) ? ' selected' : '') . '>Select Religion</option>';
                                    echo '<option value="Roman Catholic"' . (isset($signup_data['religion']) && $signup_data['religion'] == 'Roman Catholic' ? ' selected' : '') . '>Roman Catholic</option>';
                                    echo '<option value="Iglesia ni Cristo"' . (isset($signup_data['religion']) && $signup_data['religion'] == 'Iglesia ni Cristo' ? ' selected' : '') . '>Iglesia ni Cristo</option>';
                                    echo '<option value="Evangelical"' . (isset($signup_data['religion']) && $signup_data['religion'] == 'Evangelical' ? ' selected' : '') . '>Evangelical</option>';
                                    echo '<option value="Islam"' . (isset($signup_data['religion']) && $signup_data['religion'] == 'Islam' ? ' selected' : '') . '>Islam</option>';
                                    echo '<option value="Seventh-day Adventist"' . (isset($signup_data['religion']) && $signup_data['religion'] == 'Seventh-day Adventist' ? ' selected' : '') . '>Seventh-day Adventist</option>';
                                    echo '<option value="Jehovah\'s Witness"' . (isset($signup_data['religion']) && $signup_data['religion'] == 'Jehovah\'s Witness' ? ' selected' : '') . '>Jehovah\'s Witness</option>';
                                    echo '<option value="Buddhism"' . (isset($signup_data['religion']) && $signup_data['religion'] == 'Buddhism' ? ' selected' : '') . '>Buddhism</option>';
                                    echo '<option value="Hinduism"' . (isset($signup_data['religion']) && $signup_data['religion'] == 'Hinduism' ? ' selected' : '') . '>Hinduism</option>';
                                    echo '<option value="None"' . (isset($signup_data['religion']) && $signup_data['religion'] == 'None' ? ' selected' : '') . '>None</option>';
                                    echo '<option value="Other"' . (isset($signup_data['religion']) && $signup_data['religion'] == 'Other' ? ' selected' : '') . '>Other</option>';
                                echo '</select>';
                            echo '</div>';
                        echo '</div>';
                        echo '<div class="col-md-12 d-flex flex-wrap w-100 px-0 justify-content-center">';
                            echo '<div class="col-12 col-md-6 px-1">';
                                echo '<label for="age" class="mb-0" style="color:#000; font-weight: 400 !important">Optional</label>';
                                echo '<input type="text" name="age" id="age" class="form-control p-1 py-2 rounded-1" placeholder="Age:" value="' . (isset($signup_data['age']) ? htmlspecialchars($signup_data['age']) : '') . '">';
                            echo '</div>';
                            echo '<div class="col-12 col-md-6 px-1">';
                                echo '<label for="birthday" class="mb-0" style="color:red; font-weight:400 !important;">Required (Birthday)</label>';
                                echo '<input type="date" name="birthday" id="birthday" class="form-control p-1 py-2 rounded-1" placeholder="Birthday:" value="' . (isset($signup_data['birthday']) ? htmlspecialchars($signup_data['birthday']) : '') . '">';
                            echo '</div>';
                        echo '</div>';
                        echo '<div class="col-md-12 d-flex flex-wrap w-100 px-0 justify-content-center">';
                            echo '<div class="col-12 col-md-6 px-1">';
                                echo '<label for="birthPlace" class="mb-0" style="color:#000; font-weight: 400 !important">Optional</label>';
                                echo '<input type="text" name="birthPlace" id="birthPlace" class="form-control p-1 py-2 rounded-1" placeholder="Birth Place:" value="' . (isset($signup_data['birthPlace']) ? htmlspecialchars($signup_data['birthPlace']) : '') . '">';
                            echo '</div>';
                            echo '<div class="col-12 col-md-6 px-1">';
                                echo '<label for="contact" class="mb-0" style="color:red; font-weight:400 !important;">Required</label>';
                                echo '<input type="text" name="contact" id="contact" class="form-control p-1 py-2 rounded-1" placeholder="Contact Number:" value="' . (isset($signup_data['contact']) ? htmlspecialchars($signup_data['contact']) : '') . '">';
                            echo '</div>';
                        echo '</div>';
                        echo '<div class="col-md-12 d-flex flex-wrap w-100 px-0 justify-content-center">';
                             echo '<div class="col-12 col-md-6 px-1">';
                                echo '<label for="email" class="mb-0" style="color:red; font-weight:400 !important;">Required</label>';
                                echo '<input type="text" name="email" id="email" class="form-control p-1 py-2 rounded-1" placeholder="E-mail:" value="' . (isset($signup_data['email']) ? htmlspecialchars($signup_data['email']) : '') . '">';
                            echo '</div>';
                            echo '<div class="col-12 col-md-6 px-1">';
                                echo '<label for="Slary_rate" class="mb-0" style="color:red; font-weight:400 !important;">Required</label>';
                                echo '<select name="slary_rate" id="Slary_rate" class="form-select p-1 py-2 rounded-1">';
                                    echo '<option value="NO SALARY RATE"' . (isset($signup_data['slary_rate']) && $signup_data['slary_rate'] == 'NO DALARY RATE' ? ' selected' : '') . '>Select Slary Rate</option>';
                                    echo '<option value="MONTHLY"' . (isset($signup_data['slary_rate']) && $signup_data['slary_rate'] == 'MONTHLY' ? ' selected' : '') . '>MONTHLY</option>';
                                    echo '<option value="DAILY"' . (isset($signup_data['slary_rate']) && $signup_data['slary_rate'] == 'DAILY' ? ' selected' : '') . '>DAILY</option>';
                                    echo '<option value="HOURLY"' . (isset($signup_data['slary_rate']) && $signup_data['slary_rate'] == 'HOURLY' ? ' selected' : '') . '>HOURLY</option>';
                                echo '</select>';
                            echo '</div>';
                        echo '</div>';
                        echo '<div class="col-md-12 d-flex flex-wrap w-100 px-0 justify-content-center">';
                            echo '<div class="col-12 col-md-6 px-1">';
                                echo '<label for="salary_Range_From" class="mb-0" style="color:red; font-weight:400 !important;">Required</label>';
                                echo '<input type="number" name="salary_Range_From" id="salary_Range_From" class="form-control p-1 py-2 rounded-1" placeholder="Salary Range From:" value="' . (isset($signup_data['salary_Range_From']) ? $signup_data['salary_Range_From'] : '') . '">';
                            echo '</div>';

                            echo '<div class="col-12 col-md-6 px-1">';
                                echo '<label for="salary_Range_To" class="mb-0" style="color:red; font-weight:400 !important;">Required</label>';
                                echo '<input type="number" name="salary_Range_To" id="salary_Range_To" class="form-control p-1 py-2 rounded-1" placeholder="Salary Range To:" value="' . (isset($signup_data['salary_Range_To']) ? $signup_data['salary_Range_To'] : '') . '">';
                            echo '</div>';
                        echo '</div>';
                    echo '</div>';
                    // ================= 2nd step ============================ //
                    echo '<div class="form-group row w-100 ms-1 mb-4" id="nd-stepA" style="display: none;">';
                        echo '<div class="stepper mb-2">';
                            echo '<div class="step">1</div>';
                            echo '<div class="line"></div>';
                            echo '<div class="step active">2</div>';
                            echo '<div class="line"></div>';
                            echo '<div class="step">3</div>';
                        echo '</div>';
                    echo '<div class="col-md-12 d-flex flex-wrap w-100 px-0 justify-content-center">';
                            echo '<div class="col-12 col-md-6 px-1">';
                                echo '<label for="employeeID" class="mb-0" style="color:red; font-weight:400 !important;">Required</label>';
                                echo '<input type="text" name="employeeID" id="employeeID" class="form-control p-1 py-2 rounded-1" placeholder="Employee ID:" value="' . (isset($signup_data['employeeID']) ? htmlspecialchars($signup_data['employeeID']) : '') . '">';
                            echo '</div>';

                            echo '<div class="col-12 col-md-6 px-1">';
                                echo '<label for="mname" class="mb-0" style="color:red; font-weight:400 !important;">Required</label>';
                                echo '<select name="department" id="Department" class="form-select p-1 py-2 rounded-1" >';
                                    echo '<option value="NO DEPARTMENT"' . (isset($signup_data['department']) && $signup_data['department'] == 'NO DEPARTMENT' ? ' selected' : '') . '>Select Department</option>';
                                    echo '<option value="HOSPITAL"' . (isset($signup_data['department']) && $signup_data['department'] == 'HOSPITAL' ? ' selected' : '') . '>HOSPITAL</option>';
                                    echo '<option value="SCHOOL"' . (isset($signup_data['department']) && $signup_data['department'] == 'SCHOOL' ? ' selected' : '') . '>SCHOOL</option>';
                                echo '</select>';
                            echo '</div>';
                        echo '</div>';
                        echo '<div class="col-md-12 d-flex flex-wrap w-100 px-0 justify-content-center">';
                            echo '<div class="col-12 col-md-6 px-1">';
                                echo '<label for="jobTitle" class="mb-0" style="color:red; font-weight:400 !important;">Required</label>';
                                echo '<select name="jobTitle" id="Job_Title" class="form-select p-1 py-2 rounded-1">';
                                    echo '<option value="">Select Job Title</option>';
                                    if (isset($signup_data['jobTitle'])) {
                                        echo '<option value="' . htmlspecialchars($signup_data['jobTitle']) . '" selected hidden>' . htmlspecialchars($signup_data['jobTitle']) . '</option>';
                                    }
                                echo '</select>';
                            echo '</div>';
                            echo '<div class="col-12 col-md-6 px-1">';
                                echo '<label for="salary" class="mb-0" style="color:red; font-weight:400 !important;">Required</label>';
                                echo '<input type="number" name="salary" id="salary" class="form-control p-1 py-2 rounded-1" placeholder="Official Salary:" value="' . (isset($signup_data['salary']) ? $signup_data['salary'] : '') . '">';
                            echo '</div>';
                        echo '</div>';
                        echo '<div class="col-md-12 d-flex flex-wrap w-100 px-0 justify-content-center">';
                            echo '<div class="col-12 col-md-6 px-1">';
                                echo '<label for="scheduleFrom" class="mb-0" style="color:red; font-weight:400 !important;">Required (Schedule From)</label>';
                                echo '<select name="scheduleFrom" id="scheduleFrom" class="form-select p-1 py-2 rounded-1">';
                                    echo '<option value="">Select Schedule From</option>';
                                echo '</select>';
                            echo '</div>';

                            echo '<div class="col-12 col-md-6 px-1">';
                                echo '<label for="scheduleTo" class="mb-0" style="color:red; font-weight:400 !important;">Required (Schedule To)</label>';
                                echo '<select name="scheduleTo" id="scheduleTo" class="form-select p-1 py-2 rounded-1">';
                                    echo '<option value="">Select Schedule To</option>';
                                echo '</select>';
                            echo '</div>';
                        echo '</div>';
                        echo '<div class="col-md-12 d-flex flex-wrap w-100 px-0 justify-content-center">';
                            echo '<h3 class="w-100 text-start fs-4 my-1 mt-3">ADDRESS</h3>';
                        echo '</div>';
                        echo '<div class="row w-100 px-0 d-flex flex-row flex-wrap justify-content-center">';
                            echo '<div class="col-12 col-md-4 px-1">';
                                echo '<label for="houseBlock" class="mb-0 text-start w-100" style="color:#000; font-weight: 400 !important">Optional</label>';
                                echo '<input type="text" name="houseBlock" id="houseBlock" class="form-control p-1 py-2 rounded-1" placeholder="House Block:" value="' . (isset($signup_data['houseBlock']) ? htmlspecialchars($signup_data['houseBlock']) : '') . '">';
                            echo '</div>';

                            echo '<div class="col-12 col-md-4 px-1">';
                                echo '<label for="street" class="mb-0 text-start w-100" style="color:red; font-weight:400 !important;">Required</label>';
                                echo '<input type="text" name="street" id="street" class="form-control p-1 py-2 rounded-1" placeholder="Street:" value="' . (isset($signup_data['street']) ? htmlspecialchars($signup_data['street']) : '') . '">';
                            echo '</div>';

                            echo '<div class="col-12 col-md-4 px-1">';
                                echo '<label for="Subdivision" class="mb-0 text-start w-100" style="color:#000; font-weight: 400 !important">Optional</label>';
                                echo '<input type="text" name="subdivision" id="Subdivision" class="form-control p-1 py-2 rounded-1" placeholder="Subdivision:" value="' . (isset($signup_data['subdivision']) ? htmlspecialchars($signup_data['subdivision']) : '') . '">';
                            echo '</div>';
                        echo '</div>';
                        echo '<div class="col-md-12 d-flex flex-wrap w-100 px-0 justify-content-center">';
                            echo '<div class="col-12 col-md-6 px-1">';
                                echo '<label for="Brangay" class="mb-0" style="color:red; font-weight:400 !important;">Required</label>';
                                echo '<input type="text" name="barangay" id="Brangay" class="form-control p-1 py-2 rounded-1" placeholder="Brangay:" value="' . (isset($signup_data['barangay']) ? htmlspecialchars($signup_data['barangay']) : '') . '">';
                            echo '</div>';

                            echo '<div class="col-12 col-md-6 px-1">';
                                echo '<label for="city_muntinlupa" class="mb-0" style="color:red; font-weight:400 !important;">Required</label>';
                                echo '<input type="text" name="city_muntinlupa" id="city_muntinlupa" class="form-control p-1 py-2 rounded-1" placeholder="City Muntinlupa:" value="' . (isset($signup_data['city_muntinlupa']) ? htmlspecialchars($signup_data['city_muntinlupa']) : '') . '">';
                            echo '</div>';
                        echo '</div>';
                        echo '<div class="col-md-12 d-flex flex-wrap w-100 px-0 justify-content-center">';
                            echo '<div class="col-12 col-md-6 px-1">';
                                echo '<label for="province" class="mb-0" style="color:red; font-weight:400 !important;">Required</label>';
                                echo '<input type="text" name="province" id="province" class="form-control p-1 py-2 rounded-1" placeholder="Province:" value="' . (isset($signup_data['province']) ? htmlspecialchars($signup_data['province']) : '') . '">';
                            echo '</div>';

                            echo '<div class="col-12 col-md-6 px-1">';
                                echo '<label for="zipCode" class="mb-0" style="color:red; font-weight:400 !important;">Required</label>';
                                echo '<input type="text" name="zipCode" id="zipCode" class="form-control p-1 py-2 rounded-1" placeholder="Zip Code:" value="' . (isset($signup_data['zipCode']) ? htmlspecialchars($signup_data['zipCode']) : '') . '">';
                            echo '</div>';
                        echo '</div>';
                    echo '</div>';
                    // ================= 3rd step ============================ //
                    echo '<div class="form-group row w-100 ms-1 mb-5" id="rd-stepA" style="display: none;">';
                        echo '<div class="stepper">';
                            echo '<div class="step">1</div>';
                            echo '<div class="line"></div>';
                            echo '<div class="step">2</div>';
                            echo '<div class="line"></div>';
                            echo '<div class="step active">3</div>';
                        echo '</div>';
                        echo '<div class="form-group col-md-12 d-flex flex-column justify-content-center align-items-center w-100 m-0" id="image">';
                            echo '<label for="profile" class="mt-3"><img src="../../assets/image/users.png" class="rounded-5 m-0" style="width: 200px; height: 200px;" id="imageIDAdmin"></label>';
                            echo '<input type="file" name="user_profile" style="display: none;" id="profile" onchange="previewImage(event)">';
                            echo '<p class="mb-3">Profile Picture</p>';
                        echo  '</div>';
                        echo '<div class="col-md-12 w-100 d-flex flex-column px-0">';
                            echo '<div class="col-md-4 px-1 w-100">';
                                echo '<label for="username" class="mb-0" style="color:red; font-weight:400 !important;">Required</label>';
                                echo '<input type="text" name="username" id="username" class="form-control p-1 mb-2 py-2 rounded-1" placeholder="Username:" value="' . (isset($signup_data['username']) ? htmlspecialchars($signup_data['username']) : '') . '">';
                            echo '</div>';

                            echo '<div class="col-md-4 d-flex flex-row px-1 w-100 position-relative">'; 
                                echo '<li class="li-div w-100" style="display: flex; flex-direction: column; list-style-type: none; align-items: center; position: relative;">'; 
                                    echo '<input type="password" class="form-control rounded-1 mb-2 pe-4" name="password" placeholder="Password" required id="passwordInputAdmin" style="flex: 1;" value="' . (isset($signup_data['password']) ? htmlspecialchars($signup_data['password']) : '') . '">';

                                    echo '<button type="button" id="showPasswordAdmin" style="background: none; border: none; position: absolute; right: 1.5rem; top: 50%; transform: translateY(-50%);">';
                                        echo '<i class="fa-solid fa-eye"></i>';
                                    echo '</button>';

                                    echo '<button type="button" id="hidePasswordAdmin" style="background: none; border: none; position: absolute; right: 1.5rem; top: 50%; transform: translateY(-50%); display: none;">';
                                        echo '<i class="fa-solid fa-eye-slash"></i>';
                                    echo '</button>';
                                echo '</li>';
                            echo '</div>';

                            echo '<div class="col-md-4 d-flex flex-row px-1 w-100 position-relative">'; 
                                echo '<li class="li-div w-100" style="display: flex; flex-direction: column; list-style-type: none; align-items: center; position: relative;">'; 
                                    echo '<input type="password" class="form-control rounded-1 pe-4" name="confirmPassword" placeholder="Confirm Password" required id="confirmPasswordInputAdmin" style="flex: 1;" value="' . (isset($signup_data['confirmPassword']) ? htmlspecialchars($signup_data['confirmPassword']) : '') . '">';

                                    echo '<button type="button" id="showConfirmPasswordAdmin" style="background: none; border: none; position: absolute; right: 1.5rem; top: 50%; transform: translateY(-50%);">';
                                        echo '<i class="fa-solid fa-eye"></i>';
                                    echo '</button>';

                                    echo '<button type="button" id="hideConfirmPasswordAdmin" style="background: none; border: none; position: absolute; right: 1.5rem; top: 50%; transform: translateY(-50%); display: none;">';
                                        echo '<i class="fa-solid fa-eye-slash"></i>';
                                    echo '</button>';
                                echo '</li>';
                            echo '</div>';

                        echo '</div>';
                    echo '</div>';
                    echo '<div class="col-md-12 w-100 ms-2" mb-1 style="height: 35px; display: flex;"  id="button-signupA">';
                        // echo '<button class="w-100 border-0 mb-1 px-1 text-center" style="height: 100%;" onclick="disable_Button()" id="backs">Sign-up</button>';
                    echo '</div>';
                    echo '<div class="col-md-12 w-100 ms-2" mb-1 style="height: 35px; display: none; margin-top: -1.5rem"  id="button-signup-rdA">';
                        echo '<button class="w-100 border-0 mb-1 px-1 text-center" type="submit" style="height: 100%;" id="button-signup-rds">Sign-up</button>';
                    echo '</div>';
                echo '</form>';
            //====================== FIRST PAGE BUTTONS =============== //
            echo '<div class="buttons-div ms-2 col-md-12 mt-1 w=100 flex-column justify-content-center align-items-center" id="stButtonA">';
                echo '<div class="firstPage-button col-md-6 w-100 justify-content-center gap-1" id="stButton" style="display: flex;">';
                    echo '<button type="button" id="backsA" onclick="backstA()" class="border-0 p-0 py-1" style="width: 49.1%; margin-left: -.5rem">BACK</button>';
                    echo '<button type="button" id="next" onclick="nextstA()" class="border-0 p-0 py-1" style="width: 49.1%;">NEXT</button>';
                echo '</div>';
            echo '</div>';
            //====================== SECOND PAGE BUTTONS =============== //
            echo '<div class="buttons-div-second ms-2 col-md-12 mt-1 w-100 flex-column justify-content-center align-items-center" style="display: none;" id="ndBUttonA">';
                    echo '<div class="firstPage-button col-md-6 w-100 justify-content-center gap-1" id="ndButton" style="display: flex;">';
                        echo '<button type="button" id="back" onclick="backndA()" class="border-0 p-0 py-1" style="width: 49.1%; margin-left: -.5rem">BACK</button>';
                        echo '<button type="button" id="next" onclick="nextndA()" class="border-0 p-0 py-1" style="width: 49.1%;">NEXT</button>';
                    echo '</div>';
                echo '</div>';
            echo '</div>';
            //====================== THIRD PAGE BUTTONS =============== //
            echo '<div class="buttons-div-second ms-2 col-md-12 mt-1 w-100 flex-column justify-content-center align-items-center" style="display: none;" id="rdButtonA">';
                    echo '<div class="firstPage-button col-md-6 w-100 d-flex justify-content-center gap-1">';
                        echo '<button type="button" id="back" onclick="backrdA()" class="border-0 p-0 py-1" style="width: 49.1%; margin-left: -.5rem">BACK</button>';
                        echo '<button type="button" id="nexts" onclick="nextrdA()" class="border-0 p-0 py-1" style="width: 49.1%;">NEXT</button>';
                    echo '</div>';
                echo '</div>';
            echo '</div>';

        echo '</div>';
       echo '<div id="loading-overlay" style="display:none;">';
            echo '<div class="loading-lines">';
                echo '<div class="line"></div>';
                echo '<div class="line"></div>';
                echo '<div class="line"></div>';
            echo '</div>';
        echo '</div>';
    echo '</main>';
}

function errors_installation(){
    if(isset($_SESSION['installation_error'])){
        $error = $_SESSION['installation_error'];
    }
}

function loginErros(){
    if(isset($_SESSION['errors_login'])){
        $errors = $_SESSION['errors_login'];
        foreach($errors as $error){
            echo '<div class="login-errors w-100 h-25 m-0">';
                echo '<p class="text-start ml-1 mt-2 mb-0" style="color: red;">* ' . $error . '... Please Try Again!</p>';
            echo '</div>';
        }
    }
    unset($_SESSION['errors_login']);
}