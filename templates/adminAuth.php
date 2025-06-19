<?php
require_once '../../installer/session.php';
require_once '../../auth/view.php';
require_once '../../auth/control.php';

date_default_timezone_set('Asia/Manila'); 

if (isset($_SESSION["user_id"])) {
    $users_id = $_SESSION["user_id"];

    $currentHour = date("G"); 

    if (in_array($currentHour, [6, 12, 18])) {
        if (!isset($_SESSION['last_session_update']) || $_SESSION['last_session_update'] != $currentHour) {
            $query = "UPDATE users SET session_id = NULL WHERE id = :id";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":id", $users_id);
            $stmt->execute();

            $_SESSION['last_session_update'] = $currentHour;
        }
    }
}


?>