<?php
header('Content-Type: application/json');
include './functions.php';

$server_name = $_SERVER['SERVER_NAME'];
$is_ip_access = filter_var($server_name, FILTER_VALIDATE_IP);

$action = $_POST['action'] ?? null;

if ($action === 'save_installation_data') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $role = 'administrator';

    if (!$username || !$password || !$confirm_password) {
        echo json_encode(['success' => false, 'message' => 'All fields are required']);
        exit;
    }

    if ($password !== $confirm_password) {
        echo json_encode(['success' => false, 'message' => 'Passwords do not match']);
        exit;
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $response = save_user([
        'username' => $username,
        'password' => $hashedPassword,
        'user_role' => $role
    ]);

    echo json_encode([
        'success' => !$response['is_error'],
        'message' => $response['message']
    ]);
    exit;
}

if ($action === 'register-data') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    echo json_encode([
        'success' => true,
        'message' => 'User registered successfully (stub response)'
    ]);
    exit;
}


$action = $_POST['action'] ?? ''; 


echo json_encode([
    'success' => false,
    'message' => 'No valid action specified. Received action: ' . $action
]);
die();
