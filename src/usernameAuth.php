<?php
header('Content-Type: application/json');
require_once '../installer/config.php';

if (!isset($_POST['username'])) {
    echo json_encode(['exists' => false]);
    exit;
}

$username = $_POST['username'];
$pdo = db_connection();

$query = "SELECT COUNT(*) as count FROM users WHERE username = :username";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':username', $username);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

echo json_encode(['exists' => $result['count'] > 0]);
