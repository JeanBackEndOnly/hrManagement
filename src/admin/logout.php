<?php
require_once '../../installer/config.php';
$pdo = db_connection();
session_start();
isset($_SESSION["user_id"]) ? $id=$_SESSION["user_id"] : null;
    $query = "UPDATE users SET session_id = NULL WHERE id = :id";
    $stmt=$pdo->prepare($query);
    $stmt->bindParam(":id", $id);
    $stmt->execute();

    session_destroy();
    session_unset();
    
    header("Location: ../index.php");
    die();

    

