<?php
require_once '../../installer/config.php';
$pdo = db_connection();
session_start();

if (isset($_SESSION["user_id"])) {
    $id = $_SESSION["user_id"];

    $query = "UPDATE users SET session_id = NULL WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $id);
    $stmt->execute();

    $query = "UPDATE admin_history 
              SET logout_time = NOW()
              WHERE id = (
                  SELECT id FROM (
                      SELECT id FROM admin_history 
                      WHERE admin_id = ? AND logout_time IS NULL 
                      ORDER BY login_time DESC 
                      LIMIT 1
                  ) AS sub
              )";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$id]);
}

session_unset();
session_destroy();
header("Location: ../index.php");
exit;

    

