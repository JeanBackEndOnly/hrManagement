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
                <div class="linkToEmployeeManagement d-flex flex-row align-items-center justify-content-start p-0 m-0 " style="width: 95%; height: 5rem;">
                    <a href="employee.php" style="text-decoration: none;"><i class="fa-solid fa-arrow-left-long fs-6 me-1"></i>Go back to Employee Management</a>
                </div>
                <div class="header-employee d-flex flex-row justify-content-between align-items-center" style="height: 2rem; width: 95%;">
                    <div class="h1">
                        <h3 class="m-0">EMPLOYEE PROFILE</h3>
                    </div>
                    <div class="buttonUpdate">
                       <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#updateModal">
                            Update
                        </button>
                    </div>
                </div>
                <div class="employeeReqProfileINfo d-flex flex-column justify-content-between p-0 m-0 mt-2" style="width: 95%; height: 74vh;">
                    <div class="row h-100 w-100">
                        <form action="../../auth/authentications.php" method="post" enctype="multipart/form-data" class="w-100 p-0 h-100 d-flex flex-row flex-wrap">
                            <div class="profileSide col-12 col-md-3 d-flex flex-column me-md-2 justify-content-start align-items-center rounded-1 mb-1 mb-md-0" style="height: 80%;">
                                <?php foreach($reqProfInfo as $row): ?>
                                    <input type="hidden" name="users_id" value="<?= $row["users_id"] ?>">
                                    <?php isset($_SESSION["csrf_token"]) && $_SESSION["csrf_token"] !== "" ? $csrf = $_SESSION["csrf_token"] : " null "; ?>
                                    <input type="hidden" name="csrf_token" value="<?php echo $csrf; ?>">
                                    <input type="hidden" name="requestUpdate" value="true">
                                    <div class="profilePict w-100 mt-2 d-flex justify-content-center align-items-center h-50">
                                        <img src="../../assets/image/upload/<?= isset($row["user_profile"]) ? htmlspecialchars($row["user_profile"]) : "N/A" ?>" alt="Profile Picture" class="img-fluid rounded-circle">
                                    </div>
                                    <div class="profileInfo mt-2 w-100 d-flex flex-column align-items-center justify-content-start">
                                        <h5 class="fs-6 fw-bold"><?= isset($row["employeeID"]) ? htmlspecialchars($row["employeeID"]) : "N/A" ?></h5>
                                        <h5 class="text-center fs-6 fw-bold"><?= isset($row["lname"]) ? htmlspecialchars($row["lname"]) : "N/A" ?>, <?= isset($row["fname"]) ? htmlspecialchars($row["fname"]) : "N/A" ?> <?= isset($row["mname"]) ? htmlspecialchars($row["mname"]) : "N/A" ?></h5>
                                        <h5 class="fs-6 fw-bold"><?= isset($row["jobTitle"]) ? htmlspecialchars($row["jobTitle"]) : "N/A" ?></h5>
                                        <h5 class="fs-6 fw-bold"><?= isset($row["department"]) ? htmlspecialchars($row["department"]) : "N/A" . " DEPARTMENT" ?></h5>
                                        <h5 class="fs-6 fw-bold"><?= "Status: " . htmlspecialchars($row["status"]) ?></h5>
                                    </div>
                            </div>
                            <div class="informationSide col-12 col-md-8 d-flex px-4 flex-row flex-wrap rounded-1 justify-content-start align-items-start" style="height: 100%;">
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
                                        <input type="text" name="jobTitle" class="form-control" id="jobTitle" value="<?= isset($row["jobTitle"]) ? htmlspecialchars($row["jobTitle"]) : "N/A" ?>">
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
                                        <input type="number" name="salary" class="form-control" id="salary" value="<?= isset($row["salary"]) ? htmlspecialchars($row["salary"]) : "N/A" ?>">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="from" class="fw-bold">Salary Range From</label>
                                        <input type="number" name="salary_Range_From" class="form-control" id="from" value="<?= isset($row["salary_Range_From"]) ? htmlspecialchars($row["salary_Range_From"]) : "N/A" ?>">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="to" class="fw-bold">Salary Range To</label>
                                        <input type="number" name="salary_Range_To" class="form-control" id="to" value="<?= isset($row["salary_Range_To"]) ? htmlspecialchars($row["salary_Range_To"]) : "N/A" ?>">
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
                                        <input type="text" name="scheduleFrom" class="form-control" id="city_muntinlupa" value="<?= isset($row["secheduleFrom"]) ? htmlspecialchars($row["secheduleFrom"]) : "N/A" ?>">
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
                                        <input type="text" name="city_muntinlupa" class="form-control" id="city_muntinlupa" value="<?= isset($row["secheduleFrom"]) ? htmlspecialchars($row["secheduleFrom"]) : "N/A" ?>">
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