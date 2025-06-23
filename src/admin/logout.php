<?php
require_once '../../installer/config.php';
session_start();

    $pdo = db_connection();
    $adminId = 1;
    $sql = "UPDATE admin_history 
            SET logout_time = NOW() 
            WHERE admin_id = :admin_id 
              AND logout_time IS NULL 
            ORDER BY login_time DESC 
            LIMIT 1";

    $stmt = $pdo->prepare($sql);
    $stmt->execute(['admin_id' => $adminId]);
  


session_unset();
session_destroy();
header("Location: ../index.php");
exit;
