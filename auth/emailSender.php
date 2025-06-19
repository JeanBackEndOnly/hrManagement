<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

register_shutdown_function(function () {
    $error = error_get_last();
    if ($error) {
        file_put_contents(__DIR__ . '/email_fatal_error.log', json_encode($error) . "\n", FILE_APPEND);
    }
});

file_put_contents(__DIR__ . '/email_log.txt', "==> Script started at " . date("Y-m-d H:i:s") . "\n", FILE_APPEND);
file_put_contents(__DIR__ . '/email_log.txt', "Args: " . json_encode($argv) . "\n", FILE_APPEND);

require __DIR__ . '/../vendor/autoload.php';
require_once(__DIR__ . '/../installer/config.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (!isset($argv[1]) || !isset($argv[2])) {
    file_put_contents(__DIR__ . '/email_error.log', "Missing parameters. Exiting.\n", FILE_APPEND);
    exit();
}

$createdUserId     = $argv[1];
$action            = $argv[2];
$previousJobTitle  = $argv[3] ?? null;
$newJobTitle       = $argv[4] ?? null;
$newSalary         = $argv[5] ?? null;
$username          = $argv[6] ?? null;
$password          = $argv[7] ?? null;



$pdo = db_connection();

try {
    $user = null;

    $query = "SELECT * FROM userinformations WHERE users_id = :users_id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":users_id", $createdUserId);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user && $createdUserId == 1) {
        $query = "SELECT * FROM users WHERE id = 1";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($admin) {
            $user = [
                'email' => $admin['email'],
                'fname' => 'Admin',
                'lname' => 'Account'
            ];
        }
    }

    if (!$user) {
        file_put_contents(__DIR__ . '/email_error.log', "No user found in userinformations or users for ID: $createdUserId. Exiting.\n", FILE_APPEND);
        exit();
    }

    if (!$pdo) {
        file_put_contents(__DIR__ . '/email_error.log', "Database connection failed.\n", FILE_APPEND);
        exit();
    }


    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'pagotaisidromarcojean@gmail.com';
        $mail->Password   = 'ytzu niks mizj bojx';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;
        $mail->CharSet    = 'UTF-8';

        $mail->setFrom('pagotaisidromarcojean@gmail.com', 'HR Department');
        $mail->addAddress($user['email'], "{$user['fname']} {$user['lname']}");

        $mail->isHTML(true);

        if ($action === 'accepted') {
            $mail->Subject = 'Your Request has been Accepted!';
            $mail->Body    = "
                <p>Hi {$user['fname']} {$user['lname']},</p>
                <p>Welcome to the company of ZAMBOANGA PUERICULTURE CENTER! Your employee account has been successfully validated.</p>
                <br>
                <p>Best regards,<br>HR Team</p>
            ";
        } elseif ($action === 'created') {
            if (!$username || !$password) {
                file_put_contents(__DIR__ . '/email_error.log', "Missing username/password for 'created' action. Exiting.\n", FILE_APPEND);
                exit();
            }

            $mail->Subject = 'Your Employee Account has been Created';
            $mail->Body    = "
                <p>Hi {$user['fname']} {$user['lname']},</p>
                <p>Welcome to the company of ZAMBOANGA PUERICULTURE CENTER! Your employee account has been successfully created.</p>
                <p><strong>Login Credentials:</strong></p>
                <ul>
                    <li><strong>Username:</strong> $username</li>
                    <li><strong>Password:</strong> $password</li>
                </ul>
                <p>Please log in to the employee portal and change your password upon first login for security purposes.</p>
                <br>
                <p>Best regards,<br>HR Team</p>
            ";
        } elseif ($action === 'promoted') {
            $mail->Subject = 'Congratulations on Your Promotion!';
            $mail->Body = "
                <p>Hi {$user['fname']} {$user['lname']},</p>
                <p>🎉 Congratulations! You have been promoted from <strong>$previousJobTitle</strong> to <strong>$newJobTitle</strong>.</p>
                <p>Your new salary is <strong>₱" . number_format($newSalary, 2) . "</strong>.</p>
                <p>This update has been reflected in our system. We look forward to your continued success!</p>
                <br>
                <p>Best regards,<br>HR Team</p>
            ";

        }elseif ($action === 'rejected') {
            $mail->Subject = 'Account not valid!';
            $mail->Body = "
                <p>Hi {$user['fname']} {$user['lname']},</p>
                <p>Your request have been rejected for some reason, please go to HR office for clarification.</p>
                <p>Thank You for your understanding!.</p>
                <br>
                <p>Best regards,<br>HR Team</p>
            ";

        }elseif ($action === 'password') {
            $mail->Subject = 'Password Reset!';
            $mail->Body = "
                <p>Hi Admin,</p>
                <p>Your New Password is :</strong> $password .</p>
                <p>Thank You for your service!.</p>
                <br>
                <p>Best regards,<br>HR Team</p>
            ";

        }else {
            file_put_contents(__DIR__ . '/email_error.log', "Invalid action type: $action. Exiting.\n", FILE_APPEND);
            exit();
        }

        $mail->send();
        file_put_contents(__DIR__ . '/email_log.txt', "Email sent successfully to {$user['email']} with action $action\n", FILE_APPEND);

    } catch (Exception $e) {
        file_put_contents(__DIR__ . '/email_error.log', "PHPMailer Error: {$mail->ErrorInfo}\n", FILE_APPEND);
    }

} catch (Exception $e) {
    file_put_contents(__DIR__ . '/email_error.log', "DB Error: {$e->getMessage()}\n", FILE_APPEND);
}

$pdo = null;
