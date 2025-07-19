<?php include '../../templates/Uheader.php';  include '../../templates/HN.php';?>
<style>
    @media (max-width: 576px) {
    /* General adjustments */
    .main-body {
        overflow-x: auto;
    }
    
    .usersButton span.fw-bold {
        display: none;
    }
    
    .usersButton a {
        margin-left: 5px !important;
    }
    
    .sideNav i {
        margin-right: 0 !important;
    }
    
    .contents {
        padding: 5px !important;
    }
    
    .linkToEmployeeManagement {
        margin-top: 10px !important;
        margin-bottom: 10px !important;
    }
    
    .stepper {
        flex-wrap: wrap;
        justify-content: center;
    }
    
    .step {
        width: 25px;
        height: 25px;
        font-size: 12px;
    }
    
    .lines {
        width: 15px;
    }
    
    /* Tables */
    .table-responsive {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        width: 20rem;
    }
    
    table {
        font-size: 12px;
    }
    
    th, td {
        padding: 4px !important;
    }
    
    /* Form inputs */
    .form-control {
        font-size: 12px;
        padding: 4px 8px;
        width: auto;
    }
    
    textarea.form-control {
        min-height: 60px;
    }
    
    /* Radio buttons and checkboxes */
    .form-check {
        margin-right: 5px !important;
    }
    
    .form-check-label {
        font-size: 12px;
    }
    
    /* Buttons */
    .btn {
        font-size: 12px;
        padding: 5px 10px;
    }
    
    /* Modal */
    .modal-dialog {
        margin: 10px;
    }
    
    /* Specific table adjustments */
    #personal-info th,
    #family-bg th,
    #education-table th,
    #work-experience th,
    #seminar-training th,
    #others-section th {
        font-size: 11px;
        white-space: nowrap;
    }
    
    /* Hide less important columns on small screens */
    #education-table th:nth-child(4),
    #education-table td:nth-child(4) {
        display: none;
    }
    
    #work-experience th:nth-child(4),
    #work-experience td:nth-child(4) {
        display: none;
    }
    
    /* Signature section */
    #declaration-section td {
        padding: 2px !important;
    }
    
    #declaration-section .border {
        height: 50px !important;
    }
    
    #declaration-section small {
        font-size: 10px;
    }
    
    /* Navigation buttons */
    .nextButtons, .backsButtons {
        flex-wrap: wrap;
    }
    
    .nextButtons button, 
    .backsButtons button {
        margin: 3px;
    }
    
    /* Loading animation */
    .loading-lines .line {
        width: 20px;
        height: 3px;
    }
}
</style>
<?php if (isset($_GET['open_pdf']) && $_GET['open_pdf'] == '1') : ?>
<script>
    window.onload = function () {
        window.open('pdsPDF.php?users_id=<?php echo $_GET["users_id"]; ?>&pds_id=<?php echo $getPds_id["pds_id"]; ?>', '_blank');
    };
