<?php

declare(strict_types=1);
date_default_timezone_set('Asia/Manila');
require_once '../../installer/session.php';
require_once '../../installer/config.php';
require_once '../../auth/view.php';

// ======================== KEEP INTRUDERS OUT ======================== //
if (!isset($_SESSION['user_role'])) {
    header('Location: ../index.php');
    die();
}

    // =========================== Notifications =========================== //
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
    $salary = false;
    $password = false;
    $newNotMatched = false;
    $currentNotMatched = false;
    $passwordAuth = false;
    $passwordAuthFailes = false;
    $username = false;
    $passwordChange = false;
    $code = false;
    $passwordFailed = false;
    $leaveRequest = false;
    $leave = false;

    // =========================== JOB TITLES =========================== //
function getJobTitlesCount(): int {
    $pdo = db_connection();
    try {
        $stmt = $pdo->query("SELECT COUNT(*) FROM jobtitles");
        return (int)$stmt->fetchColumn();
    } catch (PDOException $e) {
        error_log("DB error in getJobTitlesCount: " . $e->getMessage());
        return 0;
    }
}

/**
 * Fetch job titles with pagination and sorting
 *
 * @param int $limit
 * @param int $offset
 * @param string $sortColumn
 * @param string $sortOrder
 * @return array
 */
function getJobTitles(int $limit, int $offset, string $sortColumn, string $sortOrder): array {
    $pdo = db_connection();

    $allowedColumns = ['jobTitle', 'addAt'];
    $allowedOrder = ['asc', 'desc'];

    if (!in_array($sortColumn, $allowedColumns)) $sortColumn = 'addAt';
    if (!in_array(strtolower($sortOrder), $allowedOrder)) $sortOrder = 'desc';

    $sql = "SELECT id, jobTitle, addAt FROM jobtitles ORDER BY $sortColumn $sortOrder LIMIT :limit OFFSET :offset";

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("DB error in getJobTitles: " . $e->getMessage());
        return [];
    }
}

function sortResult(array $result): array {
    $sortColumn = $_GET['sort'] ?? 'addAt';
    $sortOrder = $_GET['order'] ?? 'desc';

    $allowedColumns = ['jobTitle', 'addAt'];
    $allowedOrder = ['asc', 'desc'];

    if (!in_array($sortColumn, $allowedColumns)) $sortColumn = 'addAt';
    if (!in_array($sortOrder, $allowedOrder)) $sortOrder = 'desc';

    if (!empty($result) && is_array($result)) {
        usort($result, function ($a, $b) use ($sortColumn, $sortOrder) {
            $valueA = strtolower($a[$sortColumn]);
            $valueB = strtolower($b[$sortColumn]);

            return $sortOrder === 'asc' ? $valueA <=> $valueB : $valueB <=> $valueA;
        });
    }

    return [
        'sortedResult' => $result,
        'sortColumn' => $sortColumn,
        'sortOrder' => $sortOrder
    ];
}

// ==================== PRMOTION ==================== //
if (!function_exists('getValidatedEmployees')) {
    function getValidatedEmployees(int $limit, int $offset, string $sortColumn, string $sortOrder): array {
        $pdo = db_connection();

        $allowedColumns = ['name', 'jobTitle', 'salary', 'created_date'];
        $allowedOrder = ['asc', 'desc'];

        if (!in_array($sortColumn, $allowedColumns)) $sortColumn = 'created_date';
        if (!in_array(strtolower($sortOrder), $allowedOrder)) $sortOrder = 'desc';

        $orderBy = match ($sortColumn) {
            'name' => "CONCAT(fname, ' ', lname)",
            default => $sortColumn
        };

        $sql = "SELECT id, fname, lname, jobTitle, salary, created_date
                FROM validated 
                ORDER BY $orderBy $sortOrder 
                LIMIT :limit OFFSET :offset";

        try {
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("DB error in getValidatedEmployees: " . $e->getMessage());
            return [];
        }
    }
}


if (!function_exists('getCurrentPage')) {
    function getCurrentPage(): int {
        return isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
    }
}
function getValidatedCount(): int {
    $pdo = db_connection();
    try {
        $stmt = $pdo->query("SELECT COUNT(*) FROM userrequest WHERE status = 'validated'"); 
        return (int)$stmt->fetchColumn();
    } catch (PDOException $e) {
        error_log("DB error in getValidatedCount: " . $e->getMessage());
        return 0;
    }
}

