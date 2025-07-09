<?php
    require_once '../../installer/session.php';
    require_once '../../installer/config.php';
    $_SESSION["pending_user_id"] ?? '';
    function getEmployee(): array{
        $pdo     = db_connection();
            $user_id = $_SESSION["pending_user_id"] ?? '';
        if (!$user_id) {
            return [];                           
        }

        $sql = "
            SELECT
                *
            FROM users                     AS u
            INNER JOIN userInformations    AS ui  ON ui.users_id  = u.id
            INNER JOIN userHr_Informations AS uhr ON uhr.users_id = u.id
            LEFT  JOIN family_information  AS fi  ON fi.users_id  = u.id
            LEFT  JOIN family_informationAddress AS fia
                                                ON fia.users_id = u.id
            WHERE u.id = :id
            LIMIT 1";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id' => $user_id]);
        $employeeInfo = $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
        $stmt = $pdo->prepare(
            "SELECT level,
                    school_name,
                    course_or_strand,
                    year_started,
                    year_ended,
                    honors
            FROM educational_background
            WHERE users_id = :id"
        );
        $stmt->execute([':id' => $user_id]);
        $educRows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $levels   = ['elementary', 'high_school', 'senior_high', 'college', 'graduate'];
        $getEduc  = array_fill_keys($levels, [
            'school_name'       => '',
            'course_or_strand'  => '',
            'year_started'      => '',
            'year_ended'        => '',
            'honors'            => ''
        ]);

        foreach ($educRows as $row) {
            $getEduc[$row['level']] = $row;        
        }

        return [
            'employeeInfo' => $employeeInfo,
            'getEduc'      => $getEduc
        ];
    }
    function getPersonalData(): array
    {
        $pdo      = db_connection();
            $users_id = (int)($_GET['pending_user_id'] ?? 0);
        
        if (!$users_id) {
            return [];
        }
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $sql = "
            SELECT u.*,
                ui.*,                 -- userInformations
                uhr.*,                -- userHr_Informations
                pds.pds_id
            FROM   users                 AS u
            JOIN   userInformations      AS ui  ON u.id = ui.users_id
            JOIN   userHr_Informations   AS uhr ON u.id = uhr.users_id
            JOIN   personal_data_sheet   AS pds ON u.id = pds.users_id
            WHERE  u.id = :id
            LIMIT  1
        ";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id' => $users_id]);
        $core = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$core) {                       
            return [];
        }

        $pds_id = (int)$core['pds_id'];

        $data = ['user' => $core];

        $oneToOneQueries = [
            'userGovIDs' => "SELECT * FROM userGovIDs  WHERE pds_id = :pid LIMIT 1",
            'spouseInfo' => "SELECT * FROM spouseInfo  WHERE pds_id = :pid LIMIT 1",
            'otherInfo'  => "SELECT * FROM otherInfo   WHERE pds_id = :pid LIMIT 1",
        ];

        foreach ($oneToOneQueries as $key => $sql) {
            $st = $pdo->prepare($sql);
            $st->execute([':pid' => $pds_id]);
            $data[$key] = $st->fetch(PDO::FETCH_ASSOC) ?: [];
        }

        $oneToManyQueries = [
            'children' => "SELECT * FROM children
                        WHERE pds_id = :pid
                        ORDER BY id",

            'parents'  => "SELECT * FROM parents
                        WHERE pds_id = :pid
                        ORDER BY FIELD(relation,'Father','Mother')",

            'siblings' => "SELECT * FROM siblings
                        WHERE pds_id = :pid
                        ORDER BY birth_order",

            'educationInfo' => "SELECT * FROM educationInfo
                                WHERE pds_id = :pid
                                ORDER BY FIELD(level,
                                    'Elementary','Secondary','Vocational',
                                    'College','Graduate')",

            'workExperience' => "SELECT * FROM workExperience
                                WHERE pds_id = :pid
                                ORDER BY id",

            'seminarsTrainings' => "SELECT * FROM seminarsTrainings
                                    WHERE pds_id = :pid
                                    ORDER BY id",
        ];

        foreach ($oneToManyQueries as $key => $sql) {
            $st = $pdo->prepare($sql);
            $st->execute([':pid' => $pds_id]);
            $data[$key] = $st->fetchAll(PDO::FETCH_ASSOC);
        }

        return $data;
    }
    function getPdsId(){
        $pdo = db_connection();
        $users_id = $_SESSION["pending_user_id"] ?? '';
        $query = "SELECT * FROM personal_data_sheet WHERE users_id = :users_id;";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":users_id", $users_id);
        $stmt->execute();
        $getPds_id = $stmt->fetch(PDO::FETCH_ASSOC);
        return ['getPds_id' => $getPds_id];
    }

    $getPersonalData = getPersonalData();
    $pds = getPdsId();
    $getPds_id = $pds["getPds_id"];
    $getEmployee = getEmployee();
    $employeeInfo = $getEmployee["employeeInfo"];
    $pending = false;
    if(isset($_GET['pending']) && $_GET['pending'] === 'pds'){
        $pending = true;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pending</title>
    <link rel="manifest" href="../../webApp/manifest.json">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="theme-color" content="#E72120">
    <link rel="manifest" href="/github/hrManagement/webApp/manifest.json">
    <link rel="stylesheet" href="../../assets/css/all.min.css?v=<?php echo time() ?>">
    <!-- <link rel="stylesheet" href="../../assets/css/pds.css?v=<?php echo time() ?>"> -->
    <link rel="stylesheet" href="../../assets/css/users.css?v=<?php echo time() ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="../../assets/js/hr/hrmain.js" defer></script>
    <script>
        const pending = <?php echo json_encode($pending); ?>;
    </script>
</head>
<body>
<style>
    @media (max-width: 576px) {
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