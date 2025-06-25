<?php
header('Content-Type: application/json');
require_once '../../installer/config.php'; 
if (!isset($_POST['email'])) {
    echo json_encode(['exists' => false]);
    exit;
}

$email = $_POST['email'];
$pdo = db_connection();
$query = "SELECT COUNT(*) as count FROM userinformations WHERE email = :email";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':email', $email);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

echo json_encode(['exists' => $result['count'] > 0]);