// ==================== Validated Employees ========================== //
function validatedEmployee(){
    $pdo = db_connection();
    $query = "SELECT * FROM users
    INNER JOIN userinformations ON users.id = userinformations.users_id
    INNER JOIN userHr_Informations ON users.id = userHr_Informations.users_id
    INNER JOIN userrequest ON users.id = userrequest.users_id
    WHERE userrequest.status = 'validated'";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $valitedEmployee = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return ['valitedEmployee' => $valitedEmployee];
}

function getValidatedEmployeesCount(): int{
     $pdo = db_connection();
    try {
        $stmt = $pdo->query("SELECT COUNT(*) FROM userrequest WHERE status = 'validated'");
        return (int)$stmt->fetchColumn();
    } catch (PDOException $e) {
        error_log("DB error in getValidatedEmployeesCount: " . $e->getMessage());
        return 0;
    }
}
function getValidatedEmployees(int $limit, int $offset, string $sort, string $order): array {
    $allowedSortColumns = ['id', 'lname', 'email', 'add_at', 'status']; 
    $allowedOrder = ['asc', 'desc'];

    // Validate inputs
    if (!in_array(strtolower($sort), $allowedSortColumns)) {
        $sort = 'lname';
    }
    if (!in_array(strtolower($order), $allowedOrder)) {
        $order = 'desc';
    }

    $pdo = db_connection();

    $query = "
        SELECT *
        FROM users 
        INNER JOIN userInformations ON users.id = userInformations.users_id
        INNER JOIN userHr_Informations ON users.id = userHr_Informations.users_id
        INNER JOIN userrequest ON users.id = userrequest.users_id
        WHERE userrequest.status = 'validated'
        ORDER BY {$sort} {$order}
        LIMIT :limit OFFSET :offset
    ";

    $stmt = $pdo->prepare($query);
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function renderValidatedSortAndPerPageControls(
    string $currentUrl,
    int $validatedPerPage,
    string $validatedSortColumn,
    string $validatedSortOrder
    ): string {
    ob_start();
    ?>
    <div class="count" style="width: 8%;">
        <select class="form-select" onchange="location.href='<?= $currentUrl ?>?perPage=' + this.value + '&sort=<?= $validatedSortColumn ?>&order=<?= $validatedSortOrder ?>'">
            <option disabled>Items</option>
            <option value="10" <?= ($validatedPerPage == 10) ? 'selected' : '' ?>>10</option>
            <option value="20" <?= ($validatedPerPage == 20) ? 'selected' : '' ?>>20</option>
            <option value="50" <?= ($validatedPerPage == 50) ? 'selected' : '' ?>>50</option>
        </select>
    </div>

    <div class="sort" style="width: 8%;">
        <select class="form-select" onchange="location.href='<?= $currentUrl ?>?sort=jobTitle&order=' + this.value + '&perPage=<?= $validatedPerPage ?>'">
            <option selected disabled>Sort</option>
            <option value="asc" <?= ($validatedSortOrder === 'asc') ? 'selected' : '' ?>>A-Z</option>
            <option value="desc" <?= ($validatedSortOrder === 'desc') ? 'selected' : '' ?>>Z-A</option>
            <option value="recent" <?= ($validatedSortOrder === 'recent') ? 'selected' : '' ?>>Recent</option>
        </select>
    </div>
    <?php
    return ob_get_clean();
}

function renderValidatedPaginationControls(
    string $currentUrl,
    int $validatedPage,
    int $validatedTotalPages,
    int $validatedPerPage,
    string $validatedSortColumn,
    string $validatedSortOrder
    ): string {
    ob_start();
    ?>
    <div class="d-flex justify-content-between align-items-center mt-3" style="flex-shrink: 0;">
        <div>
            Page <?= $validatedPage ?> of <?= $validatedTotalPages ?>
        </div>
        <div>
            <a href="<?= $currentUrl ?>?page=<?= max(1, $validatedPage - 1) ?>&perPage=<?= $validatedPerPage ?>&sort=<?= $validatedSortColumn ?>&order=<?= $validatedSortOrder ?>"
               class="btn btn-sm btn-outline-primary <?= ($validatedPage <= 1) ? 'disabled' : '' ?>">Previous</a>

            <a href="<?= $currentUrl ?>?page=<?= min($validatedTotalPages, $validatedPage + 1) ?>&perPage=<?= $validatedPerPage ?>&sort=<?= $validatedSortColumn ?>&order=<?= $validatedSortOrder ?>"
               class="btn btn-sm btn-outline-primary <?= ($validatedPage >= $validatedTotalPages) ? 'disabled' : '' ?>">Next</a>
        </div>
    </div>
    <?php
    return ob_get_clean();
}

// ====================== Employees Request ======================== //
function requestEmployee(){
    $pdo = db_connection();
    $query = "SELECT * FROM users 
    INNER JOIN userinformations ON users.id = userinformations.users_id
    INNER JOIN userHr_Informations ON users.id = userHr_Informations.users_id
    INNER JOIN userrequest ON users.id = userrequest.users_id
    WHERE userrequest.status = 'pending'";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $requestEmployee = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return ['requestEmployee' => $requestEmployee];
}
function getRequestEmployeesCount(): int{
     $pdo = db_connection();
    try {
        $stmt = $pdo->query("SELECT COUNT(*) FROM userrequest WHERE status = 'pending'");
        return (int)$stmt->fetchColumn();
    } catch (PDOException $e) {
        error_log("DB error in getValidatedEmployeesCount: " . $e->getMessage());
        return 0;
    }
}
function getRequestEmployees(int $limit, int $offset, string $sort, string $order): array {
    $allowedSortColumns = ['id', 'lname', 'email', 'add_at', 'status']; 
    $allowedOrder = ['asc', 'desc'];

    // Validate inputs
    if (!in_array(strtolower($sort), $allowedSortColumns)) {
        $sort = 'lname';
    }
    if (!in_array(strtolower($order), $allowedOrder)) {
        $order = 'desc';
    }

    $pdo = db_connection();

    $query = "
        SELECT *
        FROM users 
        INNER JOIN userinformations ON users.id = userinformations.users_id
        INNER JOIN userHr_Informations ON users.id = userHr_Informations.users_id
        INNER JOIN userrequest ON users.id = userrequest.users_id
        WHERE userrequest.status = 'pending'
        ORDER BY {$sort} {$order}
        LIMIT :limit OFFSET :offset
    ";

    $stmt = $pdo->prepare($query);
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function renderRequestSortAndPerPageControls(
    string $currentUrl,
    int $requestPerPage,
    string $requestSortColumn,
    string $requestSortOrder
    ): string {
    ob_start();
    ?>
    <div class="count" style="width: 8%;">
        <select class="form-select" onchange="location.href='<?= $currentUrl ?>?perPage=' + this.value + '&sort=<?= $requestSortColumn ?>&order=<?= $requestSortOrder ?>'">
            <option disabled>Items</option>
            <option value="10" <?= ($requestPerPage == 10) ? 'selected' : '' ?>>10</option>
            <option value="20" <?= ($requestPerPage == 20) ? 'selected' : '' ?>>20</option>
            <option value="50" <?= ($requestPerPage == 50) ? 'selected' : '' ?>>50</option>
        </select>
    </div>

    <div class="sort" style="width: 8%;">
        <select class="form-select" onchange="location.href='<?= $currentUrl ?>?sort=jobTitle&order=' + this.value + '&perPage=<?= $requestPerPage ?>'">
            <option selected disabled>Sort</option>
            <option value="asc" <?= ($requestSortOrder === 'asc') ? 'selected' : '' ?>>A-Z</option>
            <option value="desc" <?= ($requestSortOrder === 'desc') ? 'selected' : '' ?>>Z-A</option>
            <option value="recent" <?= ($requestSortOrder === 'recent') ? 'selected' : '' ?>>Recent</option>
        </select>
    </div>
    <?php
    return ob_get_clean();
}
function renderRequestPaginationControls(
    string $currentUrl,
    int $validatedPage,
    int $validatedTotalPages,
    int $requestPerPage,
    string $requestSortColumn,
    string $requestSortOrder
    ): string {
    ob_start();
    ?>
    <div class="d-flex justify-content-between align-items-center mt-3" style="flex-shrink: 0;">
        <div>
            Page <?= $validatedPage ?> of <?= $validatedTotalPages ?>
        </div>
        <div>
            <a href="<?= $currentUrl ?>?page=<?= max(1, $validatedPage - 1) ?>&perPage=<?= $requestPerPage ?>&sort=<?= $requestSortColumn ?>&order=<?= $requestSortOrder ?>"
               class="btn btn-sm btn-outline-primary <?= ($validatedPage <= 1) ? 'disabled' : '' ?>">Previous</a>

            <a href="<?= $currentUrl ?>?page=<?= min($validatedTotalPages, $validatedPage + 1) ?>&perPage=<?= $requestPerPage ?>&sort=<?= $requestSortColumn ?>&order=<?= $requestSortOrder ?>"
               class="btn btn-sm btn-outline-primary <?= ($validatedPage >= $validatedTotalPages) ? 'disabled' : '' ?>">Next</a>
        </div>
    </div>
    <?php
    return ob_get_clean();
}

// ====================== Employees Rejected ======================== //
function rejectEmployee(){
    $pdo = db_connection();
    $query = "SELECT * FROM users 
    INNER JOIN userinformations ON users.id = userinformations.users_id
    INNER JOIN userHr_Informations ON users.id = userHr_Informations.users_id
    INNER JOIN userrequest ON users.id = userrequest.users_id
    WHERE userrequest.status = 'rejected'";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $rejectEmployee = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return ['rejectEmployee' => $rejectEmployee];
}
function getRejectedEmployeesCount(): int{
     $pdo = db_connection();
    try {
        $stmt = $pdo->query("SELECT COUNT(*) FROM userrequest WHERE status = 'rejected'");
        return (int)$stmt->fetchColumn();
    } catch (PDOException $e) {
        error_log("DB error in getValidatedEmployeesCount: " . $e->getMessage());
        return 0;
    }
}
function getRejectedEmployees(int $limit, int $offset, string $sort, string $order): array {
    $allowedSortColumns = ['id', 'lname', 'email', 'add_at', 'status']; 
    $allowedOrder = ['asc', 'desc'];

    // Validate inputs
    if (!in_array(strtolower($sort), $allowedSortColumns)) {
        $sort = 'lname';
    }
    if (!in_array(strtolower($order), $allowedOrder)) {
        $order = 'desc';
    }

    $pdo = db_connection();

    $query = "
        SELECT *
        FROM users 
        INNER JOIN userinformations ON users.id = userinformations.users_id
        INNER JOIN userHr_Informations ON users.id = userHr_Informations.users_id
        INNER JOIN userrequest ON users.id = userrequest.users_id
        WHERE userrequest.status = 'rejected'
        ORDER BY {$sort} {$order}
        LIMIT :limit OFFSET :offset
    ";

    $stmt = $pdo->prepare($query);
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function renderRejectSortAndPerPageControls(
    string $currentUrl,
    int $rejectedPerPage,
    string $rejectedSortColumn,
    string $rejectedSortOrder
    ): string {
    ob_start();
    ?>
    <div class="count" style="width: 8%;">
        <select class="form-select" onchange="location.href='<?= $currentUrl ?>?perPage=' + this.value + '&sort=<?= $rejectedSortColumn ?>&order=<?= $rejectedSortOrder ?>'">
            <option disabled>Items</option>
            <option value="10" <?= ($rejectedPerPage == 10) ? 'selected' : '' ?>>10</option>
            <option value="20" <?= ($rejectedPerPage == 20) ? 'selected' : '' ?>>20</option>
            <option value="50" <?= ($rejectedPerPage == 50) ? 'selected' : '' ?>>50</option>
        </select>
    </div>

    <div class="sort" style="width: 8%;">
        <select class="form-select" onchange="location.href='<?= $currentUrl ?>?sort=jobTitle&order=' + this.value + '&perPage=<?= $rejectedPerPage ?>'">
            <option selected disabled>Sort</option>
            <option value="asc" <?= ($rejectedSortOrder === 'asc') ? 'selected' : '' ?>>A-Z</option>
            <option value="desc" <?= ($rejectedSortOrder === 'desc') ? 'selected' : '' ?>>Z-A</option>
            <option value="recent" <?= ($rejectedSortOrder === 'recent') ? 'selected' : '' ?>>Recent</option>
        </select>
    </div>
    <?php
    return ob_get_clean();
}
function renderRejectPaginationControls(
    string $currentUrl,
    int $rejectedPage,
    int $rejectedTotalPages,
    int $rejectedPerPage,
    string $rejectedSortColumn,
    string $rejectedSortOrder
    ): string {
    ob_start();
    ?>
    <div class="d-flex justify-content-between align-items-center mt-3" style="flex-shrink: 0;">
        <div>
            Page <?= $rejectedPage ?> of <?= $rejectedTotalPages ?>
        </div>
        <div>
            <a href="<?= $currentUrl ?>?page=<?= max(1, $rejectedPage - 1) ?>&perPage=<?= $rejectedPerPage ?>&sort=<?= $rejectedSortColumn ?>&order=<?= $rejectedSortOrder ?>"
               class="btn btn-sm btn-outline-primary <?= ($rejectedPage <= 1) ? 'disabled' : '' ?>">Previous</a>

            <a href="<?= $currentUrl ?>?page=<?= min($rejectedTotalPages, $rejectedPage + 1) ?>&perPage=<?= $rejectedPerPage ?>&sort=<?= $rejectedSortColumn ?>&order=<?= $rejectedSortOrder ?>"
               class="btn btn-sm btn-outline-primary <?= ($rejectedPage >= $rejectedTotalPages) ? 'disabled' : '' ?>">Next</a>
        </div>
    </div>
    <?php
    return ob_get_clean();
}

// =================== Uheader ========================= //
function getCurrentPage(string $key = 'page'): int {
    return isset($_GET[$key]) && is_numeric($_GET[$key]) && $_GET[$key] > 0 ? (int)$_GET[$key] : 1;
}
function getPerPage(string $key = 'perPage', int $default = 10): int {
    $allowed = [10, 20, 50];
    return isset($_GET[$key]) && in_array((int)$_GET[$key], $allowed) ? (int)$_GET[$key] : $default;
}
function getSortColumn(string $key = 'sort', string $default = 'add_at'): string {
    return $_GET[$key] ?? $default;
}
function getSortOrder(string $key = 'order', string $default = 'desc'): string {
    return $_GET[$key] ?? $default;
}
function toggleOrder(string $currentOrder): string {
    return $currentOrder === 'asc' ? 'desc' : 'asc';
}

// =================== PROFILE ========================= //

function getProfileEinfo(){
    $pdo = db_connection();
    isset($_GET["users_id"]) ? $users_id = $_GET["users_id"] : null;
    $query = " SELECT * FROM users 
    INNER JOIN userinformations ON users.id = userinformations.users_id
    INNER JOIN userHr_Informations ON users.id = userHr_Informations.users_id
    INNER JOIN userrequest ON users.id = userrequest.users_id
    WHERE users.id = :id ";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $users_id);
    $stmt->execute();
    $reqProfInfo = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return ['reqProfInfo' => $reqProfInfo];
}
function getUSersId(){
    $pdo = db_connection();
    isset($_GET["users_id"]) ? $users_id = $_GET["users_id"] : null;
    $query = "SELECT id FROM users
    WHERE id = :id ";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $users_id);
    $stmt->execute();
    $get_users_id = $stmt->fetch(PDO::FETCH_ASSOC);
    return ['get_users_id' => $get_users_id];
}

function getFamilyBG() {
    $pdo = db_connection();
    if (isset($_GET["users_id"])) {
        $users_id = $_GET["users_id"];
    } else {
        return ['getFam' => []]; 
    }

    $query = "SELECT * FROM users
        LEFT JOIN family_information ON users.id = family_information.users_id
        LEFT JOIN family_informationaddress ON users.id = family_informationaddress.users_id
        WHERE users.id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $users_id);
    $stmt->execute();
    $getFam = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    return ['getFam' => $getFam];
}

function getEducationalBG() {
    $pdo = db_connection();

    if (!isset($_GET["users_id"])) {
        return ['error' => 'User ID is missing'];
    }
    $users_id = (int)$_GET["users_id"];

    $queryEduc = "
        SELECT *
        FROM educational_background
        WHERE users_id = :id
        ORDER BY FIELD(level, 'elementary', 'high_school', 'senior_high', 'college', 'graduate')
    ";
    $stmt = $pdo->prepare($queryEduc);
    $stmt->bindParam(":id", $users_id, PDO::PARAM_INT);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $education = [
        'elementary' => null,
        'high_school' => null,
        'senior_high' => null,
        'college' => null,
        'graduate' => null,
    ];

    foreach ($rows as $row) {
        $level = $row['level'];
        if (array_key_exists($level, $education)) {
            $education[$level] = $row;
        }
    }

    return ['getEduc' => $education];
}

// ===================== EMPLOYEE ===================== //
function getEmployee(): array
    {
    $pdo     = db_connection();
    if($_SESSION['user_id'] == 1){
        $user_id = $_GET["users_id"] ?? '';
    }else if($_SESSION["user_id"] != 1){
        $user_id = $_SESSION['user_id'] ?? null;
    }
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

// ===================== DASHBOARD ===================== //
function getValidatedCountDashboard() {
    $pdo = db_connection();
    $query = "SELECT COUNT(*) FROM userrequest WHERE status = 'validated'";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $validatedCount = $stmt->fetchColumn();
    return ['validatedCount' => $validatedCount];
}
function getPendingCountDashboard() {
    $pdo = db_connection();
    $query = "SELECT COUNT(*) FROM userrequest WHERE status = 'pending'";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $pendingCount = $stmt->fetchColumn();
    return ['pendingCount' => $pendingCount];
}

// ======================= SETTINGS ====================== //
function adminHistoryLog(){
    $pdo = db_connection();
    $query = "SELECT * FROM admin_history";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $adminHistory = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return ['adminHistory' => $adminHistory];
} 
function employeeHistoryLog(){
    $pdo = db_connection();
    $employeeID = $_SESSION["user_id"] ?? '';
    $query = "SELECT * FROM employee_history WHERE employee_id = :employee_id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":employee_id", $employeeID);
    $stmt->execute();
    $employeeHistory = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return ['employeeHistory' => $employeeHistory];
} 
// ====================== REPORTS ====================== //

function getReportCount() {
    $pdo = db_connection();
    $query = "SELECT COUNT(*) FROM reports WHERE DATE(report_date) = CURDATE();";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $reportCount = $stmt->fetchColumn();
    return ['reportCount' => $reportCount];
}

$currentReportsUrl = basename($_SERVER['PHP_SELF']); 
$dateFilter = $_GET['dateFilter'] ?? 'all'; 
$whereClause = '';

if ($dateFilter && $dateFilter !== 'all') { 
    switch ($dateFilter) {
        case 'today':
            $whereClause = "WHERE DATE(report_date) = CURDATE()";
            break;
        case 'week':
            $whereClause = "WHERE YEARWEEK(report_date, 1) = YEARWEEK(CURDATE(), 1)";
            break;
        case 'month':
            $whereClause = "WHERE MONTH(report_date) = MONTH(CURDATE()) AND YEAR(report_date) = YEAR(CURDATE())";
            break;
        case 'year':
            $whereClause = "WHERE YEAR(report_date) = YEAR(CURDATE())";
            break;
    }
}

$reportPage        = getCurrentPage('reports_page'); 
$reportsPerPage    = getPerPage('reports_perPage'); 
$reportSortColumn  = getSortColumn('reports_sort', 'report_date'); 
$reportSortOrder   = getSortOrder('reports_order', 'desc'); 

$reportTotalRows   = getReportsCount($whereClause);
$reportTotalPages  = ceil($reportTotalRows / $reportsPerPage);
$reportPage        = max(1, min($reportPage, $reportTotalPages));
$reportOffset      = ($reportPage - 1) * $reportsPerPage;

$reportData = getReports($reportsPerPage, $reportOffset, $reportSortColumn, $reportSortOrder, $whereClause);
function getReportsCount(string $whereClause = ''): int {
    $pdo = db_connection();
    try {
        $stmt = $pdo->query("SELECT COUNT(*) FROM reports $whereClause");
        return (int)$stmt->fetchColumn();
    } catch (PDOException $e) {
        error_log("DB error in getReportsCount: " . $e->getMessage());
        return 0;
    }
}

function getReports(
    int $limit,
    int $offset,
    string $sortColumn,
    string $sortOrder,
    string $whereClause = ''
): array {
    $pdo = db_connection();

    $columnMap = [
        'lname' => 'ui.lname',
        'report_date' => 'r.report_date'
    ];
    $allowedOrder = ['asc', 'desc'];

    $sortColumn = $columnMap[strtolower($sortColumn)] ?? 'r.report_date';
    $sortOrder = in_array(strtolower($sortOrder), $allowedOrder, true) ? $sortOrder : 'desc';

    try {
        $sql = "
            SELECT
                r.*,
                u.username,
                uhr.department,
                ui.lname,
                ui.fname,
                lr.leave_id,
                lr.leaveType,
                lr.leaveDate,
                lr.leaveStatus
            FROM reports r
            INNER JOIN users u ON r.users_id = u.id
            INNER JOIN userInformations ui ON u.id = ui.users_id
            INNER JOIN userHr_Informations uhr ON u.id = uhr.users_id
            LEFT JOIN leaveReq lr ON r.leave_id = lr.leave_id
            $whereClause
            ORDER BY $sortColumn " . strtoupper($sortOrder) . ",
                     r.reportID " . strtoupper($sortOrder) . "
            LIMIT :limit OFFSET :offset
        ";

        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        $reports = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!empty($reports)) {
            $userIds = array_unique(array_column($reports, 'users_id'));
            
            if (!empty($userIds)) {
                $params = [];
                $placeholders = [];
                foreach ($userIds as $i => $userId) {
                    $param = ":user_$i";
                    $placeholders[] = $param;
                    $params[$param] = $userId;
                }
                
                $leaveSql = "
                    SELECT 
                        lr.*,
                        u.username,
                        ui.lname,
                        ui.fname,
                        uhr.department
                    FROM leaveReq lr
                    JOIN users u ON lr.users_id = u.id
                    JOIN userInformations ui ON u.id = ui.users_id
                    JOIN userHr_Informations uhr ON u.id = uhr.users_id
                    WHERE lr.users_id IN (" . implode(',', $placeholders) . ")
                    ORDER BY lr.leaveDate DESC
                ";
                
                $leaveStmt = $pdo->prepare($leaveSql);
                foreach ($params as $param => $value) {
                    $leaveStmt->bindValue($param, $value, PDO::PARAM_INT);
                }
                $leaveStmt->execute();
                $allLeaveRequests = $leaveStmt->fetchAll(PDO::FETCH_ASSOC);
                
                return [
                    'reports' => $reports,
                    'all_leave_requests' => $allLeaveRequests
                ];
            }
        }

        return ['reports' => $reports ?? [], 'all_leave_requests' => []];
        
    } catch (PDOException $e) {
        error_log("Database error in getReports: " . $e->getMessage());
        return ['reports' => [], 'all_leave_requests' => []];
    }
}
// ======================= LEAVE ADMIN SIDE ======================= //

function getEmployeeNames(){
    $pdo = db_connection();
    $users_id = $_GET["users_id"] ?? '';
    $sql = "SELECT * FROM users
    INNER JOIN userInformations ON users.id = userinformations.users_id
    INNER JOIN userHr_Informations ON users.id = userHr_Informations.users_id
    WHERE users.id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":id", $users_id);
    $stmt->execute();
    $employeeName = $stmt->fetch(PDO::FETCH_ASSOC);
    return ['employeeName' => $employeeName];
}
function getLeaveRequest(){
    $pdo = db_connection();
    $users_id = $_GET["users_id"] ?? '';
    $sql = "SELECT * FROM leavereq WHERE users_id = :users_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":users_id", $users_id);
    $stmt->execute();
    $employeeLeave = $stmt->fetch(PDO::FETCH_ASSOC);
    return ['employeeLeave' => $employeeLeave];
}
function leavePending(){
    $pdo = db_connection();
    $users_id = $_GET["users_id"] ?? '';
    $leave_id = $_GET["leave_id"] ?? '';
    $sql = "SELECT * FROM leavereq WHERE users_id = :users_id AND leaveStatus = 'pending' AND leave_id = :leave_id;";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":users_id", $users_id);
    $stmt->bindParam(":leave_id", $leave_id);
    $stmt->execute();
    $leavePending = $stmt->fetch(PDO::FETCH_ASSOC);
    return ['leavePending' => $leavePending];
}
function leaveID(){
    $pdo = db_connection();
    $sql = "SELECT * FROM leavereq;";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $leaveID = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return ['leaveID' => $leaveID];
}

