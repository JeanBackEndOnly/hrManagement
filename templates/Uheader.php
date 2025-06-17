<?php
require_once '../../installer/session.php';
require_once '../../auth/view.php';
require_once '../../auth/control.php';

$infoEmployeeV = validatedEmployee();
$validated = $infoEmployeeV["valitedEmployee"];
$infoEmployeeR = requestEmployee();
$requestEmployee = $infoEmployeeR["requestEmployee"];
$infoEmployeeRj = rejectEmployee();
$rejectEmployees = $infoEmployeeRj["rejectEmployee"];
$profileReq = getProfileEinfo();
$reqProfInfo = $profileReq["reqProfInfo"];
$Fam = getFamilyBG();
$getFam = $Fam["getFam"];
$validated = getValidatedCountDashboard();
$validatedCount = $validated["validatedCount"];
$pending = getPendingCountDashboard();
$pendingCount = $pending["pendingCount"];
// ================== EMPLOYEE INFO ================== //
$employee = getEmployee();
$employeeInfo = $employee["employeeInfo"];



$educData = getEducationalBG();
$getEduc = $educData['getEduc'] ?? [
    'elementary' => null,
    'high_school' => null,
    'senior_high' => null,
    'college' => null,
    'graduate' => null,
];

$currentUrl = strtok($_SERVER["REQUEST_URI"], '?');

// =============== EMPLOYEE VALIDATED ======================== //
$validatedPage        = getCurrentPage();
$validatedPerPage     = getPerPage();
$validatedSortColumn  = getSortColumn('sort', 'add_at');
$validatedSortOrder   = getSortOrder('order', 'desc');

$validatedTotalRows   = getValidatedEmployeesCount(); 
$validatedTotalPages  = ceil($validatedTotalRows / $validatedPerPage);
$validatedPage        = max(1, min($validatedPage, $validatedTotalPages));

$validatedOffset      = ($validatedPage - 1) * $validatedPerPage;
$validated            = getValidatedEmployees($validatedPerPage, $validatedOffset, $validatedSortColumn, $validatedSortOrder); 

// ==================== EMPLOYEE REQUEST ====================== //
$requestPage        = getCurrentPage();
$requestPerPage     = getPerPage();
$requestSortColumn  = getSortColumn('sort', 'add_at');
$requestSortOrder   = getSortOrder('order', 'desc');

$requestTotalRows   = getRequestEmployeesCount(); 
$requestTotalPages  = ceil($requestTotalRows / $requestPerPage);
$requestPage        = max(1, min($requestPage, $requestTotalPages));

$requestOffset      = ($requestPage - 1) * $requestPerPage;
$request            = getRequestEmployees($requestPerPage, $requestOffset, $requestSortColumn, $requestSortOrder);

// ==================== EMPLOYEE REJECTED ====================== //
$rejectedPage        = getCurrentPage();
$rejectedPerPage     = getPerPage();
$rejectedSortColumn  = getSortColumn('sort', 'add_at');
$rejectedSortOrder   = getSortOrder('order', 'desc');

$rejectedTotalRows   = getRejectedEmployeesCount(); 
$rejectedTotalPages  = ceil($rejectedTotalRows / $rejectedPerPage);
$rejectedPage        = max(1, min($rejectedPage, $rejectedTotalPages));

$rejectedOffset      = ($rejectedPage - 1) * $rejectedPerPage;
$rejected            = getRejectedEmployees($rejectedPerPage, $rejectedOffset, $rejectedSortColumn, $rejectedSortOrder);

// =================== JOB TITLE ============================ //
$jobPage        = getCurrentPage();
$jobPerPage     = getPerPage();
$jobSortColumn  = getSortColumn('sort', 'addAt');
$jobSortOrder   = getSortOrder('order', 'desc');

$jobTotalRows   = getJobTitlesCount(); 
$jobTotalPages  = ceil($jobTotalRows / $jobPerPage);
$jobPage        = max(1, min($jobPage, $jobTotalPages));

$jobOffset      = ($jobPage - 1) * $jobPerPage;
$jobTitles      = getJobTitles($jobPerPage, $jobOffset, $jobSortColumn, $jobSortOrder); 

// ===================== PROMOTION ====================== //
$empPage        = getCurrentPage('emp_page');                    
$empPerPage     = getPerPage('emp_perPage');                      
$empSortColumn  = getSortColumn('emp_sort', 'created_date');      
$empSortOrder   = getSortOrder('emp_order', 'desc');

