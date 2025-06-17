<?php

declare(strict_types=1);

function getUsername($pdo, $username) {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->execute(['username' => $username]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
function get_email(object $pdo, string $email){
    $query = "SELECT email FROM userinformations WHERE email = :email";
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
function getJobTitle($pdo, $jobTitle){
    $query = "SELECT jobTitle FROM jobtitles WHERE jobTitle = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$jobTitle]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}