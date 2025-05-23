<?php

declare(strict_types=1);
require_once '../installer/session.php';
require_once '../auth/view.php';


function getUsersInfo() {
    $pdo = db_connect(); 
    $query = "SELECT * FROM schedule";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $schedule = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return [
        'schedule' => $schedule
    ];
}
