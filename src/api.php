<?php
header('Content-Type: application/json');
require_once '../installer/config.php';

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

$response = [
    'jobTitles'     => JobTitleRegistration($pdo),
    'pendingCount'  => getRequestCount($pdo),
    'reportsCount'  => getReportCount($pdo)
];

echo json_encode($response);
