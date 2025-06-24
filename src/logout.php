<?php
require_once '../installer/config.php';
session_start();

    $pdo = db_connection();
    $EmployeeID = $_SESSION["user_id"] ?? '';
    $sql = "UPDATE employee_history 
            SET logout_time = NOW() 
            WHERE employee_id = :employee_id 
              AND logout_time IS NULL 
            ORDER BY login_time DESC 
            LIMIT 1";

    $stmt = $pdo->prepare($sql);
    $stmt->execute(['employee_id' => $EmployeeID]);
  


session_unset();
session_destroy();
header("Location: index.php");
exit;
