<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../../installer/config.php';
require_once '../../installer/session.php';

try {
    $pdo = db_connection();

    // Check if admin is logged in
    if (isset($_SESSION["user_id"]) && $_SESSION["user_type"] == 'admin') {
        $admin_id = $_SESSION["user_id"];

        // 1. Clear session ID in users table
        $query = "UPDATE users SET session_id = NULL WHERE id = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$admin_id]);

        // 2. Update admin_history (simplified query)
        $query = "UPDATE admin_history 
                 SET logout_time = NOW() 
                 WHERE admin_id = ? AND logout_time IS NULL
                 ORDER BY login_time DESC
                 LIMIT 1";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$admin_id]);
    }

    // Completely destroy session
    $_SESSION = [];
    
    // Remove session cookie
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params["path"],
            $params["domain"],
            $params["secure"],
            $params["httponly"]
        );
    }

    session_destroy();

    // Redirect to login page
    header("Location: ../index.php");
    exit;

} catch (PDOException $e) {
    error_log("Database error during logout: " . $e->getMessage());
    die("A database error occurred during logout.");
} catch (Exception $e) {
    error_log("Logout error: " . $e->getMessage());
    die("An error occurred during logout.");
}