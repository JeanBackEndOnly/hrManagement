<?php

declare(strict_types=1);
date_default_timezone_set('Asia/Manila');
require_once '../../installer/session.php';
require_once '../../installer/config.php';
require_once '../../auth/view.php';

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
        SELECT users.*, userinformations.*, userrequest.*
        FROM users
        INNER JOIN userinformations ON users.id = userinformations.users_id
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
        SELECT users.*, userinformations.*, userrequest.*
        FROM users
        INNER JOIN userinformations ON users.id = userinformations.users_id
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
        SELECT users.*, userinformations.*, userrequest.*
        FROM users
        INNER JOIN userinformations ON users.id = userinformations.users_id
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
    INNER JOIN userrequest ON users.id = userrequest.users_id
    WHERE users.id = :id ";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $users_id);
    $stmt->execute();
    $reqProfInfo = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return ['reqProfInfo' => $reqProfInfo];
}

function getFamilyBG() {
    $pdo = db_connection();
    isset($_GET["users_id"]) ? $users_id = $_GET["users_id"] : null;
    $query = " SELECT * FROM users
    INNER JOIN family_information ON users.id = family_information.users_id
    WHERE users.id = :id ";
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
function getEmployee() {
    $pdo = db_connection();
    isset($_SESSION["user_id"]) ? $user_id = $_SESSION["user_id"] : "no fucking ID";
    $query = "SELECT * FROM users 
    INNER JOIN userinformations ON users.id = userinformations.users_id
    LEFT JOIN family_information ON users.id = family_information.users_id
    LEFT JOIN educational_background ON users.id = educational_background.users_id
    LEFT JOIN userrequest ON users.id = userrequest.users_id
    WHERE users.id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $user_id);
    $stmt->execute();
    $employeeInfo = $stmt->fetch(PDO::FETCH_ASSOC);
    return ['employeeInfo' => $employeeInfo];
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

function getReports(int $limit, int $offset, string $sortColumn, string $sortOrder, string $whereClause = ''): array {
    $pdo = db_connection();

    $allowedColumns = ['lname', 'report_date'];
    $allowedOrder = ['asc', 'desc'];

    if (!in_array($sortColumn, $allowedColumns)) $sortColumn = 'report_date';
    if (!in_array(strtolower($sortOrder), $allowedOrder)) $sortOrder = 'desc';

    $sql = "
        SELECT *
        FROM reports
        LEFT JOIN users ON reports.users_id = users.id
        LEFT JOIN userinformations ON users.id = userinformations.users_id
        $whereClause
        ORDER BY $sortColumn $sortOrder
        LIMIT :limit OFFSET :offset
    ";

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("DB error in getReports: " . $e->getMessage());
        return [];
    }
}
