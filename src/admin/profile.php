<?php
 include '../../templates/Uheader.php';
 include '../../templates/HN.php';
?>

<main>
    <div class="main-body w-100 h-100 m-0 p-0">
        <div class="header d-flex align-items-center justify-content-between px-3" style="height: 60px; min-width: 100%;">
            <div class="logo d-flex align-items-center">
                <button type="button" onclick="sideNav();"><i class="fa-solid fa-bars fs-4 me-3" style="color: #fff;"></i></button>
                <img src="../../assets/image/pueri-logo.png" alt="Logo" style="height: 40px;" class="me-2">
                <h4 class="m-0">ZAMBOANGA PUERICULTURE CENTER</h4>
            </div>

            <div class="usersButton d-flex align-items-center">
                <div class="pds-wrapper" style="position: relative;">
                    <p class="fw-bold pNone">Personal Data Sheet</p>
                    <a href="pds.php?users_id=<?= $_GET["users_id"] ?? '' ?>" class="togglePDS">
                        <i class="fa-solid fa-arrow-up-right-from-square me-3" style="color: #fff !important;"></i>
                    </a>
                </div>


                <a href="settings.php"><i class="fa-solid fa-gear" style="color: #fff;"></i></a>
                <button class="me-3" style="background: none; border:none; width: 20px;" onclick="logoutButton()"><i class="fa-solid fa-right-from-bracket ms-3" style="color: #fff;"></i></button>
                <button class="align-items-center" type="button" onclick="userButton()">
                    <img src="../../assets/image/admin.png" class="rounded-circle me-2 ms-4" style="height: 35px; width: 35px;">
                    <span class="fw-bold" style="color: #fff;">ADMIN</span>
                </button>
            </div>
        </div>
        <script>
            function logoutButton(){
                document.getElementById("logoutDiv").style.display = 'flex';
            }
            function logoutNo(){
                document.getElementById("logoutDiv").style.display = 'none';
            }
        </script>
        <div class="logout flex-column LogoutAniamtion " id="logoutDiv" class="p-3"
            style="position: fixed; transform: translate(-50%, -50%); top:50%; left:50%; display: none; z-index: 55;">
            <div class="shadow rounded p-0 logoutMediaWidth" style="background-color: #fff !important;">
                <div class="question mb-3 d-flex flex-column h-auto BGGradiant p-3 rounded-top-2">
                    <span style="font-family: 'Jomhuria', cursive !important;" class="fs-2 text-white">LOGOUT
                        CONFIRMATION</span>
                    <span class="text-white">Are you sure you want to logout?</span>
                </div>
                <div class="buttons d-flex flex-row justify-content-evenly w-100 mt-1 pb-4">
                    <a href="logout.php" id="logoutYes" class="col-md-5 btn btn-danger btn-sm mt-2 buttonLogoutMedia">Yes</a>
                    <button id="logoutNo" class="col-md-5 btn btn-secondary btn-sm mt-2 buttonLogoutMedia"
                        onclick="logoutNo()">No</button>
                </div>
            </div>
        </div>

        <div class="d-flex w-100 align-items-start" style="height: 91%">
            <?php renderNav() ?>
             
            <div class="contents w-100 h-100 d-flex flex-column align-items-center p-0 m-0">
                <div class="linkToEmployeeManagement d-flex flex-row align-items-center justify-content-start p-0 m-0 my-3" style="width: 95%; height: 5rem !important;">
                    <a href="employee.php" style="text-decoration: none;"><i class="fa-solid fa-arrow-left-long fs-6 me-1"></i>Go back to Employee Management</a>
                </div>
                <div class="header-employee d-flex flex-row justify-content-between align-items-centercol-md-3 col-md-11 flex-wrap m-0">
                    <div class="h1 col-md-3 col-12">
                        <h3 class="m-0">EMPLOYEE PROFILE</h3>
                    </div>
                    <div class="navigations col-md-7 col-12">
                        <button type="button" id="Personal" onclick="activateTab(this); personalInfo()" class="tab-btn active">Personal Information</button>
                        <button type="button" id="Family" onclick="activateTab(this); familyBG()" class="tab-btn">Family Background</button>
                        <button type="button" id="Educational" onclick="activateTab(this); educationalBG()" class="tab-btn">Educational Background</button>
                    </div>

                    <div class="buttonUpdate col-md-1 col-12">
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
                <div class="employeeReqProfileINfo flex-column justify-content-between p-0 m-0 mt-2" style="width: 95%; height: 74vh; display:flex;" id="personalID">
                    <div class="row h-100 w-100">
                        <form action="../../auth/authentications.php" method="post" enctype="multipart/form-data" class="w-100 p-0 h-100 d-flex flex-row flex-wrap">
                            <div class="profileSide BGGradiant col-12 col-md-3 flex-column me-md-2 justify-content-start align-items-center
                                rounded-1 mb-1 mb-md-0" style="height: 80%; display: flex;" id="personalProfileInformation">
                                <?php foreach($reqProfInfo as $row): ?>
                                    <input type="hidden" name="users_id" value="<?= $row["users_id"] ?>">
                                    <?php isset($_SESSION["csrf_token"]) && $_SESSION["csrf_token"] !== "" ? $csrf = $_SESSION["csrf_token"] : " null "; ?>
                                    <input type="hidden" name="csrf_token" value="<?php echo $csrf; ?>">
                                    <input type="hidden" name="validatedUpdate" value="true">
                                    <div class="profilePict w-100 mt-2 d-flex justify-content-center align-items-center h-50">
                                        <?php if (!empty($row["user_profile"])): ?>
                                            <img src="../../assets/image/upload/<?= htmlspecialchars($row["user_profile"]) ?>" 
                                                alt="Profile Picture" 
                                                class="img-fluid rounded-circle">
                                        <?php else: ?>
                                            <img src="../../assets/image/users.png" 
                                                alt="Profile Picture" 
                                                class="img-fluid rounded-circle">
                                        <?php endif; ?>
                                    </div>
                                    <div class="profileInfo mt-2 w-100 d-flex flex-column align-items-center justify-content-start">
                                        <h5 class="txtToWhite fs-6 fw-bold"><?= isset($row["employeeID"]) ? htmlspecialchars($row["employeeID"]) : "N/A" ?></h5>
                                        <h5 class="txtToWhite text-center fs-6 fw-bold"><?= isset($row["lname"]) ? htmlspecialchars($row["lname"]) : "N/A" ?>, <?= isset($row["fname"]) ? htmlspecialchars($row["fname"]) : "N/A" ?> <?= isset($row["mname"]) ? htmlspecialchars($row["mname"]) : "N/A" ?></h5>
                                        <h5 class="txtToWhite fs-6 fw-bold"><?= isset($row["jobTitle"]) ? htmlspecialchars($row["jobTitle"]) : "N/A" ?></h5>
                                        <h5 class="txtToWhite fs-6 fw-bold"><?= htmlspecialchars($row["department"] ?? "N/A") ?> DEPARTMENT</h5>
                                        <h5 class="txtToWhite fs-6 fw-bold"><?= "Status: " . htmlspecialchars($row["status"]) ?></h5>
                                        <h5 class="txtToWhite fs-6 fw-bold"><?= "Schedule: " . htmlspecialchars($row["scheduleFrom"]) . " - "  . htmlspecialchars($row["scheduleTo"]) ?></h5>
                                    </div>
                            </div>
                            <div class="informationSide col-12 col-md-8 px-4 flex-row flex-wrap rounded-1 justify-content-start align-items-start" style="height: 100%; display: flex;" id="personalInformation">
                                <div class="profileID row w-100">
                                    <div class="col-md-8">
                                        <label for="user_profile" class="fw-bold">Profile</label>
                                        <input type="file" name="user_profile" class="form-control" id="user_profile">
                                        <input type="hidden" name="current_profile_image" value="<?= htmlspecialchars($row["user_profile"]) ?>">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="employeeID" class="fw-bold">Employee ID</label>
                                        <input type="text" name="employeeID" class="form-control" id="employeeID" value="<?= isset($row["employeeID"]) ? htmlspecialchars($row["employeeID"]) : "N/A" ?>">
                                    </div>
                                </div>
                                <div class="inputInfo my-2 row w-100">
                                    <div class="col-md-3">
                                        <label for="lname" class="fw-bold">Surname</label>
                                        <input type="text" name="lname" class="form-control" id="lname" value="<?= isset($row["lname"]) ? htmlspecialchars($row["lname"]) : "N/A" ?>">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="fname" class="fw-bold">First Name</label>
                                        <input type="text" name="fname" class="form-control" id="fname" value="<?= isset($row["fname"]) ? htmlspecialchars($row["fname"]) : "N/A" ?>">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="mname" class="fw-bold">Middle Name</label>
                                        <input type="text" name="mname" class="form-control" id="mname" value="<?= isset($row["mname"]) ? htmlspecialchars($row["mname"]) : "N/A" ?>">
                                    </div>
                                    <div class="col-md-2">
                                        <label for="suffix" class="fw-bold">Suffix</label>
                                        <input type="text" name="suffix" class="form-control" id="suffix" value="<?= isset($row["suffix"]) ? htmlspecialchars($row["suffix"]) : "N/A" ?>">
                                    </div>
                                </div>
                                <div class="inputInfo my-2 row w-100">
                                    <div class="col-md-4">
                                        <label for="jobTitle" class="fw-bold">Job Title</label>
                                        <input type="text" name="jobTitle" class="non-editable form-control" id="jobTitle" value="<?= isset($row["jobTitle"]) ? htmlspecialchars($row["jobTitle"]) : "N/A" ?>">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="department" class="fw-bold">Department</label>
                                        <input type="text" name="department" class="form-control" id="department" value="<?= isset($row["department"]) ? htmlspecialchars($row["department"]) : "N/A" ?>">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="salaryRate" class="fw-bold">Salary Rate</label>
                                        <input type="text" name="salary_rate" class="form-control" id="salaryRate" value="<?= isset($row["slary_rate"]) ? htmlspecialchars($row["slary_rate"]) : "N/A" ?>">
                                    </div>
                                </div>
                                <div class="inputInfo my-2 row w-100">
                                    <div class="col-md-4">
                                        <label for="salary" class="fw-bold">Salary</label>
                                        <input type="number" name="salary" class="non-editable form-control" id="salary" value="<?= isset($row["salary"]) ? htmlspecialchars($row["salary"]) : "N/A" ?>" style="">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="from" class="fw-bold">Salary Range From</label>
                                        <input type="number" name="salary_Range_From" class="non-editable form-control" id="from" value="<?= isset($row["salary_Range_From"]) ? htmlspecialchars($row["salary_Range_From"]) : "N/A" ?>">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="to" class="fw-bold">Salary Range To</label>
                                        <input type="number" name="salary_Range_To" class="non-editable form-control" id="to" value="<?= isset($row["salary_Range_To"]) ? htmlspecialchars($row["salary_Range_To"]) : "N/A" ?>">
                                    </div>
                                </div>
                                <div class="inputInfo my-2 row w-100">
                                    <div class="col-md-4">
                                        <label for="Citizenship" class="fw-bold">Citizenship</label>
                                        <input type="text" name="citizenship" class="form-control" id="Citizenship" value="<?= isset($row["citizenship"]) ? htmlspecialchars($row["citizenship"]) : "N/A" ?>">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="Gender" class="fw-bold">Gender</label>
                                        <input type="text" name="gender" class="form-control" id="Gender" value="<?= isset($row["gender"]) ? htmlspecialchars($row["gender"]) : "N/A" ?>">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="civil_status" class="fw-bold">Civil Status</label>
                                        <input type="text" name="civil_status" class="form-control" id="civil_status" value="<?= isset($row["civil_status"]) ? htmlspecialchars($row["age"]) : "N/A" ?>">
                                    </div>
                                </div>
                                <div class="inputInfo my-2 row w-100">
                                    <div class="col-md-4">
                                        <label for="religion" class="fw-bold">Religion</label>
                                        <input type="text" name="religion" class="form-control" id="religion" value="<?= isset($row["religion"]) ? htmlspecialchars($row["citizenship"]) : "N/A" ?>">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="age" class="fw-bold">Age</label>
                                        <input type="text" name="age" class="form-control" id="age" value="<?= isset($row["age"]) ? htmlspecialchars($row["gender"]) : "N/A" ?>">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="Birthday" class="fw-bold">Birthday</label>
                                        <input type="text" name="birthday" class="form-control" id="Birthday" value="<?= isset($row["birthday"]) ? htmlspecialchars($row["birthday"]) : "N/A" ?>">
                                    </div>
                                </div>
                                <div class="inputInfo my-2 row w-100">
                                    <div class="col-md-4">
                                        <label for="BirthPlace" class="fw-bold">Birth Place</label>
                                        <input type="text" name="birthPlace" class="form-control" id="BirthPlace" value="<?= isset($row["birthPlace"]) ? htmlspecialchars($row["birthPlace"]) : "N/A" ?>">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="Contact" class="fw-bold">Contact</label>
                                        <input type="text" name="contact" class="form-control" id="Contact" value="<?= isset($row["contact"]) ? htmlspecialchars($row["contact"]) : "N/A" ?>">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="Email" class="fw-bold">Email</label>
                                        <input type="text" name="email" class="form-control" id="Email" value="<?= isset($row["email"]) ? htmlspecialchars($row["email"]) : "N/A" ?>">
                                    </div>
                                </div>
                                <div class="inputInfo my-2 row w-100">
                                    <div class="col-md-4">
                                        <label for="city_muntinlupa" class="fw-bold">Schedule From</label>
                                        <input type="text" name="scheduleFrom" class="form-control" id="city_muntinlupa" value="<?= isset($row["scheduleFrom"]) ? htmlspecialchars($row["scheduleFrom"]) : "N/A" ?>">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="ScheduleTo" class="fw-bold">Schedule To</label>
                                        <input type="text" name="scheduleTo" class="form-control" id="ScheduleTo" value="<?= isset($row["scheduleTo"]) ? htmlspecialchars($row["scheduleTo"]) : "N/A" ?>">
                                    </div>
                                </div>
                                <div class="addressContents w-100 mt-4">
                                    <h4 class="px-3">ADDRESS</h4>
                                </div>
                                <div class="inputInfo my-2 row w-100">
                                    <div class="col-md-4">
                                        <label for="houseBlock" class="fw-bold">House Block</label>
                                        <input type="text" name="houseBlock" class="form-control" id="houseBlock" value="<?= !empty(isset($row["houseBlock"])) ? htmlspecialchars($row["houseBlock"]) : "N/A" ?>">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="street" class="fw-bold">Street</label>
                                        <input type="text" name="street" class="form-control" id="street" value="<?= isset($row["street"]) ? htmlspecialchars($row["street"]) : "N/A" ?>">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="subdivision" class="fw-bold">Subdivision</label>
                                        <input type="text" name="subdivision" class="form-control" id="subdivision" value="<?= isset($row["subdivision"]) ? htmlspecialchars($row["subdivision"]) : "N/A" ?>">
                                    </div>
                                </div>
                                <div class="inputInfo my-2 row w-100">
                                    <div class="col-md-4">
                                        <label for="barangay" class="fw-bold">Barangay</label>
                                        <input type="text" name="barangay" class="form-control" id="barangay" value="<?= isset($row["barangay"]) ? htmlspecialchars($row["barangay"]) : "N/A" ?>">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="city_muntinlupa" class="fw-bold">City Muntinlupa</label>
                                        <input type="text" name="city_muntinlupa" class="form-control" id="city_muntinlupa" value="<?= isset($row["scheduleFrom"]) ? htmlspecialchars($row["scheduleFrom"]) : "N/A" ?>">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="province" class="fw-bold">Province</label>
                                        <input type="text" name="province" class="form-control" id="province" value="<?= isset($row["province"]) ? htmlspecialchars($row["province"]) : "N/A" ?>">
                                    </div>
                                </div>
                                <div class="inputInfo my-2 row w-100">
                                    <div class="col-md-4">
                                        <label for="zip_code" class="fw-bold">Zip Code</label>
                                        <input type="text" name="zipCode" class="form-control" id="zip_code" value="<?= isset($row["zip_code"]) ? htmlspecialchars($row["zip_code"]) : "N/A" ?>">
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
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
                </div>
                    <!-- ============================ FAMILY BACKGROUND TAB ============================ -->
                <div class="familybg flex-column justify-content-between p-0 m-0 mt-2" id="familybg" style="width: 95%; height: 74vh; display: none;">
                    <!-- <div class="row h-100 w-100"> -->
                        <form action="../../auth/authentications.php" method="post" enctype="multipart/form-data" class="w-100 p-0 h-100 d-flex flex-row flex-wrap">
                            <div class="profileSide BGGradiant col-12 col-md-3 flex-column me-md-2 justify-content-start align-items-center
                                rounded-1 mb-1 mb-md-0" id="familyProfileInformation" style="height: 80%; display: none;">
                                <?php foreach ($reqProfInfo as $row): ?>
                                    <input type="hidden" name="users_id" value="<?= $row["users_id"] ?>">
                                    <?php isset($_SESSION["csrf_token"]) && $_SESSION["csrf_token"] !== "" ? $csrf = $_SESSION["csrf_token"] : " null "; ?>
                                    <input type="hidden" name="csrf_token" value="<?php echo $csrf; ?>">
                                    <input type="hidden" name="familyUpdate" value="true">
                                    <div class="profilePict w-100 mt-2 d-flex justify-content-center align-items-center h-50">
                                        <img src="../../assets/image/upload/<?= isset($row["user_profile"]) ? htmlspecialchars($row["user_profile"]) : "N/A" ?>" alt="Profile Picture" class="img-fluid rounded-circle">
                                    </div>
                                    <div class="profileInfo mt-2 w-100 d-flex flex-column align-items-center justify-content-start">
                                        <h5 class="txtToWhite fs-6 fw-bold"><?= isset($row["employeeID"]) ? htmlspecialchars($row["employeeID"]) : "N/A" ?></h5>
                                        <h5 class="txtToWhite text-center fs-6 fw-bold"><?= isset($row["lname"]) ? htmlspecialchars($row["lname"]) : "N/A" ?>, <?= isset($row["fname"]) ? htmlspecialchars($row["fname"]) : "N/A" ?> <?= isset($row["mname"]) ? htmlspecialchars($row["mname"]) : "N/A" ?></h5>
                                        <h5 class="txtToWhite fs-6 fw-bold"><?= isset($row["jobTitle"]) ? htmlspecialchars($row["jobTitle"]) : "N/A" ?></h5>
                                        <h5 class="txtToWhite fs-6 fw-bold"><?= htmlspecialchars($row["department"] ?? "N/A") ?> DEPARTMENT</h5>
                                        <h5 class="txtToWhite fs-6 fw-bold"><?= "Status: " . htmlspecialchars($row["status"]) ?></h5>
                                        <h5 class="txtToWhite fs-6 fw-bold"><?= "Schedule: " . htmlspecialchars($row["scheduleFrom"]) . " - "  . htmlspecialchars($row["scheduleTo"]) ?></h5>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                                
                            <div class="informationSide col-12 col-md-8 px-4 flex-row flex-wrap rounded-1 justify-content-start align-items-start" id="familyInformation" style="height: 100%; display: flex;">
                                <input type="hidden" name="familyUpdate" value="true">
                                <?php
                                $familyData = !empty($getFam) ? $getFam : [[
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

                                foreach ($familyData as $row):
                                ?>

                                <!-- FATHER -->
                                <div class="card mb-4 shadow-sm border-0">
                                    <div class="card-body">
                                        <h5 class="card-title text-primary fw-bold mb-3">Father's Information</h5>
                                        <div class="row g-3">
                                            <div class="col-md-4">
                                                <label class="form-label fw-bold">Name</label>
                                                <input type="text" class="form-control" name="father_name" value="<?= htmlspecialchars($row['father_name']) ?>">
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label fw-bold">Occupation</label>
                                                <input type="text" class="form-control" name="father_occupation" value="<?= htmlspecialchars($row['father_occupation']) ?>">
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label fw-bold">Contact</label>
                                                <input type="text" class="form-control" name="father_contact" value="<?= htmlspecialchars($row['father_contact']) ?>">
                                            </div>
                                        </div>

                                        <h6 class="text-primary fw-bold mt-4">Father's Address</h6>
                                       <div class="row g-3 mt-2">
                                            <div class="col-md-4">
                                                <label class="form-label fw-bold">House Block</label>
                                                <input type="text" name="father_houseBlock" class="form-control" value="<?= isset($row['father_houseBlock']) ? htmlspecialchars($row['father_houseBlock']) : '' ?>">
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label fw-bold">Street</label>
                                                <input type="text" name="father_street" class="form-control" value="<?= isset($row['father_street']) ? htmlspecialchars($row['father_street']) : '' ?>">
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label fw-bold">Subdivision</label>
                                                <input type="text" name="father_subdivision" class="form-control" value="<?= isset($row['father_subdivision']) ? htmlspecialchars($row['father_subdivision']) : '' ?>">
                                            </div>
                                        </div>
                                        <div class="row g-3 mt-2">
                                            <div class="col-md-4">
                                                <label class="form-label fw-bold">Barangay</label>
                                                <input type="text" name="father_barangay" class="form-control" value="<?= isset($row['father_barangay']) ? htmlspecialchars($row['father_barangay']) : '' ?>">
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label fw-bold">City</label>
                                                <input type="text" name="father_city_muntinlupa" class="form-control" value="<?= isset($row['father_city_muntinlupa']) ? htmlspecialchars($row['father_city_muntinlupa']) : '' ?>">
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label fw-bold">Province</label>
                                                <input type="text" name="father_province" class="form-control" value="<?= isset($row['father_province']) ? htmlspecialchars($row['father_province']) : '' ?>">
                                            </div>
                                        </div>
                                        <div class="row g-3 mt-2">
                                            <div class="col-md-4">
                                                <label class="form-label fw-bold">Zip Code</label>
                                                <input type="text" name="father_zip_code" class="form-control" value="<?= isset($row['father_zip_code']) ? htmlspecialchars($row['father_zip_code']) : '' ?>">
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
                                                <input type="text" class="form-control" name="mother_name" value="<?= htmlspecialchars($row['mother_name']) ?>">
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label fw-bold">Occupation</label>
                                                <input type="text" class="form-control" name="mother_occupation" value="<?= htmlspecialchars($row['mother_occupation']) ?>">
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label fw-bold">Contact</label>
                                                <input type="text" class="form-control" name="mother_contact" value="<?= htmlspecialchars($row['mother_contact']) ?>">
                                            </div>
                                        </div>

                                        <h6 class="text-primary fw-bold mt-4">Mother's Address</h6>
                                        <div class="row g-3 mt-2">
                                            <div class="col-md-4">
                                                <label class="form-label fw-bold">House Block</label>
                                                <input type="text" name="mother_houseBlock" class="form-control" value="<?= htmlspecialchars($row['mother_houseBlock']) ?>">
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label fw-bold">Street</label>
                                                <input type="text" name="mother_street" class="form-control" value="<?= htmlspecialchars($row['mother_street']) ?>">
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label fw-bold">Subdivision</label>
                                                <input type="text" name="mother_subdivision" class="form-control" value="<?= htmlspecialchars($row['mother_subdivision']) ?>">
                                            </div>
                                        </div>
                                        <div class="row g-3 mt-2">
                                            <div class="col-md-4">
                                                <label class="form-label fw-bold">Barangay</label>
                                                <input type="text" name="mother_barangay" class="form-control" value="<?= htmlspecialchars($row['mother_barangay']) ?>">
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label fw-bold">City</label>
                                                <input type="text" name="mother_city_muntinlupa" class="form-control" value="<?= htmlspecialchars($row['mother_city_muntinlupa']) ?>">
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label fw-bold">Province</label>
                                                <input type="text" name="mother_province" class="form-control" value="<?= htmlspecialchars($row['mother_province']) ?>">
                                            </div>
                                        </div>
                                        <div class="row g-3 mt-2">
                                            <div class="col-md-4">
                                                <label class="form-label fw-bold">Zip Code</label>
                                                <input type="text" name="mother_zip_code" class="form-control" value="<?= htmlspecialchars($row['mother_zip_code']) ?>">
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
                                                <input type="text" class="form-control" name="guardian_name" value="<?= htmlspecialchars($row['guardian_name']) ?>">
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label fw-bold">Relationship</label>
                                                <input type="text" class="form-control" name="guardian_relationship" value="<?= htmlspecialchars($row['guardian_relationship']) ?>">
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label fw-bold">Contact</label>
                                                <input type="text" class="form-control" name="guardian_contact" value="<?= htmlspecialchars($row['guardian_contact']) ?>">
                                            </div>
                                        </div>

                                        <h6 class="text-primary fw-bold mt-4">Guardian's Address</h6>
                                        <div class="row g-3 mt-2">
                                            <div class="col-md-4">
                                                <label class="form-label fw-bold">House Block</label>
                                                <input type="text" name="guardian_houseBlock" class="form-control" value="<?= htmlspecialchars($row['guardian_houseBlock']) ?>">
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label fw-bold">Street</label>
                                                <input type="text" name="guardian_street" class="form-control" value="<?= htmlspecialchars($row['guardian_street']) ?>">
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label fw-bold">Subdivision</label>
                                                <input type="text" name="guardian_subdivision" class="form-control" value="<?= htmlspecialchars($row['guardian_subdivision']) ?>">
                                            </div>
                                        </div>
                                        <div class="row g-3 mt-2">
                                            <div class="col-md-4">
                                                <label class="form-label fw-bold">Barangay</label>
                                                <input type="text" name="guardian_barangay" class="form-control" value="<?= htmlspecialchars($row['guardian_barangay']) ?>">
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label fw-bold">City</label>
                                                <input type="text" name="guardian_city_muntinlupa" class="form-control" value="<?= htmlspecialchars($row['guardian_city_muntinlupa']) ?>">
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label fw-bold">Province</label>
                                                <input type="text" name="guardian_province" class="form-control" value="<?= htmlspecialchars($row['guardian_province']) ?>">
                                            </div>
                                        </div>
                                        <div class="row g-3 mt-2">
                                            <div class="col-md-4">
                                                <label class="form-label fw-bold">Zip Code</label>
                                                <input type="text" name="guardian_zip_code" class="form-control" value="<?= htmlspecialchars($row['guardian_zip_code']) ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; ?>
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
                    <!-- </div> -->
                </div>
                    <!-- ============================ EDUCATIONAL BACKGROUND TAB ============================ -->
                <div class="educationalbg mt-2" id="educationalbg" style="display: none; height: 74vh; width: 95%;">
                    <div class="row h-100 w-100">
                        <form action="../../auth/authentications.php" method="post" enctype="multipart/form-data" class="w-100 p-0 h-100 d-flex flex-row flex-wrap">
                            <div class="profileSide BGGradiant col-12 col-md-3 flex-column me-md-2 justify-content-start align-items-center
                                rounded-1 mb-1 mb-md-0" id="educationProfileInformation" style="height: 80%; display: none;">
                                <?php foreach ($reqProfInfo as $row): ?>
                                    <input type="hidden" name="users_id" value="<?= htmlspecialchars($row["users_id"]) ?>">
                                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION["csrf_token"] ?? '') ?>">
                                    <input type="hidden" name="educationalUpdate" value="true">
                                    
                                    <div class="profilePict w-100 mt-2 d-flex justify-content-center align-items-center h-50">
                                        <img src="../../assets/image/upload/<?= isset($row["user_profile"]) ? htmlspecialchars($row["user_profile"]) : "N/A" ?>" alt="Profile Picture" class="img-fluid rounded-circle">
                                    </div>

                                    <div class="profileInfo mt-2 w-100 d-flex flex-column align-items-center justify-content-start">
                                        <h5 class="txtToWhite fs-6 fw-bold"><?= htmlspecialchars($row["employeeID"] ?? "N/A") ?></h5>
                                        <h5 class="txtToWhite text-center fs-6 fw-bold"><?= htmlspecialchars($row["lname"] ?? "N/A") ?>, <?= htmlspecialchars($row["fname"] ?? "N/A") ?> <?= htmlspecialchars($row["mname"] ?? "N/A") ?></h5>
                                        <h5 class="txtToWhite fs-6 fw-bold"><?= htmlspecialchars($row["jobTitle"] ?? "N/A") ?></h5>
                                        <h5 class="txtToWhite fs-6 fw-bold"><?= htmlspecialchars($row["department"] ?? "N/A") ?> DEPARTMENT</h5>
                                        <h5 class="txtToWhite fs-6 fw-bold"><?= "Status: " . htmlspecialchars($row["status"] ?? "N/A") ?></h5>
                                        <h5 class="txtToWhite fs-6 fw-bold"><?= "Schedule: " . htmlspecialchars($row["scheduleFrom"]) . " - "  . htmlspecialchars($row["scheduleTo"]) ?></h5>
                                    </div>
                                <?php endforeach; ?>
                            </div>

                            <div class="informationSide col-12 col-md-8 px-4 flex-row flex-wrap rounded-1 justify-content-start align-items-start" id="educationalInformation" style="height: 100%; display: block;">
                                <input type="hidden" name="educationalUpdate" value="true">
                                <input type="hidden" name="users_id" value="<?= htmlspecialchars($_GET['users_id'] ?? '') ?>">

                                <?php foreach ($getEduc as $level => $row): ?>
                                    <div class="card mb-4 shadow-sm border-0">
                                        <div class="card-body">
                                            <h5 class="card-title text-primary text-capitalize mb-3"><?= str_replace('_', ' ', $level) ?> Education</h5>
                                            <div class="row g-3">
                                                <div class="col-md-6 col-lg-4">
                                                    <label class="form-label fw-bold"><?= str_replace('_', ' ', $level) ?> School</label>
                                                    <input type="text" name="<?= $level ?>_school" class="form-control" 
                                                        value="<?= isset($row["school_name"]) ? htmlspecialchars($row["school_name"]) : "" ?>">
                                                </div>
                                                <?php $currentYear = date("Y"); ?>
                                                <div class="col-md-6 col-lg-4">
                                                    <label class="form-label fw-bold">Year Started</label>
                                                    <select name="<?= $level ?>_year_started" class="form-select">
                                                        <option value="">Select Year</option>
                                                        <?php for ($year = 1980; $year <= $currentYear; $year++): ?>
                                                            <option value="<?= $year ?>" <?= (isset($row["year_started"]) && $row["year_started"] == $year) ? "selected" : "" ?>>
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
                                                            <option value="<?= $year ?>" <?= (isset($row["year_ended"]) && $row["year_ended"] == $year) ? "selected" : "" ?>>
                                                                <?= $year ?>
                                                            </option>
                                                        <?php endfor; ?>
                                                    </select>
                                                </div>
                                                <?php if (in_array($level, ['college', 'graduate', 'senior_high'])): ?>
                                                    <div class="col-md-6 col-lg-4">
                                                        <label class="form-label fw-bold">Course/Strand</label>
                                                        <input type="text" name="<?= $level ?>_course" class="form-control" 
                                                            value="<?= isset($row["course_or_strand"]) ? htmlspecialchars($row["course_or_strand"]) : "" ?>">
                                                    </div>
                                                <?php endif; ?>
                                                <div class="col-md-6 col-lg-4">
                                                    <label class="form-label fw-bold">Honors</label>
                                                    <textarea name="<?= $level ?>_honors" class="form-control" rows="3"><?= isset($row["honors"]) ? htmlspecialchars($row["honors"]) : "" ?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>

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
<!-- <script src="../../assets/js/hr/profAdmin.js"></script> -->
<script src="../../assets/js/hr/profile.js" defer></script>
<?php include '../../templates/Ufooter.php'?>