$leaveTab        = $_GET['leave_tab'] ?? 'request';      
$leavePage       = max(1, (int)($_GET['leave_page']  ?? 1));
$leavePerPage    = max(1, (int)($_GET['leave_perPage'] ?? 10));
$leaveSortColumn = $_GET['leave_sort']  ?? 'request_date';
$leaveSortOrder  = strtolower($_GET['leave_order'] ?? 'desc') === 'asc' ? 'asc' : 'desc';

$tabToStatus = [
    'request'     => 'pending',
    'approved'    => 'approved',
    'disapprove' => 'disapprove'  
];
$statusValue = $tabToStatus[$leaveTab] ?? 'pending';

$leaveTotalRows   = leaves_count($statusValue);
$leaveTotalPages  = max(1, (int)ceil($leaveTotalRows / $leavePerPage));
$leavePage        = min($leavePage, $leaveTotalPages);
$leaveOffset      = ($leavePage - 1) * $leavePerPage;

$leaveData = leaves_fetch(
    $statusValue,
    $leavePerPage,
    $leaveOffset,
    $leaveSortColumn,
    $leaveSortOrder
);

/* ───────────────── functions ───────────────── */
/**
 * How many requests are in a given status?
 */
function leaves_count(string $status): int
{
    $pdo = db_connection();
    $sql = "SELECT COUNT(*) FROM leaveReq WHERE leaveStatus = ?";
    try {
        $st = $pdo->prepare($sql);
        $st->execute([$status]);
        return (int) $st->fetchColumn();
    } catch (PDOException $e) {
        error_log("leaves_count: " . $e->getMessage());
        return 0;
    }
}

