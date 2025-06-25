<?php
include "../../installer/config.php";


function initInstaller() {
    $pdo = db_connection(); 

    try {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE user_role = :user_role");
        $stmt->execute(['user_role' => 'administrator']);
        $admins = $stmt->fetchAll();

        $currentUrl = $_SERVER['REQUEST_URI'];
        $installerPath = "/github/hrManagement/installer/";

        if (count($admins) === 0) {
            if ($currentUrl !== $installerPath) {
                header("Location: " . base_url() . "installer/");
                exit;
            }
        } else {
            if ($currentUrl === $installerPath) {
                header("Location: " . base_url()."SRC/");
                exit;
            }
        }

    } catch (PDOException $e) {
        die("Installer check failed: " . $e->getMessage());
    }

    $pdo = null;
}

function base_url() {
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https' : 'http';
    
    $server_name = $_SERVER['SERVER_NAME']; 
    
    if (in_array($server_name, ['127.0.0.1', '::1', 'localhost'])) {
        return $protocol . '://' . $server_name . '/github/hrManagement/'; 
    }
    
    return $protocol . '://' . $server_name . '/'; 
}
function get_current_page() {
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'];
    $uri = $_SERVER['REQUEST_URI'];

    return $protocol . '://' . $host . $uri;
}

function render_styles(){

    $styles =[ base_url() . 'assets/css/all.min.css', 
    base_url() . 'assets/css/custom-bs.min.css', 
    base_url() . 'assets/css/main_frontend.css', 
    base_url() . 'assets/css/main.css'];

    foreach($styles as $style){
        echo '<link rel="stylesheet" href="' . $style . '">';
    }
    
}

function render_json(){

    $json =[ base_url() . '../templates/manifest.json'];

    foreach($json as $jsons){
        echo '<link rel="manifest" href="' . $jsons . '">';
    }
    
}

function render_scripts(){

    $scripts = [base_url() . 'assets/js/jquery.min.js', 
    base_url() . 'assets/js/perfect-scrollbar.min.js', 
    base_url() . 'assets/js/smooth-scrollbar.min.js', 
    base_url() . 'assets/js/sweetalert.min.js' ,
    base_url() . 'assets/js/all.min.js' ,
    base_url() . 'assets/js/bootstrap.min.js', 
    base_url() . 'assets/js/custom-bs.js' ,
    base_url() . 'assets/js/main.js',
    base_url() . 'assets/js/main2.js',
    base_url() . 'assets/js/hr/hrmain.js',
    base_url() . 'assets/js/service-worker.js'
    ];

    foreach($scripts as $script){
        echo '<script type="text/javascript" src="' . $script . '"></script>';
    }

}

function save_user($args = [], $user_id = 0) {
    $conn = db_connection();

    try {
        if (!$user_id) {
            $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
            $stmt->execute([$args['username']]);
            if ($stmt->rowCount() > 0) {
                return ['is_error' => true, 'message' => 'Username already exists'];
            }

            $columns = implode(', ', array_keys($args));
            $placeholders = implode(', ', array_map(fn($key) => ":$key", array_keys($args)));

            $sql = "INSERT INTO users ($columns) VALUES ($placeholders)";
            $stmt = $conn->prepare($sql);
            $stmt->execute($args);
        } else {
            $setPart = implode(', ', array_map(fn($key) => "$key = :$key", array_keys($args)));
            $sql = "UPDATE users SET $setPart WHERE id = :id";
            $args['id'] = $user_id;
            $stmt = $conn->prepare($sql);
            $stmt->execute($args);
        }

        return ['is_error' => false, 'message' => 'User saved successfully'];
    } catch (PDOException $e) {
        return ['is_error' => true, 'message' => 'DB Error: ' . $e->getMessage()];
    }
}