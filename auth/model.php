<?php

declare(strict_types=1);

function get_email(object $pdo, string $email){
    $query = "SELECT email FROM signup_information WHERE email = :email";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":email", $email);
    $stmt->execute();
    $email_result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $email_result;
}

function get_username($pdo, $username) {
    $stmt = $pdo->prepare("SELECT id, username, password, user_role FROM users WHERE username = ?");
    $stmt->execute([$username]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function get_password($pdo, $id){
    $query = "SELECT password FROM users WHERE id = :id;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row['password'] ?? null;
}
function getID(object $pdo, string $employee_id){
    $query = "SELECT employeeID FROM addbyadmin WHERE employeeID = :employeeID";
    $stmt=$pdo->prepare($query);
    $stmt->bindParam(":employeeID",$employee_id);
    $stmt->execute();
    return $resutlt = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
function getLeaveCounts(object $pdo, string $employee_id, string $leave_Type){
    $query = "SELECT users_id FROM addbyadmin WHERE employeeID = :employeeID";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":employeeID", $employee_id);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$result) {
        return null; 
    }

    $userId = $result['users_id']; 

    $allowedTypes = ['Breavement', 'Maternity', 'Paternity', 'Sick', 'Vacation', 'Wedding'];
    if (!in_array($leave_Type, $allowedTypes)) {
        throw new Exception("Invalid leave type");
    }

    // Use the column name safely
    $query = "SELECT `$leave_Type` AS leave_value FROM leave_counts WHERE users_id = :users_id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':users_id', $userId);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    return $row ? $row['leave_value'] : null;
}

// function getEmployeeID(object $pdo, string $employee_id){
//     $query = "SELECT users_id FROM addbyadmin WHERE employeeID = :employeeID";
//     $stmt=$pdo->prepare($query);
//     $stmt->bindParam(":employeeID",$employee_id);
//     $stmt->execute();
//     $id = $stmt->fetch(PDO::FETCH_ASSOC);
// }