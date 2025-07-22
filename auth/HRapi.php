<?php
require_once '../installer/config.php';
header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];

$pdo = db_connection();
if ($method === 'GET') {
    try {
        $stmt = $pdo->query("SELECT * FROM userInformations");
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(['status' => 'success', 'data' => $data]);
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }

} elseif ($method === 'POST') {
    $input = json_decode(file_get_contents("php://input"), true);

    if (!$input) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid JSON input']);
        exit;
    }

    $required = ['users_id', 'lname', 'fname', 'mname', 'citizenship', 'gender', 'civil_status', 'birthday', 'contact', 'email'];
    foreach ($required as $field) {
        if (empty($input[$field])) {
            echo json_encode(['status' => 'error', 'message' => "Missing required field: $field"]);
            exit;
        }
    }

    try {
        $stmt = $pdo->prepare("INSERT INTO userInformations 
            (users_id, lname, fname, mname, nickname, suffix, citizenship, gender, civil_status, religion, age, birthday, birthPlace, contact, email)
            VALUES 
            (:users_id, :lname, :fname, :mname, :nickname, :suffix, :citizenship, :gender, :civil_status, :religion, :age, :birthday, :birthPlace, :contact, :email)
        ");

        $stmt->execute([
            ':users_id'     => $input['users_id'],
            ':lname'        => $input['lname'],
            ':fname'        => $input['fname'],
            ':mname'        => $input['mname'],
            ':nickname'     => $input['nickname'] ?? null,
            ':suffix'       => $input['suffix'] ?? null,
            ':citizenship'  => $input['citizenship'],
            ':gender'       => $input['gender'],
            ':civil_status' => $input['civil_status'],
            ':religion'     => $input['religion'] ?? null,
            ':age'          => $input['age'] ?? null,
            ':birthday'     => $input['birthday'],
            ':birthPlace'   => $input['birthPlace'] ?? null,
            ':contact'      => $input['contact'],
            ':email'        => $input['email']
        ]);

        echo json_encode(['status' => 'success', 'message' => 'User information added']);
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }

} else {
    echo json_encode(['status' => 'error', 'message' => 'Method not allowed']);
}