$empTotalRows   = getValidatedCount();
$empTotalPages  = ceil($empTotalRows / $empPerPage);
$empPage        = max(1, min($empPage, $empTotalPages));

$empOffset      = ($empPage - 1) * $empPerPage;
$validated      = getValidatedEmployees($empPerPage, $empOffset, $empSortColumn, $empSortOrder);


    // ========= NOTIFICATIONS ========= //
    $AddJobModal = false;
    $DeleteJobModal = false;
    $JobExistModal = false;
    $JobTitleExdit = false;
    $acceptEmployee = false;
    $rejectEmployee = false;
    $updateReq = false;
    $updateReqFailed = false;
    $updateVal = false;
    $updateValFailed = false;
    $deleteValidatedEmployee = false;
    $upsertSuccess = false;
    $upsertFailed = false;
    $promotion = false;
    if (isset($_GET['job']) && $_GET['job'] === 'success') {
        $AddJobModal = true;
    }elseif(isset($_GET['deleteJob']) && $_GET['deleteJob'] === 'success'){
        $DeleteJobModal = true;
    }elseif(isset($_GET['JobTitleExdit']) && $_GET['JobTitleExdit'] === 'success'){
        $JobTitleExdit = true;
    }elseif(isset($_GET['Job']) && $_GET['Job'] === 'exist'){
        $JobExistModal = true;
    }elseif(isset($_GET['acceptEmployee']) && $_GET['acceptEmployee'] === 'success'){
        $acceptEmployee = true;
    }elseif(isset($_GET['rejectEmployee']) && $_GET['rejectEmployee'] === 'success'){
        $rejectEmployee = true;
    }elseif(isset($_GET['deleteValidatedEmployee']) && $_GET['deleteValidatedEmployee'] === 'success'){
        $deleteValidatedEmployee = true;
    }elseif(isset($_GET['updateReq']) && $_GET['updateReq'] === 'success'){
        $updateReq = true;
    }elseif(isset($_GET['updateReqFailed']) && $_GET['updateReqFailed'] === 'failed'){
        $updateReqFailed = true;
    }elseif(isset($_GET['updateVal']) && $_GET['updateVal'] === 'success'){
        $updateVal = true;
    }elseif(isset($_GET['updateValFailed']) && $_GET['updateValFailed'] === 'failed'){
        $updateValFailed = true;
    }elseif(isset($_GET['upsert']) && $_GET['upsert'] === 'success'){
        $upsertSuccess = true;
    }elseif(isset($_GET['upsert']) && $_GET['upsert'] === 'failed'){
        $upsertFailed = true;
    }elseif(isset($_GET['promotion']) && $_GET['promotion'] === 'success'){
        $promotion = true;
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?= $_SESSION['csrf_token'] ?>">
    <title>PUERICULTURE SYSTEM</title>
    <link rel="manifest" href="../../webApp/manifest.json">
    <link rel="stylesheet" href="../../assets/css/all.min.css?v=<?php echo time() ?>">
    <link rel="stylesheet" href="../../assets/css/users.css?v=<?php echo time() ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="../../assets/js/hr/hrmain.js" defer></script>
    <!-- <base href="http://192.168.1.21/"> -->
    <style>
        body, main {
            font-family: 'Poppins', sans-serif;
        }
    </style>

    <script>
        const AddJobModal = <?php echo json_encode($AddJobModal); ?>;
        const DeleteJobModal = <?php echo json_encode($DeleteJobModal); ?>;
        const JobTitleExdit = <?php echo json_encode($JobTitleExdit); ?>;
        const JobExistModal = <?php echo json_encode($JobExistModal); ?>;
        const acceptEmployee = <?php echo json_encode($acceptEmployee); ?>;
        const rejectEmployee = <?php echo json_encode($rejectEmployee); ?>;
        const deleteValidatedEmployee = <?php echo json_encode($deleteValidatedEmployee); ?>;
        const updateReq = <?php echo json_encode($updateReq); ?>;
        const updateReqFailed = <?php echo json_encode($updateReqFailed); ?>;
        const updateVal = <?php echo json_encode($updateVal); ?>;
        const updateValFailed = <?php echo json_encode($updateValFailed); ?>;
        const upsertSuccess = <?php echo json_encode($upsertSuccess); ?>;
        const upsertFailed = <?php echo json_encode($upsertFailed); ?>;
        const promotion = <?php echo json_encode($promotion); ?>;
    </script>

</head>
<body class="body h-100" style="min-width:100vw;">
