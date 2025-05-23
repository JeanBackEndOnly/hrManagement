<?php

ini_set('session.use_only_cookies', 1);
ini_set('session.use_strict_mode', 1);
ini_set('session.gc_maxlifetime', 86400);

$host = ($_SERVER['HTTP_HOST'] === 'localhost') ? 'localhost' : '192.168.1.117';


session_set_cookie_params([
    'lifetime' => 86400, 
    'domain' => $host,
    'path' => '/',
    'secure' => true,
    'httponly' => true
]);

session_start();
if (!isset($_SESSION['CREATED'])) {
    $_SESSION['CREATED'] = time();
}

function users(){
    $max_lifetime = 86400;
    if (time() - $_SESSION['CREATED'] > $max_lifetime) {
        echo '<a href="../index.php">session expired! click to continue</a>';
        echo '<script>
                setTimeout(function() {
                    window.location.href = "index.php";
                }, 2629440); 
              </script>';
        
        session_unset();  
        session_destroy(); 
        exit(); 
    }
}

function index() {
    $max_lifetime = 86400;
    if (time() - $_SESSION['CREATED'] > $max_lifetime) {
        echo '<a href="index.php">session expired! click to continue</a>';
        echo '<script>
                setTimeout(function() {
                    window.location.href = "index.php";
                }, 2629440); 
              </script>';
        
        session_unset();  
        session_destroy(); 
        exit(); 
    }
}

if (isset($_SESSION["user_id"])) {
    if (isset($_SESSION["last_regeneration"])) {
        $interval = 3000; 
        if (time() - $_SESSION["last_regeneration"] >= $interval) {
            regenerate_session_id_loggedin();
        }
    } else {
        regenerate_session_id_loggedin();
    }
} else {
    if (!isset($_SESSION["last_regeneration"])) {
        regenerate_session_id();
    } else {
        $interval = 3000;
        if (time() - $_SESSION["last_regeneration"] >= $interval) {
            regenerate_session_id();
        }
    }
}

function regenerate_session_id_loggedin() {
    session_regenerate_id(true); 
    $_SESSION["last_regeneration"] = time();
}

function regenerate_session_id() {
    session_regenerate_id(true); 
    $_SESSION["last_regeneration"] = time();
}

if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
$csrf_token = $_SESSION['csrf_token'];

date_default_timezone_set('Asia/Manila');
$time = date("H:i:s");

// =============== CREDIT LOGICS ==================== //
    $breavementCreditToUse = 9;
    $breavementUsedCredit = 9 - $breavementCreditToUse;
    $breavementRemaningCredit = 9 - $breavementUsedCredit;
    $_SESSION["breavementCreditToUse"] = $breavementCreditToUse;  
    $_SESSION["breavementUsedCredit"] = $breavementUsedCredit;
    $_SESSION["breavementRemaningCredit"] = $breavementRemaningCredit;