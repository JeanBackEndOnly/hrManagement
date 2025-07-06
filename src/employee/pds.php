<?php include '../../templates/Uheader.php';?>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['pds'] = $_POST;         
    header('Location: ' . $_SERVER['PHP_SELF'] . '?print=1');
    exit;
}
$pds = $_SESSION['pds'] ?? [];
$printMode = isset($_GET['print']);

function val($name, $default = '') {
    global $pds;
    return htmlspecialchars($pds[$name] ?? $default);
}

function arr($base, $index, $field) {
    global $pds;
    return htmlspecialchars($pds[$base][$index][$field] ?? '');
}
?>
<style>
        body{background:#f7f7f7;}
        .page{background:#fff; width:210mm; min-height:297mm; margin:8mm auto; padding:10mm 14mm; box-shadow:0 0 6px rgba(0,0,0,.18);} /* A4 */
        .section-title{font-weight:700; background:#e9ecef; padding:2px 6px; font-size:.9rem;}
        .tbl-compact td,.tbl-compact th{padding:2px 3px;font-size:.78rem;}
        .form-control,.form-select{font-size:.85rem;padding:4px 6px;height:auto;}
        @media print{body{background:none;} .page{box-shadow:none;margin:0;page-break-after:always;} .no-print{display:none!important;}}
    </style>
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
                    <?php if(!$printMode): ?>
                <div class="container-fluid no-print mt-3 mb-2 text-center">
                    <h3 class="fw-bold">Personal Data Sheet – CSC Form 212 (Rev 2017)</h3>
                </div>
                <!-- Nav tabs for quick navigation -->
                <ul class="nav nav-tabs no-print justify-content-center mb-3" id="pdsTabs" role="tablist">
                    <?php $tabs=[1=>'Personal Info',2=>'Family & Education',3=>'Eligibility & Work',4=>'Others & Declaration'];
                    foreach($tabs as $k=>$label): ?>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link<?=$k==1?' active':''?>" id="tab<?=$k?>-tab" data-bs-toggle="tab" data-bs-target="#tab<?=$k?>" type="button" role="tab">Page <?=$k?><br><small><?=$label?></small></button>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <form method="post">
                <div class="tab-content">
                <?php endif; ?>

                <!-- ================== PAGE 1 – PERSONAL INFORMATION ================== -->
                <div class="<?= $printMode?'page':'tab-pane fade show active' ?>" id="tab1" role="tabpanel">
                    <div class="text-center mb-1"><strong>PERSONAL DATA SHEET</strong><br><small>(Revised 2017)</small></div>
                    <div class="section-title">I. PERSONAL INFORMATION</div>
                    <?php if($printMode): ?>
                        <?php include __DIR__.'/pds_templates/p1_print.php'; ?>
                    <?php else: ?>
                        <?php include __DIR__.'/pds_templates/p1_form.php'; ?>
                    <?php endif; ?>
                </div>

                <!-- ================== PAGE 2 – FAMILY & EDUCATION =================== -->
                <div class="<?= $printMode?'page':'tab-pane fade' ?>" id="tab2" role="tabpanel">
                    <!-- II. FAMILY BACKGROUND -->
                    <div class="section-title">II. FAMILY BACKGROUND</div>
                    <?php if($printMode){include __DIR__.'/pds_templates/p2_family_print.php';}else{include __DIR__.'/pds_templates/p2_family_form.php';} ?>
                    <!-- III. EDUCATIONAL BACKGROUND -->
                    <div class="section-title mt-3">III. EDUCATIONAL BACKGROUND</div>
                    <?php if($printMode){include __DIR__.'/pds_templates/p2_educ_print.php';}else{include __DIR__.'/pds_templates/p2_educ_form.php';} ?>
                </div>

                <!-- ================== PAGE 3 – ELIGIBILITY & WORK =================== -->
                <div class="<?= $printMode?'page':'tab-pane fade' ?>" id="tab3" role="tabpanel">
                    <!-- IV. CIVIL SERVICE ELIGIBILITY -->
                    <div class="section-title">IV. CIVIL SERVICE ELIGIBILITY</div>
                    <?php if($printMode){include __DIR__.'/pds_templates/p3_cselig_print.php';}else{include __DIR__.'/pds_templates/p3_cselig_form.php';} ?>
                    <!-- V. WORK EXPERIENCE -->
                    <div class="section-title mt-3">V. WORK EXPERIENCE</div>
                    <?php if($printMode){include __DIR__.'/pds_templates/p3_work_print.php';}else{include __DIR__.'/pds_templates/p3_work_form.php';} ?>
                </div>

                <!-- ================== PAGE 4 – OTHER INFO & DECLARATION ============= -->
                <div class="<?= $printMode?'page':'tab-pane fade' ?>" id="tab4" role="tabpanel">
                    <!-- VI. VOLUNTARY WORK -->
                    <div class="section-title">VI. VOLUNTARY WORK / INVOLVEMENT IN CIVIC / NGO</div>
                    <?php if($printMode){include __DIR__.'/pds_templates/p4_voluntary_print.php';}else{include __DIR__.'/pds_templates/p4_voluntary_form.php';} ?>
                    <!-- VII. LEARNING & DEVELOPMENT -->
                    <div class="section-title mt-3">VII. LEARNING & DEVELOPMENT (L&D) INTERVENTIONS/TRAINING PROGRAMS ATTENDED</div>
                    <?php if($printMode){include __DIR__.'/pds_templates/p4_ld_print.php';}else{include __DIR__.'/pds_templates/p4_ld_form.php';} ?>
                    <!-- VIII. SPECIAL SKILLS -->
                    <div class="section-title mt-3">VIII. SPECIAL SKILLS / HOBBIES / NON‑ACADEMIC DISTINCTIONS</div>
                    <?php if($printMode){include __DIR__.'/pds_templates/p4_skills_print.php';}else{include __DIR__.'/pds_templates/p4_skills_form.php';} ?>
                    <!-- IX. OTHER INFORMATION -->
                    <div class="section-title mt-3">IX. OTHER INFORMATION</div>
                    <?php if($printMode){include __DIR__.'/pds_templates/p4_otherinfo_print.php';}else{include __DIR__.'/pds_templates/p4_otherinfo_form.php';} ?>
                    <!-- X. QUESTIONS 34‑40, REFERENCES, GOVT ID & DECLARATION -->
                    <?php if($printMode){include __DIR__.'/pds_templates/p4_declaration_print.php';}else{include __DIR__.'/pds_templates/p4_declaration_form.php';} ?>
                </div>

                <?php if(!$printMode): ?>
                </div><!-- tab-content -->
                <div class="container-fluid mt-3 mb-5 no-print text-end">
                    <button class="btn btn-primary px-4">Save & Print</button>
                </div>
                </form>
                <?php else: ?>
                <div class="container-fluid text-center small mt-3">Printed on <?=date('F j, Y, g:i A')?>.</div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</main>
<?php include '../../templates/Ufooter.php'?>