<?php
header('Content-Type: application/json');
require_once '../../installer/config.php';

$pdo = db_connection();

function getReportCount($pdo) {
    $query = "SELECT COUNT(*) FROM reports WHERE DATE(report_date) = CURDATE()";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    return (int)$stmt->fetchColumn();
}

function getRequestCount($pdo) {
    $query = "SELECT COUNT(*) FROM userrequest WHERE status = 'pending'";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    return (int)$stmt->fetchColumn();
}

function JobTitleRegistration($pdo){
    $query = "SELECT * FROM jobTitles ORDER BY jobTitle ASC";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getLeaveReqCount($pdo) {
    $query = "SELECT COUNT(*) FROM leavereq WHERE leaveStatus = 'pending'";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    return (int)$stmt->fetchColumn();
}

$response = [
    'jobTitles'     => JobTitleRegistration($pdo),
    'pendingCount'  => getRequestCount($pdo),
    'reportsCount'  => getReportCount($pdo),
    'leavePendingCount'  => getLeaveReqCount($pdo)
];

echo json_encode($response);
