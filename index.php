<?php
require_once 'installer/config.php';
$pdo = db_connection(); 

    try {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE user_role = :user_role");
        $stmt->execute(['user_role' => 'administrator']);
        $admins = $stmt->fetchAll();

        $currentUrl = $_SERVER['REQUEST_URI'];
        $installerPath = "/github/hrManagement/installer/";
        $mainPath = "/github/hrManagement/src/";

        if (count($admins) === 0) {
            if ($currentUrl !== $installerPath) {
                header("Location: installer/");
                exit;
            }
        } else {
            if ($currentUrl !== $mainPath) {
                header("Location: src/");
                exit;
            }
        }

    } catch (PDOException $e) {
        die("Installer check failed: " . $e->getMessage());
    }

    $pdo = null;