<?php
header('Content-Type: application/json');
require_once '../../installer/config.php';

if (!isset($_POST['employeeID'])) {
    echo json_encode(['exists' => false]);
    exit;
}

$employeeID = trim($_POST['employeeID']);
$pdo = db_connection();

$query = "SELECT COUNT(*) FROM userHr_Informations WHERE employeeID = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$employeeID]);
$count = $stmt->fetchColumn();

echo json_encode(['exists' => $count > 0]);
