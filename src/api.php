<?php
header('Content-Type: application/json');
require_once '../installer/config.php';

$pdo = db_connection(); 

function JobTitleRegistration($pdo){
    $query = "SELECT * FROM jobTitles ORDER BY jobTitle ASC;";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getRequestCount($pdo){
    $query = "SELECT COUNT(*) FROM userrequest WHERE status = 'pending';";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    return $stmt->fetchColumn();
}

$response = [
    'jobTitles' => JobTitleRegistration($pdo),
    'pendingCount' => getRequestCount($pdo)
];

echo json_encode($response);
file_put_contents("debug.txt", json_encode($response)); 