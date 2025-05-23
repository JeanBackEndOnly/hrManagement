<?php
header("Content-Type: application/json");

require_once '../../auth/control.php';
require_once '../../installer/config.php';

$pdo = db_connect();
$info = getUsersInfo();

$jobs = $info['jobs'];
$leave = $info['leave'];
$Employeeleave = $info['Employeeleave'];
$pendingLeave = $info['pendingLeave'];
$StatusApproved = $info['StatusApproved'];
$pendingCount = $info['pendingCount'];

// 🔧 Direct query for leave count here
$query = "SELECT COUNT(*) FROM leavea WHERE leave_Status = 'pending'";
$stmt = $pdo->prepare($query);
$stmt->execute();
$pendinLeaveCount = $stmt->fetchColumn();

$jobTitles = array_map(function($job) {
    return htmlspecialchars($job['jobs'], ENT_QUOTES, 'UTF-8');
}, $jobs);

$response = [
    'jobTitles' => $jobTitles,
    'leave' => $leave,
    'Employeeleave' => $Employeeleave,
    'pendingLeave' => $pendingLeave,
    'StatusApproved' => $StatusApproved,
    'pendingCount' => $pendingCount,
    'pendinLeaveCount' => $pendinLeaveCount
];

echo json_encode($response);
