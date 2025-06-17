<?php include '../../templates/Uheader.php'; include '../../templates/adminAuth.php';?>
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
                <a href="../logout.php"><i class="fa-solid fa-right-from-bracket ms-3"></i></a>
                <a href="profile.php" class="align-items-center m-0" style="text-decoration: none; color: #000;" type="button" onclick="userButton()">
                    <img src="../../assets/image/upload/<?php echo htmlspecialchars($employeeInfo["user_profile"]) ?>" class="rounded-circle me-0 ms-4" style="height: 35px; width: 35px;">
                    <span class="fw-bold"><?php echo isset($employeeInfo["lname"]) ? htmlspecialchars($employeeInfo["lname"]) . ", " . htmlspecialchars($employeeInfo["fname"]) : "N/A" ?></span>
                </a>
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
                        <li class="my-1"><a href="leave.php"  class="d-flex justify-content-start"><i class="fa-solid me-1 d-flex align-items-center fa-file-export"></i><p style="display:flex;" id="pNone" class="text-start">LEAVE REQUEST</p></a></li>
                    </ul>

                    <li class="payrollLi d-flex align-items-center p-2 mb-2">
                        <button type="button" onclick="payrollButton()" class="p-0 m-0 w-100 h-100 d-flex align-items-center">
                            <i id="payrolli" class="fa-solid me-2 fa-peso-sign"></i>
                            <p class="text-start side-text" id="ppr">Payroll Management</p>
                            <i id="iLeftArrowPr" class="fa-solid fa-chevron-left" style="display:none;"></i>
                        </button>
                    </li>

                    <ul id="payrollUl" class="flex-column" style="display:none;">
                        <li class="my-1"><a href="employee.php"><i class="fa-solid me-1 fa-users-gear"></i>RECRUITMENTS</a></li>
                        <li class="my-1"><a href="leave.php"><i class="fa-solid me-1 fa-file-export"></i>LEAVE REQUEST</a></li>
                        <li class="my-1"><a href="job.php"><i class="fa-solid me-1 fa-briefcase"></i>JOB TITLES</a></li>
                    </ul>

                    <li class="attendanceLi d-flex align-items-center p-2 mb-2">
                        <a href="#" class="p-0 m-0 w-100 h-100 d-flex align-items-center">
                            <i class="fa-solid me-2 fa-clock"></i>
                            <p class="text-start side-text" id="pa">Attendance</p>
                        </a>
                    </li>

                    <li class="settingsLi d-flex align-items-center p-2 mb-2">
                        <a href="#" class="p-0 m-0 w-100 h-100 d-flex align-items-center">
                            <i class="fa-solid me-2 fa-gear"></i>
                            <p class="text-start side-text" id="ps">Settings</p>
                        </a>
                    </li>
                </div>
                
            </div>
            <div class="contents w-100 h-100 d-flex flex-column align-items-center p-0 m-0">
                <div class="header-employee d-flex flex-row justify-content-between align-items-center" style="min-height: 2rem; min-width: 95%;">
                    <div class="h1">
                        <h3 class="m-0">EMPLOYEE PROFILE</h3>
                    </div>
                    <div class="navigations">
                        <button type="button" id="Personal" onclick="activateTab(this); personalInfo()" class="tab-btn active">Personal Information</button>
                        <button type="button" id="Family" onclick="activateTab(this); familyBG()" class="tab-btn">Family Background</button>
                        <button type="button" id="Educational" onclick="activateTab(this); educationalBG()" class="tab-btn">Educational Background</button>
                    </div>

                    <div class="buttonUpdate">
                       <button type="button" id="updateButton" class="btn" data-bs-toggle="modal" data-bs-target="#updateModal">
                            Update
                        </button>
                        <button type="button" id="updateButtonFBG" class="btn" data-bs-toggle="modal" data-bs-target="#updateModalFBG">
                            Update
                        </button>
                        <button type="button" id="updateButtonEBG" class="btn" data-bs-toggle="modal" data-bs-target="#updateModalEBG">
                            Update
                        </button>
                    </div>
                </div>
                <!-- ============================ PERSONAL INFO TAB ============================ -->
                <div class="employeeReqProfileINfo d-flex flex-column justify-content-between p-0 m-0 mt-3" style="width: 95%; min-height: 78vh;">
                    <div class="row h-100 w-100" id="personalID" style="display: flex;">
                        <form action="../../auth/authentications.php" method="post" enctype="multipart/form-data" class="w-100 p-0 h-100 d-flex flex-row flex-wrap">
                            <div class="profileSide col-12 col-md-3 flex-column me-md-2 justify-content-start align-items-center rounded-1 mb-1 mb-md-0" id="personalProfileInformation" style="height: 80%; display: none;">
                                    <input type="hidden" name="users_id" value="<?= $employeeInfo["users_id"] ?>">
                                    <?php isset($_SESSION["csrf_token"]) && $_SESSION["csrf_token"] !== "" ? $csrf = $_SESSION["csrf_token"] : " null "; ?>
                                    <input type="hidden" name="csrf_token" value="<?php echo $csrf; ?>">
                                    <input type="hidden" name="userUpdateProfile" value="true">
                                    <div class="profilePict w-100 mt-2 d-flex justify-content-center align-items-center h-50">
                                        <img src="../../assets/image/upload/<?= isset($employeeInfo["user_profile"]) ? htmlspecialchars($employeeInfo["user_profile"]) : "N/A" ?>" alt="Profile Picture" class="img-fluid rounded-circle">
                                    </div>
                                    <div class="profileInfo mt-2 w-100 d-flex flex-column align-items-center justify-content-start">
                                        <h5 class="fs-6 fw-bold"><?= isset($employeeInfo["employeeID"]) ? htmlspecialchars($employeeInfo["employeeID"]) : "N/A" ?></h5>
                                        <h5 class="text-center fs-6 fw-bold"><?= isset($employeeInfo["lname"]) ? htmlspecialchars($employeeInfo["lname"]) : "N/A" ?>, <?= isset($employeeInfo["fname"]) ? htmlspecialchars($employeeInfo["fname"]) : "N/A" ?> <?= isset($employeeInfo["mname"]) ? htmlspecialchars($employeeInfo["mname"]) : "N/A" ?></h5>
                                        <h5 class="fs-6 fw-bold"><?= isset($employeeInfo["jobTitle"]) ? htmlspecialchars($employeeInfo["jobTitle"]) : "N/A" ?></h5>
                                        <h5 class="fs-6 fw-bold"><?= htmlspecialchars($employeeInfo["department"] ?? "N/A") ?> DEPARTMENT</h5>
                                        <h5 class="fs-6 fw-bold"><?= "Status: " . htmlspecialchars($employeeInfo["status"]) ?></h5>
                                    </div>
                            </div>
                            <div class="informationSide col-12 col-md-8 d-flex px-4 flex-row flex-wrap rounded-1 justify-content-start align-items-start" id="personalInformation" style="height: 100%; display: flex;">
                                <div class="card mb-4 shadow-sm border-0 w-100">
                                        <div class="card-body">
                                            <h4 class="card-title text-primary fw-bold mb-4 px-3">EMPLOYEE INFORMATIONS</h4>    
                                        <div class="profileID row w-100">
                                            <div class="col-md-8">
                                                <label for="user_profile" class="fw-bold">Profile</label>
                                                <input type="file" name="user_profile" class="form-control" id="user_profile">
                                                <input type="hidden" name="current_profile_image" value="<?= htmlspecialchars($employeeInfo["user_profile"]) ?>">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="employeeID" class="fw-bold">Employee ID</label>
                                                <input type="text" name="employeeID" class="form-control" id="employeeID" value="<?= isset($employeeInfo["employeeID"]) ? htmlspecialchars($employeeInfo["employeeID"]) : "N/A" ?>">
                                            </div>
                                        </div>
                                        <div class="inputInfo my-2 row w-100">
                                            <div class="col-md-3">
                                                <label for="lname" class="fw-bold">Surname</label>
                                                <input type="text" name="lname" class="form-control" id="lname" value="<?= isset($employeeInfo["lname"]) ? htmlspecialchars($employeeInfo["lname"]) : "N/A" ?>">
                                            </div>
                                            <div class="col-md-3">
                                                <label for="fname" class="fw-bold">First Name</label>
                                                <input type="text" name="fname" class="form-control" id="fname" value="<?= isset($employeeInfo["fname"]) ? htmlspecialchars($employeeInfo["fname"]) : "N/A" ?>">
                                            </div>
                                            <div class="col-md-3">
                                                <label for="mname" class="fw-bold">Middle Name</label>
                                                <input type="text" name="mname" class="form-control" id="mname" value="<?= isset($employeeInfo["mname"]) ? htmlspecialchars($employeeInfo["mname"]) : "N/A" ?>">
                                            </div>
                                            <div class="col-md-3">
                                                <label for="suffix" class="fw-bold">Suffix</label>
                                                <select name="suffix" class="form-select rounded-1 p-1 py-2" id="suffix">
                                                    <?php
                                                    $suffixes = ["N/A", "Jr.", "Sr.", "II", "III", "IV"];
                                                    $selected_suffix = isset($employeeInfo["suffix"]) ? $employeeInfo["suffix"] : "N/A";
                                                    foreach ($suffixes as $suffix) {
                                                        $selected = ($suffix === $selected_suffix) ? "selected" : "";
                                                        echo "<option value=\"" . htmlspecialchars($suffix) . "\" $selected>" . htmlspecialchars($suffix) . "</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="inputInfo my-2 row w-100">
                                            <div class="col-md-4">
                                                <label for="JobTitle" class="fw-bold">Job Title</label>
                                                <select name="jobTitle" class="form-select rounded-1 p-1 py-2" id="Job_Title">
                                                    <option value="">Loading...</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="department" class="fw-bold">Department</label>
                                                <select name="department" class="form-select rounded-1 p-1 py-2" id="department">
                                                    <option value="Hospital" <?= (isset($employeeInfo["department"]) && $employeeInfo["department"] === "Hospital") ? "selected" : "" ?>>Hospital</option>
                                                    <option value="School" <?= (isset($employeeInfo["department"]) && $employeeInfo["department"] === "School") ? "selected" : "" ?>>School</option>
                                                </select>
                                            </div>

                                            <div class="col-md-4">
                                                <label for="salaryRate" class="fw-bold">Salary Rate</label>
                                                <select name="salary_rate" id="salaryRate" class="form-select p-1 py-2 rounded-1">
                                                    <option value="NO DALARY RATE" <?= (isset($employeeInfo['slary_rate']) && $employeeInfo['slary_rate'] === 'NO DALARY RATE') ? 'selected' : '' ?>>Select Slary Rate</option>
                                                    <option value="MONTHLY" <?= (isset($employeeInfo['slary_rate']) && $employeeInfo['slary_rate'] === 'MONTHLY') ? 'selected' : '' ?>>MONTHLY</option>
                                                    <option value="DAILY" <?= (isset($employeeInfo['slary_rate']) && $employeeInfo['slary_rate'] === 'DAILY') ? 'selected' : '' ?>>DAILY</option>
                                                    <option value="HOURLY" <?= (isset($employeeInfo['slary_rate']) && $employeeInfo['slary_rate'] === 'HOURLY') ? 'selected' : '' ?>>HOURLY</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="inputInfo my-2 row w-100">
                                            <div class="col-md-4">
                                                <label for="salary" class="fw-bold">Salary</label>
                                                <input type="number" name="salary" class="form-control" id="salary" value="<?= isset($employeeInfo["salary"]) ? htmlspecialchars($employeeInfo["salary"]) : "N/A" ?>">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="from" class="fw-bold">Salary Range From</label>
                                                <input type="number" name="salary_Range_From" class="form-control" id="from" value="<?= isset($employeeInfo["salary_Range_From"]) ? htmlspecialchars($employeeInfo["salary_Range_From"]) : "N/A" ?>">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="to" class="fw-bold">Salary Range To</label>
                                                <input type="number" name="salary_Range_To" class="form-control" id="to" value="<?= isset($employeeInfo["salary_Range_To"]) ? htmlspecialchars($employeeInfo["salary_Range_To"]) : "N/A" ?>">
                                            </div>
                                        </div>
                                        <div class="inputInfo my-2 row w-100">
                                            <div class="col-md-4">
                                                <label for="Citizenship" class="fw-bold">Citizenship</label>
                                                <select name="citizenship" id="Citizenship" class="form-select p-1 py-2 rounded-1">
                                                    <option value="NO Citizanship" <?= (isset($employeeInfo['citizenship']) && $employeeInfo['citizenship'] === 'NO Citizanship') ? 'selected' : '' ?>>Select Citizanship</option>
                                                    <option value="NATURAL-BORN" <?= (isset($employeeInfo['citizenship']) && $employeeInfo['citizenship'] === 'NATURAL-BORN') ? 'selected' : '' ?>>NATURAL-BORN</option>
                                                    <option value="NATURALIZED" <?= (isset($employeeInfo['citizenship']) && $employeeInfo['citizenship'] === 'NATURALIZED') ? 'selected' : '' ?>>NATURALIZED</option>
                                                    <option value="DUAL" <?= (isset($employeeInfo['citizenship']) && $employeeInfo['citizenship'] === 'DUAL') ? 'selected' : '' ?>>DUAL</option>
                                                    <option value="BY ELECTION" <?= (isset($employeeInfo['citizenship']) && $employeeInfo['citizenship'] === 'BY ELECTION') ? 'selected' : '' ?>>BY ELECTION</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="Gender" class="fw-bold">Gender</label>
                                                <select name="gender" id="Gender" class="form-select">
                                                    <option value="">Select Gender</option>
                                                    <option value="Male" <?= (isset($employeeInfo['gender']) && strcasecmp(trim($employeeInfo['gender']), 'Male') === 0) ? 'selected' : '' ?>>Male</option>
                                                    <option value="Female" <?= (isset($employeeInfo['gender']) && strcasecmp(trim($employeeInfo['gender']), 'Female') === 0) ? 'selected' : '' ?>>Female</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="civil_status" class="fw-bold">Civil Status</label>
                                                <select name="civil_status" id="civil_status" class="form-select p-1 py-2 rounded-1">
                                                    <option value="" <?= !isset($employeeInfo['civil_status']) || $employeeInfo['civil_status'] === '' ? 'selected' : '' ?>>Select Civil Status</option>
                                                    <option value="Single" <?= (isset($employeeInfo['civil_status']) && $employeeInfo['civil_status'] === 'Single') ? 'selected' : '' ?>>Single</option>
                                                    <option value="Married" <?= (isset($employeeInfo['civil_status']) && $employeeInfo['civil_status'] === 'Married') ? 'selected' : '' ?>>Married</option>
                                                    <option value="Widowed" <?= (isset($employeeInfo['civil_status']) && $employeeInfo['civil_status'] === 'Widowed') ? 'selected' : '' ?>>Widowed</option>
                                                    <option value="Divorced" <?= (isset($employeeInfo['civil_status']) && $employeeInfo['civil_status'] === 'Divorced') ? 'selected' : '' ?>>Divorced</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="inputInfo my-2 row w-100">
                                            <div class="col-md-4">
                                                <label for="religion" class="fw-bold">Religion</label>
                                                <select name="religion" id="religion" class="form-select p-1 py-2 rounded-1">
                                                    <option value="" <?= !isset($employeeInfo['religion']) || $employeeInfo['religion'] === '' ? 'selected' : '' ?>>Select Religion</option>
                                                    <option value="Roman Catholic" <?= (isset($employeeInfo['religion']) && $employeeInfo['religion'] === 'Roman Catholic') ? 'selected' : '' ?>>Roman Catholic</option>
                                                    <option value="Iglesia ni Cristo" <?= (isset($employeeInfo['religion']) && $employeeInfo['religion'] === 'Iglesia ni Cristo') ? 'selected' : '' ?>>Iglesia ni Cristo</option>
                                                    <option value="Evangelical" <?= (isset($employeeInfo['religion']) && $employeeInfo['religion'] === 'Evangelical') ? 'selected' : '' ?>>Evangelical</option>
                                                    <option value="Islam" <?= (isset($employeeInfo['religion']) && $employeeInfo['religion'] === 'Islam') ? 'selected' : '' ?>>Islam</option>
                                                    <option value="Seventh-day Adventist" <?= (isset($employeeInfo['religion']) && $employeeInfo['religion'] === 'Seventh-day Adventist') ? 'selected' : '' ?>>Seventh-day Adventist</option>
                                                    <option value="Jehovah's Witness" <?= (isset($employeeInfo['religion']) && $employeeInfo['religion'] === "Jehovah's Witness") ? 'selected' : '' ?>>Jehovah's Witness</option>
                                                    <option value="Buddhism" <?= (isset($employeeInfo['religion']) && $employeeInfo['religion'] === 'Buddhism') ? 'selected' : '' ?>>Buddhism</option>
                                                    <option value="Hinduism" <?= (isset($employeeInfo['religion']) && $employeeInfo['religion'] === 'Hinduism') ? 'selected' : '' ?>>Hinduism</option>
                                                    <option value="None" <?= (isset($employeeInfo['religion']) && $employeeInfo['religion'] === 'None') ? 'selected' : '' ?>>None</option>
                                                    <option value="Other" <?= (isset($employeeInfo['religion']) && $employeeInfo['religion'] === 'Other') ? 'selected' : '' ?>>Other</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="age" class="fw-bold">Age</label>
                                                <input type="text" name="age" class="form-control" id="age" value="<?= (isset($employeeInfo["age"]) && trim($employeeInfo["houseBlock"]) !== '') ? htmlspecialchars($employeeInfo["age"]) : "N/A" ?>">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="Birthday" class="fw-bold">Birthday</label>
                                                <input type="date" name="birthday" class="form-control" id="Birthday" value="<?= isset($employeeInfo["birthday"]) ? htmlspecialchars($employeeInfo["birthday"]) : "N/A" ?>">
                                            </div>
                                        </div>
                                        <div class="row my-2 employeeInfo w-100">
                                            <div class="col-md-4">
                                                <label for="BirthPlace" class="fw-bold">Birth Place</label>
                                                <input type="text" name="birthPlace" class="form-control" id="BirthPlace" value="<?= isset($employeeInfo["birthPlace"]) ? htmlspecialchars($employeeInfo["birthPlace"]) : "N/A" ?>">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="Contact" class="fw-bold">Contact</label>
                                                <input type="text" name="contact" class="form-control" id="Contact" value="<?= isset($employeeInfo["contact"]) ? htmlspecialchars($employeeInfo["contact"]) : "N/A" ?>">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="Email" class="fw-bold">Email</label>
                                                <input type="text" name="email" class="form-control" id="Email" value="<?= isset($employeeInfo["email"]) ? htmlspecialchars($employeeInfo["email"]) : "N/A" ?>">
                                            </div>
                                        </div>
                                        <div class="row my-2 p-2 employeeInfo w-100">
                                            <?php
                                            $schedules = [
                                                'HOSPITAL' => [
                                                    ['from' => '07:00 AM', 'to' => '03:00 PM'],
                                                    ['from' => '03:00 PM', 'to' => '11:00 PM'],
                                                    ['from' => '11:00 PM', 'to' => '07:00 AM'],
                                                ],
                                                'SCHOOL' => [
                                                    ['from' => '07:30 AM', 'to' => '04:30 PM'],
                                                ],
                                            ];

                                            $department = isset($employeeInfo['department']) ? strtoupper(trim($employeeInfo['department'])) : null;
                                            $deptSchedules = isset($schedules[$department]) ? $schedules[$department] : [];

                                            $currentFrom = isset($employeeInfo['secheduleFrom']) ? $employeeInfo['secheduleFrom'] : '';
                                            $currentTo = isset($employeeInfo['scheduleTo']) ? $employeeInfo['scheduleTo'] : '';

                                            function valueExistsInSchedules($value, $key, $schedules) {
                                                foreach ($schedules as $shift) {
                                                    if ($shift[$key] === $value) {
                                                        return true;
                                                    }
                                                }
                                                return false;
                                            }
                                            ?>

                                            <div class="col-12 col-md-4 px-1">
                                                <label for="scheduleFrom" class="mb-0">Required (Schedule From)</label>
                                                <select name="scheduleFrom" id="scheduleFrom" class="form-select p-1 py-2 rounded-1">
                                                    <option value="">Select Schedule From</option>

                                                    <?php 
                                                    if ($currentFrom !== '' && !valueExistsInSchedules($currentFrom, 'from', $deptSchedules)) : ?>
                                                        <option value="<?= htmlspecialchars($currentFrom) ?>" selected><?= htmlspecialchars($currentFrom) ?></option>
                                                    <?php endif; ?>

                                                    <?php foreach ($deptSchedules as $shift): 
                                                        $from = $shift['from'];
                                                        $selected = ($currentFrom === $from) ? ' selected' : '';
                                                    ?>
                                                        <option value="<?= htmlspecialchars($from) ?>" <?= $selected ?>><?= htmlspecialchars($from) ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>

                                            <div class="col-12 col-md-4 px-1">
                                                <label for="scheduleTo" class="mb-0">Required (Schedule To)</label>
                                                <select name="scheduleTo" id="scheduleTo" class="form-select p-1 py-2 rounded-1">
                                                    <option value="">Select Schedule To</option>

                                                    <?php 
                                                    if ($currentTo !== '' && !valueExistsInSchedules($currentTo, 'to', $deptSchedules)) : ?>
                                                        <option value="<?= htmlspecialchars($currentTo) ?>" selected><?= htmlspecialchars($currentTo) ?></option>
                                                    <?php endif; ?>

                                                    <?php foreach ($deptSchedules as $shift): 
                                                        $to = $shift['to'];
                                                        $selected = ($currentTo === $to) ? ' selected' : '';
                                                    ?>
                                                        <option value="<?= htmlspecialchars($to) ?>" <?= $selected ?>><?= htmlspecialchars($to) ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card mb-4 shadow-sm border-0 w-100">
                                    <div class="card-body">
                                        <h4 class="card-title text-primary fw-bold mb-4 px-3">ADDRESS</h4>

                                        <div class="row g-3 px-3">
                                            <div class="col-md-4">
                                                <label for="houseBlock" class="form-label fw-bold">House Block</label>
                                                <input type="text" name="houseBlock" class="form-control" id="houseBlock" 
                                                    value="<?= (isset($employeeInfo["houseBlock"]) && trim($employeeInfo["houseBlock"]) !== '') ? htmlspecialchars($employeeInfo["houseBlock"]) : "N/A" ?>">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="street" class="form-label fw-bold">Street</label>
                                                <input type="text" name="street" class="form-control" id="street" 
                                                    value="<?= isset($employeeInfo["street"]) ? htmlspecialchars($employeeInfo["street"]) : "N/A" ?>">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="subdivision" class="form-label fw-bold">Subdivision</label>
                                                <input type="text" name="subdivision" class="form-control" id="subdivision" 
                                                    value="<?= (isset($employeeInfo["subdivision"]) && trim($employeeInfo["subdivision"]) !== '') ? htmlspecialchars($employeeInfo["subdivision"]) : "N/A" ?>">
                                            </div>
                                        </div>

                                        <div class="row g-3 px-3 mt-3">
                                            <div class="col-md-4">
                                                <label for="barangay" class="form-label fw-bold">Barangay</label>
                                                <input type="text" name="barangay" class="form-control" id="barangay" 
                                                    value="<?= isset($employeeInfo["barangay"]) ? htmlspecialchars($employeeInfo["barangay"]) : "N/A" ?>">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="city_muntinlupa" class="form-label fw-bold">City Muntinlupa</label>
                                                <input type="text" name="city_muntinlupa" class="form-control" id="city_muntinlupa" 
                                                    value="<?= isset($employeeInfo["city_muntinlupa"]) ? htmlspecialchars($employeeInfo["city_muntinlupa"]) : "N/A" ?>">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="province" class="form-label fw-bold">Province</label>
                                                <input type="text" name="province" class="form-control" id="province" 
                                                    value="<?= isset($employeeInfo["province"]) ? htmlspecialchars($employeeInfo["province"]) : "N/A" ?>">
                                            </div>
                                        </div>

                                        <div class="row g-3 px-3 mt-3">
                                            <div class="col-md-4">
                                                <label for="zip_code" class="form-label fw-bold">Zip Code</label>
                                                <input type="text" name="zipCode" class="form-control" id="zip_code" 
                                                    value="<?= isset($employeeInfo["zip_code"]) ? htmlspecialchars($employeeInfo["zip_code"]) : "N/A" ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-md modal-dialog-start">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="updateModalLabel">Update Employee Profile</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modalConfirmation px-3 py-4 text-center">
                                            <h5 class="mb-0">Are you sure you want to update this profile?</h5>
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
                    <!-- ============================ FAMILY BACKGROUND TAB ============================ -->
                    <div class="familybg h-100 h-100" id="familybg" style="display: none;">
                        <form action="../../auth/authentications.php" method="post" enctype="multipart/form-data" class="w-100 p-0 h-100 d-flex flex-row flex-wrap">
                            <div class="profileSide col-12 col-md-3 flex-column me-md-2 justify-content-start align-items-center rounded-1 mb-1 mb-md-0" id="familyProfileInformation" style="height: 80%; display: none;">
                                    <input type="hidden" name="users_id" value="<?= $employeeInfo["users_id"] ?>">
                                    <?php isset($_SESSION["csrf_token"]) && $_SESSION["csrf_token"] !== "" ? $csrf = $_SESSION["csrf_token"] : " null "; ?>
                                    <input type="hidden" name="csrf_token" value="<?php echo $csrf; ?>">
                                    <div class="profilePict w-100 mt-2 d-flex justify-content-center align-items-center h-50">
                                        <img src="../../assets/image/upload/<?= isset($employeeInfo["user_profile"]) ? htmlspecialchars($employeeInfo["user_profile"]) : "N/A" ?>" alt="Profile Picture" class="img-fluid rounded-circle">
                                    </div>
                                    <div class="profileInfo mt-2 w-100 d-flex flex-column align-items-center justify-content-start">
                                        <h5 class="fs-6 fw-bold"><?= isset($employeeInfo["employeeID"]) ? htmlspecialchars($employeeInfo["employeeID"]) : "N/A" ?></h5>
                                        <h5 class="text-center fs-6 fw-bold"><?= isset($employeeInfo["lname"]) ? htmlspecialchars($employeeInfo["lname"]) : "N/A" ?>, <?= isset($employeeInfo["fname"]) ? htmlspecialchars($employeeInfo["fname"]) : "N/A" ?> <?= isset($employeeInfo["mname"]) ? htmlspecialchars($employeeInfo["mname"]) : "N/A" ?></h5>
                                        <h5 class="fs-6 fw-bold"><?= isset($employeeInfo["jobTitle"]) ? htmlspecialchars($employeeInfo["jobTitle"]) : "N/A" ?></h5>
                                        <h5 class="fs-6 fw-bold"><?= htmlspecialchars($employeeInfo["department"] ?? "N/A") ?> DEPARTMENT</h5>
                                        <h5 class="fs-6 fw-bold"><?= "Status: " . htmlspecialchars($employeeInfo["status"]) ?></h5>
                                    </div>
                            </div>
                                
                            <div class="informationSide col-12 col-md-8 px-4 flex-row flex-wrap rounded-1 justify-content-start align-items-start" id="familyInformation" style="height: 100%; display: flex;">
                                <input type="hidden" name="familyEmployeeUpdate" value="true">
                                <?php
                                $familyData = !empty($employeeInfo) ? $employeeInfo : [[
                                    'father_name' => '',
                                    'father_occupation' => '',
                                    'father_contact' => '',
                                    'father_houseBlock' => '',
                                    'father_street' => '',
                                    'father_subdivision' => '',
                                    'father_barangay' => '',
                                    'father_city_muntinlupa' => '',
                                    'father_province' => '',
                                    'father_zip_code' => '',

                                    'mother_name' => '',
                                    'mother_occupation' => '',
                                    'mother_contact' => '',
                                    'mother_houseBlock' => '',
                                    'mother_street' => '',
                                    'mother_subdivision' => '',
                                    'mother_barangay' => '',
                                    'mother_city_muntinlupa' => '',
                                    'mother_province' => '',
                                    'mother_zip_code' => '',

                                    'guardian_name' => '',
                                    'guardian_relationship' => '',
                                    'guardian_contact' => '',
                                    'guardian_houseBlock' => '',
                                    'guardian_street' => '',
                                    'guardian_subdivision' => '',
                                    'guardian_barangay' => '',
                                    'guardian_city_muntinlupa' => '',
                                    'guardian_province' => '',
                                    'guardian_zip_code' => '',
                                ]];

                                ?>

                                <!-- FATHER -->
                                <div class="card mb-4 shadow-sm border-0">
                                    <div class="card-body">
                                        <h5 class="card-title text-primary fw-bold mb-3">Father's Information</h5>
                                        <div class="row g-3">
                                            <div class="col-md-4">
                                                <label class="form-label fw-bold">Name</label>
                                                <input type="text" class="form-control" name="father_name" value="<?= htmlspecialchars($employeeInfo['father_name']) ?>">
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label fw-bold">Occupation</label>
                                                <input type="text" class="form-control" name="father_occupation" value="<?= htmlspecialchars($employeeInfo['father_occupation']) ?>">
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label fw-bold">Contact</label>
                                                <input type="text" class="form-control" name="father_contact" value="<?= htmlspecialchars($employeeInfo['father_contact']) ?>">
                                            </div>
                                        </div>

                                        <h6 class="text-primary fw-bold mt-4">Father's Address</h6>
                                        <div class="row g-3 mt-2">
                                            <div class="col-md-4">
                                                <label class="form-label fw-bold">House Block</label>
                                                <input type="text" name="father_houseBlock" class="form-control" value="<?= htmlspecialchars($employeeInfo['father_houseBlock']) ?>">
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label fw-bold">Street</label>
                                                <input type="text" name="father_street" class="form-control" value="<?= htmlspecialchars($employeeInfo['father_street']) ?>">
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label fw-bold">Subdivision</label>
                                                <input type="text" name="father_subdivision" class="form-control" value="<?= htmlspecialchars($employeeInfo['father_subdivision']) ?>">
                                            </div>
                                        </div>
                                        <div class="row g-3 mt-2">
                                            <div class="col-md-4">
                                                <label class="form-label fw-bold">Barangay</label>
                                                <input type="text" name="father_barangay" class="form-control" value="<?= htmlspecialchars($employeeInfo['father_barangay']) ?>">
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label fw-bold">City</label>
                                                <input type="text" name="father_city_muntinlupa" class="form-control" value="<?= htmlspecialchars($employeeInfo['father_city_muntinlupa']) ?>">
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label fw-bold">Province</label>
                                                <input type="text" name="father_province" class="form-control" value="<?= htmlspecialchars($employeeInfo['father_province']) ?>">
                                            </div>
                                        </div>
                                        <div class="row g-3 mt-2">
                                            <div class="col-md-4">
                                                <label class="form-label fw-bold">Zip Code</label>
                                                <input type="text" name="father_zip_code" class="form-control" value="<?= htmlspecialchars($employeeInfo['father_zip_code']) ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- MOTHER -->
                                <div class="card mb-4 shadow-sm border-0">
                                    <div class="card-body">
                                        <h5 class="card-title text-primary fw-bold mb-3">Mother's Information</h5>
                                        <div class="row g-3">
                                            <div class="col-md-4">
                                                <label class="form-label fw-bold">Name</label>
                                                <input type="text" class="form-control" name="mother_name" value="<?= htmlspecialchars($employeeInfo['mother_name']) ?>">
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label fw-bold">Occupation</label>
                                                <input type="text" class="form-control" name="mother_occupation" value="<?= htmlspecialchars($employeeInfo['mother_occupation']) ?>">
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label fw-bold">Contact</label>
                                                <input type="text" class="form-control" name="mother_contact" value="<?= htmlspecialchars($employeeInfo['mother_contact']) ?>">
                                            </div>
                                        </div>

                                        <h6 class="text-primary fw-bold mt-4">Mother's Address</h6>
                                        <div class="row g-3 mt-2">
                                            <div class="col-md-4">
                                                <label class="form-label fw-bold">House Block</label>
                                                <input type="text" name="mother_houseBlock" class="form-control" value="<?= htmlspecialchars($employeeInfo['mother_houseBlock']) ?>">
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label fw-bold">Street</label>
                                                <input type="text" name="mother_street" class="form-control" value="<?= htmlspecialchars($employeeInfo['mother_street']) ?>">
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label fw-bold">Subdivision</label>
                                                <input type="text" name="mother_subdivision" class="form-control" value="<?= htmlspecialchars($employeeInfo['mother_subdivision']) ?>">
                                            </div>
                                        </div>
                                        <div class="row g-3 mt-2">
                                            <div class="col-md-4">
                                                <label class="form-label fw-bold">Barangay</label>
                                                <input type="text" name="mother_barangay" class="form-control" value="<?= htmlspecialchars($employeeInfo['mother_barangay']) ?>">
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label fw-bold">City</label>
                                                <input type="text" name="mother_city_muntinlupa" class="form-control" value="<?= htmlspecialchars($employeeInfo['mother_city_muntinlupa']) ?>">
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label fw-bold">Province</label>
                                                <input type="text" name="mother_province" class="form-control" value="<?= htmlspecialchars($employeeInfo['mother_province']) ?>">
                                            </div>
                                        </div>
                                        <div class="row g-3 mt-2">
                                            <div class="col-md-4">
                                                <label class="form-label fw-bold">Zip Code</label>
                                                <input type="text" name="mother_zip_code" class="form-control" value="<?= htmlspecialchars($employeeInfo['mother_zip_code']) ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- GUARDIAN -->
                                <div class="card mb-4 shadow-sm border-0">
                                    <div class="card-body">
                                        <h5 class="card-title text-primary fw-bold mb-3">Guardian's Information</h5>
                                        <div class="row g-3">
                                            <div class="col-md-4">
                                                <label class="form-label fw-bold">Name</label>
                                                <input type="text" class="form-control" name="guardian_name" value="<?= htmlspecialchars($employeeInfo['guardian_name']) ?>">
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label fw-bold">Relationship</label>
                                                <input type="text" class="form-control" name="guardian_relationship" value="<?= htmlspecialchars($employeeInfo['guardian_relationship']) ?>">
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label fw-bold">Contact</label>
                                                <input type="text" class="form-control" name="guardian_contact" value="<?= htmlspecialchars($employeeInfo['guardian_contact']) ?>">
                                            </div>
                                        </div>

                                        <h6 class="text-primary fw-bold mt-4">Guardian's Address</h6>
                                        <div class="row g-3 mt-2">
                                            <div class="col-md-4">
                                                <label class="form-label fw-bold">House Block</label>
                                                <input type="text" name="guardian_houseBlock" class="form-control" value="<?= htmlspecialchars($employeeInfo['guardian_houseBlock']) ?>">
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label fw-bold">Street</label>
                                                <input type="text" name="guardian_street" class="form-control" value="<?= htmlspecialchars($employeeInfo['guardian_street']) ?>">
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label fw-bold">Subdivision</label>
                                                <input type="text" name="guardian_subdivision" class="form-control" value="<?= htmlspecialchars($employeeInfo['guardian_subdivision']) ?>">
                                            </div>
                                        </div>
                                        <div class="row g-3 mt-2">
                                            <div class="col-md-4">
                                                <label class="form-label fw-bold">Barangay</label>
                                                <input type="text" name="guardian_barangay" class="form-control" value="<?= htmlspecialchars($employeeInfo['guardian_barangay']) ?>">
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label fw-bold">City</label>
                                                <input type="text" name="guardian_city_muntinlupa" class="form-control" value="<?= htmlspecialchars($employeeInfo['guardian_city_muntinlupa']) ?>">
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label fw-bold">Province</label>
                                                <input type="text" name="guardian_province" class="form-control" value="<?= htmlspecialchars($employeeInfo['guardian_province']) ?>">
                                            </div>
                                        </div>
                                        <div class="row g-3 mt-2">
                                            <div class="col-md-4">
                                                <label class="form-label fw-bold">Zip Code</label>
                                                <input type="text" name="guardian_zip_code" class="form-control" value="<?= htmlspecialchars($employeeInfo['guardian_zip_code']) ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal fade" id="updateModalFBG" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-md modal-dialog-start">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="updateModalLabel">Update Employee Profile</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modalConfirmation px-3 py-4 text-center">
                                            <h5 class="mb-0">Are you sure you want to update this profile?</h5>
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
                    <!-- ============================ EDUCATIONAL BACKGROUND TAB ============================ -->
                    <div class="educationalbg w-100 h-100" id="educationalbg" style="display: none;">
                        <form action="../../auth/authentications.php" method="post" enctype="multipart/form-data" class="w-100 p-0 h-100 d-flex flex-row flex-wrap">
                            <div class="profileSide col-12 col-md-3 flex-column me-md-2 justify-content-start align-items-center rounded-1 mb-1 mb-md-0" id="educationProfileInformation" style="height: 80%; display: none;">
                                    <input type="hidden" name="users_id" value="<?= htmlspecialchars($employeeInfo["users_id"]) ?>">
                                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION["csrf_token"] ?? '') ?>">
                                    <input type="hidden" name="educationalEmployeeUpdate" value="true">

                                    <div class="profilePict w-100 mt-2 d-flex justify-content-center align-items-center h-50">
                                        <img src="../../assets/image/upload/<?= isset($employeeInfo["user_profile"]) ? htmlspecialchars($employeeInfo["user_profile"]) : "N/A" ?>" alt="Profile Picture" class="img-fluid rounded-circle">
                                    </div>

                                    <div class="profileInfo mt-2 w-100 d-flex flex-column align-items-center justify-content-start">
                                        <h5 class="fs-6 fw-bold"><?= htmlspecialchars($employeeInfo["employeeID"] ?? "N/A") ?></h5>
                                        <h5 class="text-center fs-6 fw-bold"><?= htmlspecialchars($employeeInfo["lname"] ?? "N/A") ?>, <?= htmlspecialchars($employeeInfo["fname"] ?? "N/A") ?> <?= htmlspecialchars($employeeInfo["mname"] ?? "N/A") ?></h5>
                                        <h5 class="fs-6 fw-bold"><?= htmlspecialchars($employeeInfo["jobTitle"] ?? "N/A") ?></h5>
                                        <h5 class="fs-6 fw-bold"><?= htmlspecialchars($employeeInfo["department"] ?? "N/A") ?> DEPARTMENT</h5>
                                        <h5 class="fs-6 fw-bold"><?= "Status: " . htmlspecialchars($employeeInfo["status"] ?? "N/A") ?></h5>
                                    </div>
                            </div>

                            <div class="informationSide col-12 col-md-8 px-4 flex-row flex-wrap rounded-1 justify-content-start align-items-start" id="educationalInformation" style="height: 100%; display: block;">
                                <input type="hidden" name="educationalUpdate" value="true">
                                <input type="hidden" name="users_id" value="<?= htmlspecialchars($_GET['users_id'] ?? '') ?>">
                      
                                    <div class="card mb-4 shadow-sm border-0">
                                        <div class="card-body">
                                            <h5 class="card-title text-primary text-capitalize mb-3"><?= str_replace('_', ' ', $level) ?> Education</h5>
                                            <div class="row g-3">
                                                <div class="col-md-6 col-lg-4">
                                                    <label class="form-label fw-bold"><?= str_replace('_', ' ', $level) ?> School</label>
                                                    <input type="text" name="<?= $level ?>_school" class="form-control" 
                                                        value="<?= isset($employeeInfo["school_name"]) ? htmlspecialchars($employeeInfo["school_name"]) : "" ?>">
                                                </div>
                                                <?php $currentYear = date("Y"); ?>
                                                <div class="col-md-6 col-lg-4">
                                                    <label class="form-label fw-bold">Year Started</label>
                                                    <select name="<?= $level ?>_year_started" class="form-select">
                                                        <option value="">Select Year</option>
                                                        <?php for ($year = 1980; $year <= $currentYear; $year++): ?>
                                                            <option value="<?= $year ?>" <?= (isset($employeeInfo["year_started"]) && $employeeInfo["year_started"] == $year) ? "selected" : "" ?>>
                                                                <?= $year ?>
                                                            </option>
                                                        <?php endfor; ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-6 col-lg-4">
                                                    <label class="form-label fw-bold">Year Ended</label>
                                                    <select name="<?= $level ?>_year_ended" class="form-select">
                                                        <option value="">Select Year</option>
                                                        <?php for ($year = 1980; $year <= $currentYear; $year++): ?>
                                                            <option value="<?= $year ?>" <?= (isset($employeeInfo["year_ended"]) && $employeeInfo["year_ended"] == $year) ? "selected" : "" ?>>
                                                                <?= $year ?>
                                                            </option>
                                                        <?php endfor; ?>
                                                    </select>
                                                </div>
                                                <?php if (in_array($level, ['college', 'graduate', 'senior_high'])): ?>
                                                    <div class="col-md-6 col-lg-4">
                                                        <label class="form-label fw-bold">Course/Strand</label>
                                                        <input type="text" name="<?= $level ?>_course" class="form-control" 
                                                            value="<?= isset($employeeInfo["course_or_strand"]) ? htmlspecialchars($employeeInfo["course_or_strand"]) : "" ?>">
                                                    </div>
                                                <?php endif; ?>
                                                <div class="col-md-6 col-lg-4">
                                                    <label class="form-label fw-bold">Honors</label>
                                                    <textarea name="<?= $level ?>_honors" class="form-control" rows="3"><?= isset($employeeInfo["honors"]) ? htmlspecialchars($row["honors"]) : "" ?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                            <div class="modal fade" id="updateModalEBG" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-md modal-dialog-start">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="updateModalLabel">Update Employee Profile</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modalConfirmation px-3 py-4 text-center">
                                            <h5 class="mb-0">Are you sure you want to update this profile?</h5>
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
                </div>
            </div>
        </div>
    </div>
</main>
<div id="loadingAnimation" style="display:none;">
  <div class="loading-lines">
    <div class="line"></div>
    <div class="line"></div>
    <div class="line"></div>
  </div>
</div>

<?php include '../../templates/Ufooter.php'?>