</script>
<?php endif;  ?>
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
                <a href="../logout.php"><i class="fa-solid fa-right-from-bracket ms-3 me-1"></i></a>
                <a href="profile.php?users_id=<?php echo $_SESSION["user_id"]??'no'; ?>" class="align-items-center m-0" style="text-decoration: none; color: #000;" type="button" onclick="userButton()">
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
                        <li class="my-1"><a href="reports.php"  class="d-flex justify-content-start"><i class="fa-solid me-1 fa-briefcase"></i><p style="display:flex;" id="pNone" class="text-start">REPORTS</p></a></li>
                        <li class="my-1"><a href="pds.php"  class="d-flex justify-content-start"><i class="fa-solid me-1 d-flex align-items-center fa-file-export"></i><p style="display:flex;" id="pNone" class="text-start">PDS</p></a></li>
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
                <div class="linkToEmployeeManagement d-flex flex-row align-items-center justify-content-end p-0 m-0 my-3" style="width: 95%; height: 5rem !important;">
                    <a class="btn btn-primary" href="pds.php?users_id=<?php echo $_SESSION["user_id"] ?>&open_pdf=1">Create PDF</a>
                </div>
                <div class="contents d-flex flex-column align-items-center p-3 m-0 col-md-11 shadow rounded-2" style="height: auto;">
                     <div class="stepper" id="stepOne" style="display:flex;">
                        <div class="step active">1</div>
                        <div class="lines"></div>
                        <div class="step">2</div>
                        <div class="lines"></div>
                        <div class="step">3</div>
                        <div class="lines"></div>
                        <div class="step">4</div>
                    </div>
                    <div class="stepper" id="stepTwo" style="display:none;">
                        <div class="step">1</div>
                        <div class="lines"></div>
                        <div class="step active">2</div>
                        <div class="lines"></div>
                        <div class="step">3</div>
                        <div class="lines"></div>
                        <div class="step">4</div>
                    </div>
                    <div class="stepper" id="stepThree" style="display:none;">
                        <div class="step">1</div>
                        <div class="lines"></div>
                        <div class="step">2</div>
                        <div class="lines"></div>
                        <div class="step active">3</div>
                        <div class="lines"></div>
                        <div class="step">4</div>
                    </div>
                    <div class="stepper" id="stepFour" style="display:none;">
                        <div class="step">1</div>
                        <div class="lines"></div>
                        <div class="step">2</div>
                        <div class="lines"></div>
                        <div class="step">3</div>
                        <div class="lines"></div>
                        <div class="step active">4</div>
                    </div>
                    <form action="../../auth/authentications.php" method="post" class="col-md-12">
                        <input type="hidden" name="employeeSidePDS" value="true">
                        <?php isset($_SESSION["csrf_token"]) && $_SESSION["csrf_token"] !== "" ? $csrf = $_SESSION["csrf_token"] : " null "; ?>
                        <input type="hidden" name="csrf_token" value="<?php echo $csrf; ?>">
                        <input type="hidden" name="users_id" value="<?php echo $_SESSION["user_id"] ?? ''; ?>">
                        <!-- ============================== PERSONAL INFORMATION ========================================= -->
                        <div id="personalInfo" class="personalInfo flex-row align-items-center p-0 m-0 mt-3 flex-wrap col-md-12 gap-1" style="display: flex; height: auto;">
                            <div class="table-responsive mb-4 col-md-12">
                                <table class="table table-bordered table-sm align-middle" id="personal-info">
                                    <thead class="table-light">
                                    <tr>
                                        <th colspan="4" class="text-start">PERSONAL INFORMATION</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    <tr>
                                        <th class="fw-bold">SURNAME</th>
                                        <td><input type="text" class="form-control" name="lname" value="<?php echo $employeeInfo["lname"]; ?>"></td>
                                        <th class="fw-bold">NICKNAME</th>
                                        <td><input type="text" class="form-control" name="nickname" value="<?php echo $employeeInfo["nickname"]; ?>"></td>
                                    </tr>

                                    <tr>
                                        <th class="fw-bold">FIRST NAME</th>
                                        <td colspan="3"><input type="text" class="form-control" name="fname" value="<?php echo $employeeInfo["fname"]; ?>"></td>
                                    </tr>

                                    <tr>
                                        <th class="fw-bold">MIDDLE NAME</th>
                                        <td><input type="text" class="form-control" name="mname" value="<?php echo $employeeInfo["mname"]; ?>"></td>
                                        <th class="fw-bold">NAME EXTENSION</th>
                                        <td><input type="text" class="form-control" name="suffix"  value="<?php echo $employeeInfo["suffix"]; ?>"></td>
                                    </tr>

                                    <tr>
                                        <th class="fw-bold">DATE OF BIRTH</th>
                                        <td><input type="date" class="form-control" name="birthday" value="<?php echo $employeeInfo["birthday"]; ?>"></td>
                                        <th class="fw-bold">PLACE OF BIRTH</th>
                                        <td><input type="text" class="form-control" name="birthPlace" value="<?php echo $employeeInfo["birthPlace"]; ?>"></td>
                                    </tr>

                                    <tr>
                                        <th class="fw-bold">RESIDENTIAL ADDRESS</th>
                                        <td colspan="3"><textarea class="form-control" name="res_address" rows="2">
                                           <?php 
                                            echo $employeeInfo["houseBlock"] ?? ''; 
                                            echo ' ';
                                            echo $employeeInfo["street"] ?? ''; 
                                            echo ' ';
                                            echo $employeeInfo["subdivision"] ?? ''; 
                                            echo ' ';
                                            echo $employeeInfo["barangay"] ?? ''; 
                                            echo ' ';
                                            echo $employeeInfo["city_muntinlupa"] ?? ''; 
                                            echo ' ';
                                            echo $employeeInfo["province"] ?? ''; 
                                            echo ' ';
                                            echo $employeeInfo["zip_code"] ?? ''; 
                                           ?>
                                        </textarea></td>
                                    </tr>

                                    <tr>
                                        <th class="fw-bold">AGE</th>
                                        <td><input type="number" class="form-control" name="age" min="0" value="<?php echo $employeeInfo["age"]; ?>"></td>
                                        <th class="fw-bold">ZIP CODE</th>
                                        <td><input type="text" class="form-control" name="zip_code" value="<?php echo $employeeInfo["zip_code"]; ?>"></td>
                                    </tr>

                                    <tr>
                                        <th class="fw-bold">GENDER</th>
                                        <td><input type="text" class="form-control" name="gender" value="<?php echo $employeeInfo["gender"]; ?>"></td>
                                        <th class="fw-bold">TELEPHONE NO.</th>
                                        <td><input type="number" class="form-control" name="tel_no" value="<?= htmlspecialchars($getPersonalData['otherInfo']['tel_no'] ?? '') ?>"></td>
                                    </tr>

                                    <tr>
                                        <th class="fw-bold">CIVIL STATUS</th>
                                        <td><input type="text" class="form-control" name="civil_status" value="<?php echo $employeeInfo["civil_status"]; ?>"></td>
                                        <th class="fw-bold">CELLPHONE NO.</th>
                                        <td><input type="number" class="form-control" name="contact" value="<?php echo $employeeInfo["contact"]; ?>"></td>
                                    </tr>

                                    <tr>
                                        <th class="fw-bold">CITIZENSHIP</th>
                                        <td><input type="text" class="form-control" name="citizenship" value="<?php echo $employeeInfo["citizenship"]; ?>"></td>
                                        <th class="fw-bold">EMAIL ADDRESS</th>
                                        <td><input type="email" class="form-control" name="email" value="<?php echo $employeeInfo["email"]; ?>"></td>
                                    </tr>

                                    <tr>
                                        <th class="fw-bold">RELIGION</th>
                                        <td><input type="text" class="form-control" name="religion" value="<?php echo $employeeInfo["religion"]; ?>"></td>
                                        <th class="fw-bold">PAG‑IBIG NO.</th>
                                        <td><input type="text" class="form-control" name="pagibig_no" value="<?= htmlspecialchars($getPersonalData['userGovIDs']['pagibig_no'] ?? '') ?>"></td>
                                    </tr>

                                    <tr>
                                        <th class="fw-bold">HEIGHT (m)</th>
                                        <td><input type="number" class="form-control" name="height" value="<?= htmlspecialchars($getPersonalData['otherInfo']['height'] ?? '') ?>"></td>
                                        <th class="fw-bold">WEIGHT (kg)</th>
                                        <td><input type="number" class="form-control" name="weight" value="<?= htmlspecialchars($getPersonalData['otherInfo']['weight'] ?? '') ?>"></td>
                                    </tr>

                                    <tr>
                                        <th class="fw-bold">PHILHEALTH NO.</th>
                                        <td><input type="text" class="form-control"  value="<?= htmlspecialchars($getPersonalData['userGovIDs']['philhealth_no'] ?? '') ?>" name="philhealth_no"></td>
                                        <th class="fw-bold">BLOOD TYPE</th>
                                        <td><input type="text" class="form-control"  value="<?= htmlspecialchars($getPersonalData['otherInfo']['blood_type'] ?? '') ?>" name="blood_type"></td>
                                    </tr>

                                    <tr>
                                        <th class="fw-bold">SSS NO.</th>
                                        <td><input type="text" class="form-control"  value="<?= htmlspecialchars($getPersonalData['userGovIDs']['sss_no'] ?? '') ?>" name="sss_no"></td>
                                        <th class="fw-bold">TIN NO.</th>
                                        <td><input type="text" class="form-control" value="<?= htmlspecialchars($getPersonalData['userGovIDs']['tin_no'] ?? '') ?>" name="tin_no"></td>
                                    </tr>

                                    <tr>
                                        <th class="fw-bold" style="font-size:12px;">IN CASE OF EMERGENCY CALL</th>
                                        <td colspan="3"><input type="text" class="form-control"  value="<?= htmlspecialchars($getPersonalData['otherInfo']['emergency_contact'] ?? '') ?>" name="emergency_contact"></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- ============================== DAMILY BACKGROUND ========================================= -->
                        <div id="familyBackground" class="familyBackground flex-row align-items-center p-0 m-0 mt-3 flex-wrap col-md-12 gap-1" style="display: none; height: auto;">
                            <div class="table-responsive col-md-12">
                                <table id="family-bg" class="table table-bordered align-middle table-sm">
                                    <thead class="table-light text-center">
                                    <tr>
                                        <th colspan="4" class="fw-bold">FAMILY BACKGROUND</th>
                                    </tr>
                                    <tr>
                                        <th style="width:30%;">&nbsp;</th>
                                        <th style="width:25%;">&nbsp;</th>
                                        <th style="width:30%;">NAME OF CHILD <br><small>(write full name & list all)</small></th>
                                        <th style="width:15%;">DATE OF BIRTH</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    <?php
                                    $spouseRow = $getPersonalData['spouseInfo'] ?? []; 
                                    $spousePad = [
                                        'spouse_surname'          => '',
                                        'spouse_first'            => '',
                                        'spouse_middle'           => '',
                                        'spouse_occupation'       => '',
                                        'spouse_employer'         => '',
                                        'spouse_business_address' => '',
                                        'spouse_tel'              => '',
                                    ];
                                    $spouse = array_merge($spousePad, $spouseRow);

                                    $kids = $getPersonalData['children'] ?? [];   

                                    for ($i = 1; $i <= 7; $i++) {
                                        $row = $kids[$i - 1] ?? [];       

                                        $childPad = ['id'=>0,'full_name'=>'','dob'=>''];
                                        $kid      = array_merge($childPad, $row);

                                        $name = $kid['full_name'] ?? $kid['child_name'] ?? '';
                                        $dob  = $kid['dob']       ?? $kid['child_dob']  ?? '';

                                        $labels = [
                                            1 => ['SPOUSE’S SURNAME',        'spouse_surname'],
                                            2 => ['FIRST NAME',              'spouse_first'],
                                            3 => ['MIDDLE NAME',             'spouse_middle'],
                                            4 => ['OCCUPATION',              'spouse_occupation'],
                                            5 => ['EMPLOYER / BUS. NAME',    'spouse_employer'],
                                            6 => ['BUSINESS ADDRESS',        'spouse_business_address'],
                                            7 => ['TELEPHONE NO.',           'spouse_tel'],
                                        ];

                                        [$labelText, $fieldName] = $labels[$i];
                                    ?>
                                        <input type="hidden" name="child_id_<?= $i ?>" value="<?= $kid['id'] ?>">

                                        <tr>
                                            <td class="line-label"><?= $labelText ?></td>
                                            <td>
                                                <input class="form-control"
                                                    name="<?= $fieldName ?>"
                                                    value="<?= htmlspecialchars($spouse[$fieldName]) ?>">
                                            </td>

                                            <td>
                                                <input class="form-control"
                                                    name="child_name_<?= $i ?>"
                                                    value="<?= htmlspecialchars($name) ?>">
                                            </td>

                                            <td>
                                                <input class="form-control" type="date"
                                                    name="child_dob_<?= $i ?>"
                                                    value="<?= htmlspecialchars($dob) ?>">
                                            </td>
                                        </tr>
                                    <?php }   ?>


                                    <tr><td colspan="4" class="bg-white p-1"></td></tr>
                                    <?php
                                    $rows    = $getPersonalData['parents'] ?? [];  
                                    $father  = [];
                                    $mother  = [];

                                    foreach ($rows as $r) {
                                        if (strcasecmp($r['relation'] ?? '', 'Father') === 0) {
                                            $father = $r;
                                        } elseif (strcasecmp($r['relation'] ?? '', 'Mother') === 0) {
                                            $mother = $r;
                                        }
                                    }
                                    $pad = [
                                        'id'          => 0,
                                        'surname'     => '',
                                        'maiden_name' => '',
                                        'first_name'  => '',
                                        'middle_name' => '',
                                        'occupation'  => '',
                                        'address'     => '',
                                    ];

                                    $father = array_merge($pad, $father);
                                    $mother = array_merge($pad, $mother);
                                    ?>

                                    <input type="hidden" name="father_id" value="<?= $father['id'] ?>">
                                    <input type="hidden" name="mother_id" value="<?= $mother['id'] ?>">

                                    <tr>
                                        <td class="line-label">FATHER’S SURNAME</td>
                                        <td><input class="form-control" name="father_surname"
                                                value="<?= htmlspecialchars($father['surname']) ?>"></td>

                                        <td class="line-label">OCCUPATION</td>
                                        <td><input class="form-control" name="father_occupation"
                                                value="<?= htmlspecialchars($father['occupation']) ?>"></td>
                                    </tr>

                                    <tr>
                                        <td class="line-label">FIRST NAME</td>
                                        <td><input class="form-control" name="father_first"
                                                value="<?= htmlspecialchars($father['first_name']) ?>"></td>

                                        <td class="line-label">ADDRESS</td>
                                        <td><input class="form-control" name="father_address"
                                                value="<?= htmlspecialchars($father['address']) ?>"></td>
                                    </tr>

                                    <tr>
                                        <td class="line-label">MIDDLE NAME</td>
                                        <td><input class="form-control" name="father_middle"
                                                value="<?= htmlspecialchars($father['middle_name']) ?>"></td>
                                        <td></td><td></td>
                                    </tr>

                                    <tr>
                                        <td class="line-label fw-bold">MOTHER’S MAIDEN NAME</td>
                                        <td></td>
                                        <td></td><td></td>
                                    </tr>

                                    <tr>
                                        <td class="line-label ps-3">SURNAME</td>
                                        <td><input class="form-control" name="mother_surname"
                                                value="<?= htmlspecialchars($mother['surname']) ?>"></td>

                                        <td class="line-label">OCCUPATION</td>
                                        <td><input class="form-control" name="mother_occupation"
                                                value="<?= htmlspecialchars($mother['occupation']) ?>"></td>
                                    </tr>

                                    <tr>
                                        <td class="line-label ps-3">FIRST NAME</td>
                                        <td><input class="form-control" name="mother_first"
                                                value="<?= htmlspecialchars($mother['first_name']) ?>"></td>

                                        <td class="line-label">ADDRESS</td>
                                        <td><input class="form-control" name="mother_address"
                                                value="<?= htmlspecialchars($mother['address']) ?>"></td>
                                    </tr>

                                    <tr>
                                        <td class="line-label ps-3">MIDDLE NAME</td>
                                        <td><input class="form-control" name="mother_middle"
                                                value="<?= htmlspecialchars($mother['middle_name']) ?>"></td>
                                        <td></td><td></td>
                                    </tr>
                                    <tr><td colspan="4" class="bg-white p-1"></td></tr>

                                    <tr class="table-light text-center">
                                        <th>NAME OF BROTHER / SISTER <br><small>(write in full name & list all from eldest to youngest)</small></th>
                                        <th>AGE</th>
                                        <th>OCCUPATION</th>
                                        <th>ADDRESS</th>
                                    </tr>

                                    <?php
                                    $siblings = $getPersonalData['siblings'] ?? [];  

                                    for ($i = 1; $i <= 8; $i++) {

                                        $row = $siblings[$i - 1] ?? null;

                                        $sid   = $row['id']          ?? 0;       
                                        $name  = $row['full_name']   ?? '';
                                        $age   = $row['age']         ?? '';
                                        $occ   = $row['occupation']  ?? '';
                                        $addr  = $row['address']     ?? '';
                                    ?>
                                    <input type="hidden" name="sibling_id_<?= $i ?>" value="<?= $sid ?>">

                                    <tr>
                                        <td><input class="form-control"
                                                name="sib_name_<?= $i ?>"
                                                value="<?= htmlspecialchars($name) ?>"></td>

                                        <td><input class="form-control"
                                                name="sib_age_<?= $i ?>"
                                                value="<?= htmlspecialchars($age) ?>"></td>

                                        <td><input class="form-control"
                                                name="sib_occ_<?= $i ?>"
                                                value="<?= htmlspecialchars($occ) ?>"></td>

                                        <td><input class="form-control"
                                                name="sib_addr_<?= $i ?>"
                                                value="<?= htmlspecialchars($addr) ?>"></td>
                                    </tr>
                                <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- ============================== Educcation BG and Work Exp ========================================= -->
                        <div id="EducBG_WorkExp" class="EducBG_WorkExp flex-row align-items-start justify-content-start p-0 m-0 mt-3 flex-wrap col-md-12 gap-1" style="display: none; height: auto;">
                            <div class="title w-100">
                                <h4 class="w-100 text-start my-2">PERSONAL INFORMATION</h4>
                            </div>
                            <div class="table-responsive col-md-12">
                            <table class="table table-bordered align-middle mb-3" id="education-table">
                                <thead class="table-light text-center">
                                <tr>
                                    <th style="width:12%;">LEVEL</th>
                                    <th style="width:26%;">NAME&nbsp;OF&nbsp;SCHOOL</th>
                                    <th style="width:24%;">DEGREE / COURSE</th>
                                    <th style="width:26%;">SCHOOL&nbsp;ADDRESS</th>
                                    <th style="width:12%;">YEAR GRADUATED</th>
                                </tr>
                                </thead>

                                <tbody>
                                <?php
                                $rows = $getPersonalData['educationInfo'] ?? [];

                                $find = static function (array $rows, string $level): array {
                                    foreach ($rows as $r) {
                                        if (strcasecmp($r['level'] ?? '', $level) === 0) {
                                            return $r;
                                        }
                                    }
                                    return [];                    
                                };

                                $levels = ['Elementary','Secondary','Vocational','College','Graduate'];
                                $data   = [];
                                $pad = [
                                    'id'             => 0,
                                    'school_name'    => '',
                                    'degree_course'  => '',
                                    'school_address' => '',
                                    'year_grad'      => '',
                                ];

                                foreach ($levels as $lvl) {
                                    $data[$lvl] = array_merge($pad, $find($rows, $lvl));
                                }
                                ?>

                                <input type="hidden" name="edu_elem_id" value="<?= $data['Elementary']['id'] ?>">
                                <tr>
                                    <th class="text-center">ELEMENTARY</th>
                                    <td><input type="text" class="form-control"
                                            name="elem_school"
                                            value="<?= htmlspecialchars($data['Elementary']['school_name']) ?>"></td>

                                    <td><input type="text" class="form-control"
                                            name="elem_course"
                                            value="<?= htmlspecialchars($data['Elementary']['degree_course']) ?>"></td>

                                    <td><input type="text" class="form-control"
                                            name="elem_address"
                                            value="<?= htmlspecialchars($data['Elementary']['school_address']) ?>"></td>

                                    <td><input type="text" class="form-control"
                                            name="elem_year" placeholder="YYYY"
                                            value="<?= htmlspecialchars($data['Elementary']['year_grad']) ?>"></td>
                                </tr>

                                <input type="hidden" name="edu_sec_id" value="<?= $data['Secondary']['id'] ?>">
                                <tr>
                                    <th class="text-center">SECONDARY</th>
                                    <td><input type="text" class="form-control"
                                            name="sec_school"
                                            value="<?= htmlspecialchars($data['Secondary']['school_name']) ?>"></td>

                                    <td><input type="text" class="form-control"
                                            name="sec_course"
                                            value="<?= htmlspecialchars($data['Secondary']['degree_course']) ?>"></td>

                                    <td><input type="text" class="form-control"
                                            name="sec_address"
                                            value="<?= htmlspecialchars($data['Secondary']['school_address']) ?>"></td>

                                    <td><input type="text" class="form-control"
                                            name="sec_year" placeholder="YYYY"
                                            value="<?= htmlspecialchars($data['Secondary']['year_grad']) ?>"></td>
                                </tr>

                                <input type="hidden" name="edu_voc_id" value="<?= $data['Vocational']['id'] ?>">
                                <tr>
                                    <th class="text-center">VOCATIONAL</th>
                                    <td><input type="text" class="form-control"
                                            name="voc_school"
                                            value="<?= htmlspecialchars($data['Vocational']['school_name']) ?>"></td>

                                    <td><input type="text" class="form-control"
                                            name="voc_course"
                                            value="<?= htmlspecialchars($data['Vocational']['degree_course']) ?>"></td>

                                    <td><input type="text" class="form-control"
                                            name="voc_address"
                                            value="<?= htmlspecialchars($data['Vocational']['school_address']) ?>"></td>

                                    <td><input type="text" class="form-control"
                                            name="voc_year" placeholder="YYYY"
                                            value="<?= htmlspecialchars($data['Vocational']['year_grad']) ?>"></td>
                                </tr>

                                <input type="hidden" name="edu_college_id" value="<?= $data['College']['id'] ?>">
                                <tr>
                                    <th class="text-center">COLLEGE</th>
                                    <td><input type="text" class="form-control"
                                            name="college_school"
                                            value="<?= htmlspecialchars($data['College']['school_name']) ?>"></td>

                                    <td><input type="text" class="form-control"
                                            name="college_course"
                                            value="<?= htmlspecialchars($data['College']['degree_course']) ?>"></td>

                                    <td><input type="text" class="form-control"
                                            name="college_address"
                                            value="<?= htmlspecialchars($data['College']['school_address']) ?>"></td>

                                    <td><input type="text" class="form-control"
                                            name="college_year" placeholder="YYYY"
                                            value="<?= htmlspecialchars($data['College']['year_grad']) ?>"></td>
                                </tr>

                                <input type="hidden" name="edu_grad_id" value="<?= $data['Graduate']['id'] ?>">
                                <tr>
                                    <th class="text-center">GRADUATE</th>
                                    <td><input type="text" class="form-control"
                                            name="grad_school"
                                            value="<?= htmlspecialchars($data['Graduate']['school_name']) ?>"></td>

                                    <td><input type="text" class="form-control"
                                            name="grad_course"
                                            value="<?= htmlspecialchars($data['Graduate']['degree_course']) ?>"></td>

                                    <td><input type="text" class="form-control"
                                            name="grad_address"
                                            value="<?= htmlspecialchars($data['Graduate']['school_address']) ?>"></td>

                                    <td><input type="text" class="form-control"
                                            name="grad_year" placeholder="YYYY"
                                            value="<?= htmlspecialchars($data['Graduate']['year_grad']) ?>"></td>
                                </tr>
                                </tbody>
                            </table>
                            </div>

                            <div class="title w-100">
                                <h4 class="w-100 text-start my-2">WORK EXPIRIENCE</h4>
                            </div>
                            <div class="table-responsive mb-4 col-md-12">
                            <table class="table table-bordered align-middle" id="work-experience">
                                <thead class="table-light">
                                <tr>
                                    <th colspan="5" class="text-center">WORK EXPERIENCE</th>
                                </tr>
                                <tr>
                                    <th style="width:20%;">
                                    Inclusive&nbsp;Dates <br><small>(mm/dd/yyyy)</small>
                                    </th>
                                    <th style="width:20%;">Position&nbsp;Title<br><small>(write in full)</small></th>
                                    <th style="width:40%;">Dept. / Agency / Office / Company<br><small>(write in full)</small></th>
                                    <th style="width:20%;">Monthly&nbsp;Salary</th>
                                </tr>
                                </thead>

                                <tbody>
                                <?php
                                $experiences = $getPersonalData['workExperience'] ?? [];

                                for ($i = 1; $i <= 5; $i++) {

                                    $row = $experiences[$i - 1] ?? [];

                                    $id       = $row['id']             ?? 0;
                                    $fromRaw  = $row['date_from']      ?? null;
                                    $toRaw    = $row['date_to']        ?? null;
                                    $position = $row['position_title'] ?? '';
                                    $dept     = $row['department']     ?? '';
                                    $salary   = $row['monthly_salary'] ?? '';

                                    $from = $fromRaw && strpos($fromRaw, '0000-00-00') === false
                                        ? date('Y-m-d', strtotime($fromRaw))
                                        : '';

                                    $to   = $toRaw && strpos($toRaw, '0000-00-00') === false
                                        ? date('Y-m-d', strtotime($toRaw))
                                        : '';

                                    $salary = $salary !== '' && $salary > 0
                                        ? number_format($salary, 2, '.', '')
                                        : '';
                                ?>
                                    <input type="hidden" name="exp_<?= $i ?>_id" value="<?= $id ?>">

                                    <tr>
                                        <td>
                                            <div class="d-flex gap-1">
                                                <input type="date" class="form-control"
                                                    name="exp_<?= $i ?>_from"
                                                    placeholder="From"
                                                    value="<?= htmlspecialchars($from) ?>">

                                                <input type="date" class="form-control"
                                                    name="exp_<?= $i ?>_to"
                                                    placeholder="To"
                                                    value="<?= htmlspecialchars($to) ?>">
                                            </div>
                                        </td>

                                        <td><input type="text" class="form-control"
                                                name="exp_<?= $i ?>_position"
                                                value="<?= htmlspecialchars($position) ?>"></td>

                                        <td><input type="text" class="form-control"
                                                name="exp_<?= $i ?>_department"
                                                value="<?= htmlspecialchars($dept) ?>"></td>

                                        <td><input type="number" class="form-control"
                                                name="exp_<?= $i ?>_salary"
                                                min="0" step="0.01"
                                                value="<?= htmlspecialchars($salary) ?>"></td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                            </div>
                            <div class="table-responsive col-md-12">
                            <table class="table table-bordered align-middle" id="seminar-training">
                                <thead class="table-light">
                                <tr>
                                    <th colspan="3" class="text-center">
                                    SEMINARS / WORKSHOPS / TRAININGS ATTENDED
                                    <br><small>(Use additional sheet of paper if necessary)</small>
                                    </th>
                                </tr>
                                <tr>
                                    <th style="width:25%;">Inclusive&nbsp;Dates</th>
                                    <th style="width:55%;">Title of Seminar / Training</th>
                                    <th style="width:20%;">Place</th>
                                </tr>
                                </thead>

                                <tbody>
                                <?php
                                $seminars = $getPersonalData['seminarsTrainings'] ?? [];

                                for ($i = 1; $i <= 5; $i++) {

                                    $row   = $seminars[$i - 1] ?? [];      
                                    $id    = $row['id']              ?? 0; 
                                    $dates = $row['inclusive_dates'] ?? '';
                                    $title = $row['title']           ?? '';
                                    $place = $row['place']           ?? '';
                                ?>
                                    <input type="hidden" name="seminar_<?= $i ?>_id" value="<?= $id ?>">

                                    <tr>
                                        <td><input type="text" class="form-control"
                                                name="seminar_<?= $i ?>_dates"
                                                placeholder="e.g., Jan – Mar 2024"
                                                value="<?= htmlspecialchars($dates) ?>"></td>

                                        <td><input type="text" class="form-control"
                                                name="seminar_<?= $i ?>_title"
                                                value="<?= htmlspecialchars($title) ?>"></td>

                                        <td><input type="text" class="form-control"
                                                name="seminar_<?= $i ?>_place"
                                                value="<?= htmlspecialchars($place) ?>"></td>
                                    </tr>
                                <?php } ?>

                                </tbody>
                            </table>
                            </div>

                        </div>
                        <!-- ============================== OTHERS ========================================= -->
                        <div id="Others" class="Others flex-row align-items-center p-0 m-0 mt-3 flex-wrap col-md-12 gap-1" style="display: none; height: auto;">
                            <div class="table-responsive mb-3 col-md-12">
                                <table class="table table-bordered table-sm align-middle" id="others-section">
                                    <thead class="table-light text-center">
                                    <tr>
                                        <th colspan="4">OTHERS</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    <?php
                                    $other = $getPersonalData['otherInfo'] ?? [];
                                    ?>
                                        <tr>
                                            <th style="width:25%;">What are your special skills / hobbies?</th>
                                            <td colspan="3">
                                                <textarea class="form-control" name="special_skills" rows="2"><?= htmlspecialchars($other['special_skills'] ?? '') ?></textarea>
                                            </td>
                                        </tr>
                                    <tr>
                                        <th>Do you own / rent the house you live in?</th>
                                        <td colspan="3">
                                            <div class="d-flex flex-wrap gap-3 align-items-center">

                                                <div class="form-check me-2">
                                                    <input class="form-check-input" type="radio" name="house_status"
                                                        id="houseOwned" value="owned"
                                                        <?= (isset($other['house_status']) && $other['house_status'] === 'owned') ? 'checked' : '' ?>>
                                                    <label class="form-check-label" for="houseOwned">Owned</label>
                                                </div>

                                                <div class="form-check me-2">
                                                    <input class="form-check-input" type="radio" name="house_status"
                                                        id="houseRented" value="rented"
                                                        <?= (isset($other['house_status']) && $other['house_status'] === 'rented') ? 'checked' : '' ?>>
                                                    <label class="form-check-label" for="houseRented">Rented</label>
                                                </div>

                                                <span class="align-self-center">If rented, amount per month (PHP):</span>
                                                <input type="number" min="0" class="form-control ms-2" style="max-width:140px;"
                                                    name="rental_amount" value="<?= htmlspecialchars($other['rental_amount'] ?? '') ?>">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Type of House</th>
                                        <td colspan="3">
                                            <div class="d-flex flex-wrap gap-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="house_type"
                                                        id="typeLight" value="light"
                                                        <?= (isset($other['house_type']) && $other['house_type'] === 'light') ? 'checked' : '' ?>>
                                                    <label class="form-check-label" for="typeLight">Light&nbsp;Materials</label>
                                                </div>

                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="house_type"
                                                        id="typeSemi" value="semi_concrete"
                                                        <?= (isset($other['house_type']) && $other['house_type'] === 'semi_concrete') ? 'checked' : '' ?>>
                                                    <label class="form-check-label" for="typeSemi">Semi‑concrete</label>
                                                </div>

                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="house_type"
                                                        id="typeConcrete" value="concrete"
                                                        <?= (isset($other['house_type']) && $other['house_type'] === 'concrete') ? 'checked' : '' ?>>
                                                    <label class="form-check-label" for="typeConcrete">Concrete</label>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                        <tr>
                                            <th>
                                                Who stays with you at home?<br>
                                                <small>(State number of persons &amp; relationship to employee.)</small>
                                            </th>
                                            <td colspan="3">
                                                <textarea class="form-control" name="household_members" rows="2"><?= htmlspecialchars($other['household_members'] ?? '') ?></textarea>
                                            </td>
                                        </tr>

                                        </tbody>
                                    </table>
                                    </div>

                                    <div class="table-responsive">
                                    <table class="table table-bordered table-sm" id="declaration-section">
                                        <tbody>

                                        <tr>
                                            <td colspan="3">
                                                <p class="mb-2" style="font-size:13px;">
                                                    I declare under oath that this Personal Data Sheet has been accomplished by me,
                                                    and is a true, correct and complete statement pursuant to the provisions of
                                                    pertinent laws, rules and regulations of the Republic of the Philippines.<br>
                                                    I also authorize the head/authorized representative to verify/validate the contents
                                                    stated herein. I trust that this information shall remain confidential.
                                                </p>
                                            </td>
                                            <td rowspan="2" class="text-center align-middle" style="width:140px;">
                                                <div class="border p-3" style="height:160px;">PHOTO</div>
                                            </td>
                                        </tr>

                                        <tr class="text-center">
                                            <td style="width:40%;">
                                                <div class="border mb-1" style="height:70px;"></div>
                                                <small>Signature (sign inside the box)</small>
                                            </td>
                                            <td style="width:25%;">
                                                <div class="border mb-1" style="height:70px;"></div>
                                                <small>Right Thumbmark</small>
                                            </td>
                                            <td style="width:25%;">
                                                <div class="border mb-1" style="height:70px;"></div>
                                                <small>Left Thumbmark</small>
                                            </td>
                                        </tr>

                                        <tr>
                                            <th style="width:20%;">Date Accomplished</th>
                                            <td colspan="3">
                                                <input type="date" class="form-control" name="date_accomplished"
                                                    value="<?= htmlspecialchars($other['date_accomplished'] ?? '') ?>">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                        <!-- ============================== SUBMIT MODAL ========================================= -->
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
                        <!-- ============================== BUTTONS ========================================= -->                    
                    <div class="next col-md-12 d-flex justify-content-between">
                        <div class="backsButtons">
                            <button class="btn btn-danger" id="buttonSecondB" onclick="buttonSecondB()" style="display: none;">BACK</button>
                            <button class="btn btn-danger" id="buttonThirdB" onclick="buttonThirdB()" style="display: none;">BACK</button>
                            <button class="btn btn-danger" id="buttonFourthB" onclick="buttonFourthB()" style="display: none;">BACK</button>
                        </div>
                        <div class="nextButtons">
                            <button class="btn btn-success" id="buttonFirstN" onclick="buttonFirstN()" style="display: flex;">NEXT</button>
                            <button class="btn btn-success" id="buttonSecondN" onclick="buttonSecondN()" style="display: none;">NEXT</button>
                            <button class="btn btn-success" id="buttonThirdN" onclick="buttonThirdN()" style="display: none;">NEXT</button>
                            <button type="button" id="updateButtonEBG" class="btn btn-success" style="display: none;" data-bs-toggle="modal" data-bs-target="#updateModalEBG">
                                Update
                            </button>
                        </div>
                    </div>
                </div>
                <?= mediaNavEmployee() ?>
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
<script>
function showLoadingAndRun(callback){
    showLoader();                
    setTimeout(() => {          
        hideLoader();            
        callback();           
    }, 500);
}

function showLoader () { document.getElementById('loadingAnimation').style.display = 'flex'; }
function hideLoader () { document.getElementById('loadingAnimation').style.display = 'none'; }

window.addEventListener('pageshow', hideLoader);

function goToStepTwo(){
    document.getElementById('stepOne'      ).style.display = 'none';
    document.getElementById('personalInfo' ).style.display = 'none';
    document.getElementById('buttonFirstN' ).style.display = 'none';

    document.getElementById('stepTwo'      ).style.display = 'flex';
    document.getElementById('familyBackground').style.display = 'flex';
    document.getElementById('buttonSecondN').style.display = 'flex';
    document.getElementById('buttonSecondB').style.display = 'flex';

    document.getElementById('stepThree'      ).style.display = 'none';
    document.getElementById('EducBG_WorkExp').style.display = 'none';
    document.getElementById('buttonThirdN').style.display = 'none';
    document.getElementById('buttonThirdB').style.display = 'none';

    document.getElementById('stepFour'      ).style.display = 'none';
    document.getElementById('Others').style.display = 'none';
    document.getElementById('updateButtonEBG').style.display = 'none';
    document.getElementById('buttonFourthB').style.display = 'none';
}
function goToStepOne(){
    document.getElementById('stepOne'      ).style.display = 'flex';
    document.getElementById('personalInfo' ).style.display = 'flex';
    document.getElementById('buttonFirstN' ).style.display = 'flex';

    document.getElementById('stepTwo'      ).style.display = 'none';
    document.getElementById('familyBackground').style.display = 'none';
    document.getElementById('buttonSecondN').style.display = 'none';
    document.getElementById('buttonSecondB').style.display = 'none';

    document.getElementById('stepThree'      ).style.display = 'none';
    document.getElementById('EducBG_WorkExp').style.display = 'none';
    document.getElementById('buttonThirdN').style.display = 'none';
    document.getElementById('buttonThirdB').style.display = 'none';

    document.getElementById('stepFour'      ).style.display = 'none';
    document.getElementById('Others').style.display = 'none';
    document.getElementById('updateButtonEBG').style.display = 'none';
    document.getElementById('buttonFourthB').style.display = 'none';
}
function goToStepThree(){
    document.getElementById('stepOne'      ).style.display = 'none';
    document.getElementById('personalInfo' ).style.display = 'none';
    document.getElementById('buttonFirstN' ).style.display = 'none';

    document.getElementById('stepTwo'      ).style.display = 'none';
    document.getElementById('familyBackground').style.display = 'none';
    document.getElementById('buttonSecondN').style.display = 'none';
    document.getElementById('buttonSecondB').style.display = 'none';

    document.getElementById('stepThree'      ).style.display = 'flex';
    document.getElementById('EducBG_WorkExp').style.display = 'flex';
    document.getElementById('buttonThirdN').style.display = 'flex';
    document.getElementById('buttonThirdB').style.display = 'flex';

    document.getElementById('stepFour'      ).style.display = 'none';
    document.getElementById('Others').style.display = 'none';
    document.getElementById('buttonFourthB').style.display = 'none';
    document.getElementById('updateButtonEBG').style.display = 'none';
}
function goToStepFour(){
    document.getElementById('stepOne'      ).style.display = 'none';
    document.getElementById('personalInfo' ).style.display = 'none';
    document.getElementById('buttonFirstN' ).style.display = 'none';

    document.getElementById('stepTwo'      ).style.display = 'none';
    document.getElementById('familyBackground').style.display = 'none';
    document.getElementById('buttonSecondN').style.display = 'none';
    document.getElementById('buttonSecondB').style.display = 'none';

    document.getElementById('stepThree'      ).style.display = 'none';
    document.getElementById('EducBG_WorkExp').style.display = 'none';
    document.getElementById('buttonThirdN').style.display = 'none';
    document.getElementById('buttonThirdB').style.display = 'none';

    document.getElementById('stepFour'      ).style.display = 'flex';
    document.getElementById('Others').style.display = 'flex';
    document.getElementById('buttonFourthB').style.display = 'flex';
    document.getElementById('updateButtonEBG').style.display = 'flex';
}
function buttonFirstN(){
    showLoadingAndRun(goToStepTwo);
}
function buttonSecondN(){
    showLoadingAndRun(goToStepThree);
}
function buttonThirdN(){
    showLoadingAndRun(goToStepFour);
}
function buttonSecondB(){
    showLoadingAndRun(goToStepOne);
}
function buttonThirdB(){
    showLoadingAndRun(goToStepTwo);
}
function buttonFourthB(){
    showLoadingAndRun(goToStepThree);
}
</script>

<?php include '../../templates/Ufooter.php'?>