/**
 * Get a *page* of leave requests or (if $leaveId is given) one exact row.
 *
 * @param string  $status     pending | approved | disapprove
 * @param int     $limit      rows per page
 * @param int     $offset     starting row
 * @param string  $sortColumn lname | request_date | leaveDate
 * @param string  $sortOrder  asc | desc
 * @param int|null $leaveId   OPTIONAL exact leave_id to fetch
 */
function leaves_fetch(
    string  $status,
    int     $limit,
    int     $offset,
    string  $sortColumn,
    string  $sortOrder,
    ?int    $leaveId = null
): array {

    $pdo = db_connection();

    /* --- map safe column names --- */
    $colMap = [
        'lname'        => 'ui.lname',
        'request_date' => 'lr.request_date',
        'leaveDate'    => 'lr.leaveDate'
    ];
    $sortColumn = $colMap[$sortColumn] ?? 'lr.request_date';
    $sortOrder  = strtolower($sortOrder) === 'asc' ? 'ASC' : 'DESC';

    /* --- base query: newest detail row per leave_id --- */
    $sql = "
        SELECT
            lr.*,
            ui.fname,
            ui.lname,
            ld.balance,
            ld.credits,
            ld.disapprovalDetails,
            ld.approved_at,
            ld.disapproved_at
        FROM leaveReq            lr
        JOIN users               u  ON u.id        = lr.users_id
        JOIN userInformations    ui ON ui.users_id = u.id
        LEFT JOIN leave_details  ld ON ld.leaveDetails_id = (
              SELECT ld2.leaveDetails_id
              FROM   leave_details ld2
              WHERE  ld2.leaveID = lr.leave_id
              ORDER  BY ld2.leaveDetails_id DESC
              LIMIT  1
        )
        WHERE lr.leaveStatus = :status
    ";

    if ($leaveId !== null) {
        $sql .= " AND lr.leave_id = :leave_id";
    }

    $sql .= "
        ORDER BY $sortColumn $sortOrder, lr.leave_id $sortOrder
        LIMIT  :limit
        OFFSET :offset
    ";

    try {
        $st = $pdo->prepare($sql);
        $st->bindValue(':status', $status);
        if ($leaveId !== null) {
            $st->bindValue(':leave_id', $leaveId, PDO::PARAM_INT);
        }
        $st->bindValue(':limit',  $limit,  PDO::PARAM_INT);
        $st->bindValue(':offset', $offset, PDO::PARAM_INT);
        $st->execute();
        return $st->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("leaves_fetch: " . $e->getMessage());
        return [];
    }
}

