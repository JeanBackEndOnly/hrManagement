<?php
require_once 'config.php'; 
$pdo = db_connection();

if (session_status() === PHP_SESSION_NONE) {
    ini_set('session.use_only_cookies', 1);
    ini_set('session.use_strict_mode', 1);
    ini_set('session.gc_maxlifetime', 86400);

    $host = ($_SERVER['HTTP_HOST'] === 'localhost') ? 'localhost' : '192.168.1.21';
    session_set_cookie_params([
        'lifetime' => 86400, 
        'path' => '/',
        'secure' => false, 
        'httponly' => true,
        'samesite' => 'Lax'
    ]);

    session_start();
    
    if (!isset($_SESSION['CREATED'])) {
        $_SESSION['CREATED'] = time();
    }
}

function checkActiveAdminSession($pdo, $userId) {
    try {
        $stmt = $pdo->prepare("SELECT session_id FROM users WHERE id = ? AND user_role = 'administrator'");
        $stmt->execute([$userId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['session_id'] : null;
    } catch (PDOException $e) {
        error_log("Database error: " . $e->getMessage());
        return null;
    }
}

function updateUserSession($pdo, $userId, $sessionId) {
    try {
        $stmt = $pdo->prepare("UPDATE users SET session_id = ? WHERE id = ?");
        return $stmt->execute([$sessionId, $userId]);
    } catch (PDOException $e) {
        error_log("Database error: " . $e->getMessage());
        return false;
    }
}

function regenerate_session_id_loggedin($pdo) {
    if (isset($_SESSION["user_id"])) {
        $newSessionId = session_create_id();
        session_commit();
        session_id($newSessionId);
        session_start();
        $_SESSION["last_regeneration"] = time();

        if (isset($_SESSION["roles"]) && $_SESSION["roles"] === "administrator") {
            updateUserSession($pdo, $_SESSION["user_id"], session_id());
        }

        return true;
    }
    return false;
}

function regenerate_session_id() {
    session_regenerate_id(true);
    $_SESSION["last_regeneration"] = time();
    return true;
}

if (isset($_SESSION["user_id"])) {
    if (isset($_SESSION["roles"]) && $_SESSION["roles"] === "administrator") {
        $dbSession = checkActiveAdminSession($pdo, $_SESSION["user_id"]);
        if ($dbSession !== session_id()) {
            session_unset();
            session_destroy();
            header("Location: ../index.php");
            exit;
        }
    }

    $interval = 3000;
    if (!isset($_SESSION["last_regeneration"]) || 
        (time() - $_SESSION["last_regeneration"] >= $interval)) {
        regenerate_session_id_loggedin($pdo);
    }
} else {
    $interval = 3000;
    if (!isset($_SESSION["last_regeneration"]) || 
        (time() - $_SESSION["last_regeneration"] >= $interval)) {
        regenerate_session_id();
    }
}

if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
$csrf_token = $_SESSION['csrf_token'];



// require_once 'config.php'; 
// $pdo = db_connection();
// if (session_status() === PHP_SESSION_NONE) {
//     ini_set('session.use_only_cookies', 1);
//     ini_set('session.use_strict_mode', 1);
//     ini_set('session.gc_maxlifetime', 86400);

//     $host = ($_SERVER['HTTP_HOST'] === 'localhost') ? 'localhost' : '192.168.1.21';
//     session_set_cookie_params([
//         'lifetime' => 86400, 
//         'path' => '/',
//         'secure' => false, 
//         'httponly' => true,
//         'samesite' => 'Lax'
//     ]);

//     session_start();
    
//     if (!isset($_SESSION['CREATED'])) {
//         $_SESSION['CREATED'] = time();
//     }
// }

// function checkActiveAdminSession($pdo, $userId) {
//     try {
//         $stmt = $pdo->prepare("SELECT session_id FROM users WHERE id = ? AND user_role = 'administrator'");
//         $stmt->execute([$userId]);
//         $result = $stmt->fetch(PDO::FETCH_ASSOC);
//         return $result ? $result['session_id'] : null;
//     } catch (PDOException $e) {
//         error_log("Database error: " . $e->getMessage());
//         return null;
//     }
// }

// function updateUserSession($pdo, $userId, $sessionId) {
//     try {
//         $stmt = $pdo->prepare("UPDATE users SET session_id = ? WHERE id = ?");
//         return $stmt->execute([$sessionId, $userId]);
//     } catch (PDOException $e) {
//         error_log("Database error: " . $e->getMessage());
//         return false;
//     }
// }

// function regenerate_session_id_loggedin($pdo) {
//     if (isset($_SESSION["user_id"])) {
//         $newSessionId = session_create_id();
//         session_commit();
//         session_id($newSessionId);
//         session_start();
//         $_SESSION["last_regeneration"] = time();
        
//         if ($_SESSION["roles"] === "administrator") {
//             updateUserSession($pdo, $_SESSION["user_id"], session_id());
//         }
        
//         return true;
//     }
//     return false;
// }

// function regenerate_session_id() {
//     session_regenerate_id(true);
//     $_SESSION["last_regeneration"] = time();
//     return true;
// }
// if (isset($_SESSION["user_id"])) {
//     if ($_SESSION["roles"] === "administrator") {
//         $dbSession = checkActiveAdminSession($pdo, $_SESSION["user_id"]);
//         if ($dbSession !== session_id()) {
//             session_unset();
//             session_destroy();
//             header("Location: ../index.php");
//             exit;
//         }
//     }
    
//     $interval = 3000;
//     if (!isset($_SESSION["last_regeneration"]) || 
//         (time() - $_SESSION["last_regeneration"] >= $interval)) {
//         regenerate_session_id_loggedin($pdo);
//     }
// } else {
//     $interval = 3000;
//     if (!isset($_SESSION["last_regeneration"]) || 
//         (time() - $_SESSION["last_regeneration"] >= $interval)) {
//         regenerate_session_id();
//     }
// }

// if (!isset($_SESSION['csrf_token'])) {
//     $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
// }
// $csrf_token = $_SESSION['csrf_token']; 