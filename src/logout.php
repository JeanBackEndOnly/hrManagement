<?php
require_once '../installer/config.php';
session_start();
$pdo = db_connect();
    
date_default_timezone_set('Asia/Manila');
echo $time = date("H:i:s");
echo isset($_SESSION['user_id']) ? $id = $_SESSION['user_id'] : "null User ID";
    if($id){
        $query = "INSERT INTO user_status (users_id, logged_out) VALUES (:users_id, :logged_out)";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":users_id", $id);
        $stmt->bindParam(":logged_out", $time);
        $stmt->execute();
    
    session_destroy();
    session_unset();
    
    header("Location: index.php");
    die();
    }

    