// function getLeaveCredits(){
//     $pdo = db_connection();
//     $users_id = $_GET['users_id'] ?? '';

//     $query = "SELECT * FROM leaveCounts WHERE users_id = :users_id;";
//     $stmt = $pdo->prepare($query);
//     $stmt->bindParam(":users_id", $users_id);
//     $stmt->execute();
//     $leaveCounts = $stmt->fetch(PDO::FETCH_ASSOC);
//     return ['leaveCounts' => $leaveCounts];
// }

// ===================== REPORTS ON EMPLOYEE ===================== //
function getEmployeeReport(){
    $pdo = db_connection();
    $users_id = $_SESSION['user_id'] ?? '';
    $query = "SELECT * FROM leavereq
    INNER JOIN leave_details ON leavereq.leave_id = leave_details.leaveID
    WHERE users_id = :users_id;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":users_id", $users_id);
    $stmt->execute();
    $leaveEmployeeResult = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return ['leaveEmployeeResult' => $leaveEmployeeResult];
}   
function getEmployeeLeaveCounts(){
    $pdo = db_connection();
    $users_id = $_SESSION['user_id'] ?? '';
    $query = "SELECT * FROM leavecounts
    WHERE users_id = :users_id;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":users_id", $users_id);
    $stmt->execute();
    $getEmployeeLeaveCounts = $stmt->fetch(PDO::FETCH_ASSOC);
    return ['getEmployeeLeaveCounts' => $getEmployeeLeaveCounts];
}   

// ===================== PERSONAL DATA SHEET ===================== //

function getPersonalData(): array
{
    $pdo      = db_connection();
    $users_id = (int)($_GET['users_id'] ?? 0);

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
    $users_id = $_GET["users_id"] ?? '';
    $query = "SELECT * FROM personal_data_sheet WHERE users_id = :users_id;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":users_id", $users_id);
    $stmt->execute();
    $getPds_id = $stmt->fetch(PDO::FETCH_ASSOC);
    return ['getPds_id' => $getPds_id];
}


