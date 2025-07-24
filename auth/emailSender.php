<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

register_shutdown_function(function () {
    $error = error_get_last();
    if ($error) {
        echo "hehe HIND NAGA WORK ANG EMAIL";
    }
});

// working na
require __DIR__ . '/../vendor/autoload.php';
require_once(__DIR__ . '/../installer/config.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (!isset($argv[1]) || !isset($argv[2])) {
    exit();
}

$createdUserId = $argv[1];
$action = $argv[2];
$previousJobTitle = $argv[3] ?? null;
$newJobTitle = $argv[4] ?? null;
$newSalary = $argv[5] ?? null;
$username = $argv[6] ?? null;
$password = $argv[7] ?? null;
$mailCode = $argv[8] ?? null;
$leaveID = $argv[9] ?? null;

$pdo = db_connection();

try {

    $user = null;

    $query = "SELECT * FROM userinformations WHERE users_id = :users_id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":users_id", $createdUserId);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // ==================== LEAVE DETAILS ==================== //
    $query = "SELECT * FROM leaveReq 
    INNER JOIN leave_details ON leaveReq.leave_id = leave_details.leaveID 
    WHERE leave_id = :leave_id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":leave_id", $leaveID);
    $stmt->execute();
    $leave = $stmt->fetch(PDO::FETCH_ASSOC);
    // ===================================================== //

    if (!$user && $createdUserId == 1) {
        $query = "SELECT * FROM users WHERE id = 1 OR id = 2";
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
    if (!$user && $createdUserId == 2) {
        $query = "SELECT * FROM users WHERE id = 2";
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
        exit();
    }

    if (!$pdo) {
        exit();
    }


    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'pagotaisidromarcojean@gmail.com';
        $mail->Password = 'ytzu niks mizj bojx';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        $mail->CharSet = 'UTF-8';

        $mail->setFrom('pagotaisidromarcojean@gmail.com', 'HR Department');
        $mail->addAddress($user['email'], "{$user['fname']} {$user['lname']}");

        $mail->isHTML(true);

        if ($action === 'accepted') {
            $mail->Subject = 'Your Request has been Accepted!';
            $mail->Body = "
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
            $mail->Body = "
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

        } elseif ($action === 'rejected') {
            $mail->Subject = 'Account not valid!';
            $mail->Body = "
                <p>Hi {$user['fname']} {$user['lname']},</p>
                <p>Your request have been rejected for some reason, please go to HR office for clarification.</p>
                <p>Thank You for your understanding!.</p>
                <br>
                <p>Best regards,<br>HR Team</p>
            ";

        } elseif ($action === 'password') {
            $mail->Subject = 'Mail Code!';
            $mail->Body = "
                <p>Hi Admin,</p>
                <p>Your Mail Code is :</strong>  $mailCode.</p>
                <p>Please Enter this and create your new password!.</p>
                <br>
                <p>Best regards,<br>HR Team</p>
            ";

        } elseif ($action === 'ForgotEmployeePass') {
            $mail->Subject = 'Mail Code!';
            $mail->Body = "
                <p>Hi {$user['fname']} {$user['lname']},</p>
                <p>Your Mail Code is :</strong>  $mailCode.</p>
                <p>Please Enter this and create your new password!.</p>
                <br>
                <p>Best regards,<br>HR Team</p>
            ";

        } elseif ($action === 'MFA') {
            $mail->Subject = 'Mail Code!';
            $mail->Body = "
                <p>Hi {$user['fname']} {$user['lname']},</p>
                <p>Your Mail Code is :<strong>  $mailCode.</strong></p>
                <p>Please Enter this 6 digit codes!.</p>
                <br>
                <p>Best regards,<br>HR Team</p>
            ";

        } elseif ($action === 'LeaveApproved') {
            $mail->Subject = 'Leave Approved!';
            $mail->Body = "
                <p>Hi {$user['fname']} {$user['lname']},</p>
                <p>Congrationalations! your leave application have been approved by the admin!</p>
                <p><strong>Leave Type: {$leave['leaveType']}</strong></p>
                <p><strong>From: {$leave['InclusiveFrom']}</strong></p>
                <p><strong>To: {$leave['InclusiveTo']}</strong></p>
                <br>
                <p>Best regards,<br>HR Team</p>
            ";

        } elseif ($action === 'LeaveDisapproved') {
            $mail->Subject = 'Leave Disapproved!';
            $mail->Body = "
                <p>Hi {$user['fname']} {$user['lname']},</p>
                <p>I'm so sorry but your leave request have been disapproved!</p>
                <p>Details: {$leave['disapprovalDetails']}</p>
                <br>
                <p>Best regards,<br>HR Team</p>
            ";

        } else {
            exit();
        }

        $mail->send();

    } catch (Exception $e) {
        file_put_contents(__DIR__ . '/email_error.log', "PHPMailer Error: {$mail->ErrorInfo}\n", FILE_APPEND);
    }

} catch ( Exception $e) {
    file_put_contents(__DIR__ . '/email_error.log', "DB Error: {$e->getMessage()}\n", FILE_APPEND);
}

$pdo = null;
