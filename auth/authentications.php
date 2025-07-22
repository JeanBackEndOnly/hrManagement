<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../vendor/autoload.php';

require_once '../installer/config.php';
require_once '../installer/session.php';
require_once 'model.php';
require_once 'functions.php';

if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    header("Location: ../invalid.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $pdo = db_connection();

    // ============================= Login Authentication ============================= //
    if (isset($_POST['loginAuth']) && $_POST['loginAuth'] === 'true') {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';
        $mailCode = $_POST['mailCode'] ?? '';
        $adminMailCode = $_POST['AdminMailCode'] ?? '';
        $resendCode = $_POST['resendCode'] ?? '';
        $AdminResendCode = $_POST['AdminResendCode'] ?? '';

        $hasCredentials = $username !== '' && $password !== '';
        $hasMfaCode = ($mailCode !== '') || ($adminMailCode !== '');

        try {
            if (($resendCode === 'true' || $AdminResendCode === 'true') && !$hasCredentials && !$hasMfaCode) {
                $userId = $_SESSION['pending_user_id'] ?? null;
                $userRole = $_SESSION['pending_user_role'] ?? null;

                if (!$userId || !$userRole) {
                    $_SESSION['errors_login']['login_incorrect'] = 'Session expired. Please log in again.';
                    header('Location: ../src/index.php');
                    exit();
                }

                $stmt = $pdo->prepare('SELECT id, email, user_role FROM users WHERE id = ?');
                $stmt->execute([$userId]);
                $user = $stmt->fetch(PDO::FETCH_ASSOC);

                if (!$user) {
                    $_SESSION['errors_login']['login_incorrect'] = 'User not found. Please log in again.';
                    header('Location: ../src/index.php');
                    exit();
                }

                $code = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 6);
                $_SESSION['EmailAuth'] = $code;

                $script = realpath(__DIR__ . '/emailSender.php');
                $cmdParts = [
                    'php',
                    escapeshellarg($script),
                    escapeshellarg($user['id']),
                    escapeshellarg('MFA'),
                    escapeshellarg(''),
                    escapeshellarg(''),
                    escapeshellarg(''),
                    escapeshellarg(''),
                    escapeshellarg(''),
                    escapeshellarg($code),
                    escapeshellarg('')
                ];
                pclose(popen('start /B ' . implode(' ', $cmdParts), 'r'));

                if ($AdminResendCode === 'true') {
                    header('Location: ../src/functions/adminMfaMailCode.php?resent=true');
                } else {
                    header('Location: ../src/functions/MFAauth.php?resent=true');
                }
                exit();
            }

            if ($hasCredentials && !$hasMfaCode) {
                $user = getUsername($pdo, $username);

                if (!$user) {
                    $_SESSION['errors_login']['login_incorrect'] = 'Incorrect username!';
                    header('Location: ../src/index.php?usernameLogin=wrong');
                    exit();
                }
                if (!password_verify($password, $user['password'])) {
                    $_SESSION['errors_login']['login_incorrect'] = 'Wrong password!';
                    header('Location: ../src/index.php?passwordLogin=wrong');
                    exit();
                }

                $status = 'pending';
                if ($user['user_role'] === 'employee') {
                    $stmt = $pdo->prepare('SELECT status FROM userRequest WHERE users_id = ? ORDER BY request_date DESC LIMIT 1');
                    $stmt->execute([$user['id']]);
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    $status = $row['status'] ?? 'pending';
                }

                session_regenerate_id(true);

                $code = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 6);
                $_SESSION['EmailAuth'] = $code;
                $_SESSION['pending_user_id'] = $user['id'];
                $_SESSION['pending_user_role'] = $user['user_role'];

                $script = realpath(__DIR__ . '/emailSender.php');
                $cmdParts = [
                    'php',
                    escapeshellarg($script),
                    escapeshellarg($user['id']),
                    escapeshellarg('MFA'),
                    escapeshellarg(''),
                    escapeshellarg(''),
                    escapeshellarg(''),
                    escapeshellarg(''),
                    escapeshellarg(''),
                    escapeshellarg($code),
                    escapeshellarg('')
                ];
                pclose(popen('start /B ' . implode(' ', $cmdParts), 'r'));

                if ($user['user_role'] === 'employee') {
                    switch ($status) {
                        case 'validated':
                            header('Location: ../src/functions/MFAauth.php');
                            break;
                        case 'rejected':
                            header('Location: ../src/employee/rejected.php');
                            break;
                        default:
                            header('Location: ../src/employee/pending.php');
                            break;
                    }
                } else {
                    header('Location: ../src/functions/adminMfaMailCode.php');
                }
                exit();
            }

            if ($hasMfaCode && !$hasCredentials) {
                $expected = $_SESSION['EmailAuth'] ?? '';
                $posted = $mailCode !== '' ? $mailCode : $adminMailCode;

                if ($posted !== $expected && $posted == $mailCode) {
                    header('Location: ../src/functions/MFAauth.php?mfa=failed');
                    exit();
                } elseif ($posted !== $expected && $posted == $adminMailCode) {
                    header('Location: ../src/functions/adminMfaMailCode.php?mfa=failed');
                    exit();
                }

                $userId = $_SESSION['pending_user_id'] ?? null;
                $userRole = $_SESSION['pending_user_role'] ?? null;
                if (!$userId || !$userRole) {
                    $_SESSION['errors_login']['login_incorrect'] = 'Session expired. Please log in again.';
                    header('Location: ../src/index.php');
                    exit();
                }

                $_SESSION['user_id'] = $userId;
                $_SESSION['user_role'] = $userRole;

                if ($userRole === 'employee') {
                    $stmt = $pdo->prepare('INSERT INTO employee_history (employee_id, login_time) VALUES (?, NOW())');
                    $stmt->execute([$userId]);
                    unset($_SESSION['pending_user_id'], $_SESSION['pending_user_role'], $_SESSION['EmailAuth']);
                    header('Location: ../src/employee/dashboard.php');
                    exit();
                }

                if ($userRole === 'administrator') {
                    $stmt = $pdo->prepare('INSERT INTO admin_history (admin_id, login_time) VALUES (?, NOW())');
                    $stmt->execute([$userId]);
                    unset($_SESSION['pending_user_id'], $_SESSION['pending_user_role'], $_SESSION['EmailAuth']);
                    header('Location: ../src/admin/dashboard.php');
                    exit();
                }

                $_SESSION['errors_login']['login_incorrect'] = 'Unknown user role';
                header('Location: ../src/index.php');
                exit();
            }

            $_SESSION['errors_login']['login_incorrect'] = 'Invalid form submission.';
            header('Location: ../src/index.php');
            exit();
        } catch (PDOException $e) {
            error_log('Login error: ' . $e->getMessage());
            $_SESSION['errors_login'] = ['login_incorrect' => 'System error'];
            header('Location: ../src/index.php');
            exit();
        }
    }

    // ============================= User Registration Authentication ============================= //
    if (isset($_POST["register_user"]) && $_POST["register_user"] === "true") {
        $lname = $_POST["lname"];
        $fname = $_POST["fname"];
        $mname = $_POST["mname"];
        $employeeID = $_POST["employeeID"];
        $department = $_POST["department"];
        $jobTitle = $_POST["jobTitle"];
        $slary_rate = $_POST["slary_rate"];
        $citizenship = $_POST["citizenship"];
        $gender = $_POST["gender"];
        $civil_status = $_POST["civil_status"];
        $religion = $_POST["religion"];
        $age = $_POST["age"];
        $birthday = $_POST["birthday"];
        $birthPlace = $_POST["birthPlace"];
        $contact = $_POST["contact"];
        $email = $_POST["email"];
        $scheduleFrom = $_POST["scheduleFrom"];
        $scheduleTo = $_POST["scheduleTo"];
        $houseBlock = $_POST["houseBlock"];
        $street = $_POST["street"];
        $subdivision = $_POST["subdivision"];
        $barangay = $_POST["barangay"];
        $city_muntinlupa = $_POST["city_muntinlupa"];
        $province = $_POST["province"];
        $zipCode = $_POST["zipCode"];
        $username = $_POST["username"];
        $password = $_POST["password"];
        $confirmPassword = $_POST["confirmPassword"];

        $errors = [];

        try {

            if (isset($_FILES["user_profile"]) && $_FILES["user_profile"]["error"] === 0) {
                $profile = $_FILES["user_profile"];

                if (empty_image($profile)) {
                    $errors["image_Empty"] = "Please insert your profile image!";
                }

                if (fileSize_notCompatible($profile)) {
                    $errors["large_File"] = "The image must not exceed 5MB!";
                }

                $allowed_types = [
                    "image/jpeg",
                    "image/jpg",
                    "image/png"
                ];

                if (image_notCompatible($profile, $allowed_types)) {
                    $errors["file_Types"] = "Only JPG, JPEG, PNG files are allowed.";
                }

                if (!$errors) {
                    $target_dir = "../assets/image/upload/";
                    $image_file_name = uniqid() . "-" . basename($profile["name"]);
                    $target_file = $target_dir . $image_file_name;

                    if (move_uploaded_file($profile["tmp_name"], $target_file)) {
                        $profile = $image_file_name;
                    } else {
                        $errors["upload_Error"] = "There was an error uploading your image.";
                    }
                }
            } else {
                $default_image = "../assets/image/users.png";
                $target_dir = "../assets/image/upload/";
                $image_file_name = uniqid() . "-users.png";
                $target_file = $target_dir . $image_file_name;

                if (copy($default_image, $target_file)) {
                    $profile = $image_file_name;
                } else {
                    $errors["upload_Error"] = "Failed to assign default profile image.";
                }
            }

            if (
                user_inputs(
                    $lname,
                    $fname,
                    $mname,
                    $employeeID,
                    $jobTitle,
                    $slary_rate,
                    $citizenship,
                    $gender,
                    $civil_status,
                    $birthday,
                    $contact,
                    $email,
                    $scheduleFrom,
                    $scheduleTo,
                    $street,
                    $barangay,
                    $city_muntinlupa,
                    $province,
                    $zipCode,
                    $username,
                    $password,
                    $confirmPassword
                )
            ) {
                $errors["empty_inputs"] = "Please fill out all fields!.";
            }

            if (invalid_email($email)) {
                $errors["invalid_email"] = "your email is invalid!";
            }
            if (email_registered($pdo, $email)) {
                $errors["email_registered"] = "your email is already registered!";
            }
            if (password_notMatch($confirmPassword, $password)) {
                $errors["password_notMatch"] = "Password not match!";
            }
            if (username_taken($pdo, $username)) {
                $errors["username_taken"] = "Username Already Taken!";
            }
            if (password_secured($password)) {
                $errors["password_secured"] = "password must be 8 characters above!";
            }
            if (password_security($password)) {
                $errors["password_security"] = "password must have at least 1 uppercase, numbers and unique characters like # or !.";
            }

            if ($errors) {
                $_SESSION["signup_errors"] = $errors;
                $signup_data = [
                    "lname" => $lname,
                    "fname" => $fname,
                    "mname" => $mname,
                    "employeeID" => $employeeID,
                    "department" => $department,
                    "jobTitle" => $jobTitle,
                    "slary_rate" => $slary_rate,
                    "citizenship" => $citizenship,
                    "gender" => $gender,
                    "civil_status" => $civil_status,
                    "religion" => $religion,
                    "age" => $age,
                    "birthday" => $birthday,
                    "birthPlace" => $birthPlace,
                    "contact" => $contact,
                    "email" => $email,
                    "scheduleFrom" => $scheduleFrom,
                    "scheduleTo" => $scheduleTo,
                    "houseBlock" => $houseBlock,
                    "street" => $street,
                    "subdivision" => $subdivision,
                    "barangay" => $barangay,
                    "city_muntinlupa" => $city_muntinlupa,
                    "province" => $province,
                    "zipCode" => $zipCode,
                    "username" => $username,
                    "password" => $password,
                    "confirmPassword" => $confirmPassword
                ];

                $_SESSION["user_signups"] = $signup_data;
                header("Location: ../src/register.php");
                die();
            }

            $usersID = employeeRegistration(
                $pdo,
                $lname,
                $fname,
                $mname,
                $citizenship,
                $gender,
                $civil_status,
                $religion,
                $age,
                $birthday,
                $birthPlace,
                $contact,
                $email,
                $slary_rate,
                $employeeID,
                $department,
                $jobTitle,
                $scheduleFrom,
                $scheduleTo,
                $houseBlock,
                $street,
                $subdivision,
                $barangay,
                $city_muntinlupa,
                $province,
                $zipCode,
                $profile,
                $username,
                $password
            );
            $query = "INSERT INTO reports (users_id, report_type) VALUES (:users_id, 'employeeRegistration')";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":users_id", $usersID);
            $stmt->execute();

            $query = "INSERT INTO personal_data_sheet (users_id) VALUES (:users_id);";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":users_id", $usersID);
            $stmt->execute();
            $pds_id = $pdo->lastInsertId();

            $query = "INSERT INTO userGovIDs (pds_id) VALUES (:pds_id);";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":pds_id", $pds_id);
            $stmt->execute();

            $query = "INSERT INTO spouseInfo (pds_id) VALUES (:pds_id);";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":pds_id", $pds_id);
            $stmt->execute();

            $levels = ['Elementary', 'Secondary', 'Vocational', 'College', 'Graduate'];

            $eduStmt = $pdo->prepare(
                "INSERT INTO educationInfo (pds_id, level)
                VALUES (:pds_id, :level)"
            );

            foreach ($levels as $lvl) {
                $eduStmt->execute([
                    ':pds_id' => $pds_id,
                    ':level' => $lvl
                ]);
            }

            $sql = "
                INSERT INTO parents (pds_id, relation)
                VALUES (?, 'Father'), (?, 'Mother')
                ON DUPLICATE KEY UPDATE pds_id = pds_id
            ";

            $stmt = $pdo->prepare($sql);
            $stmt->execute([$pds_id, $pds_id]);

            $query = "INSERT INTO otherInfo (pds_id) VALUES (:pds_id);";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":pds_id", $pds_id);
            $stmt->execute();

            // echo $usersID;
            header("Location: ../src/index.php?signup=success");

            $stmt = null;
            $pdo = null;

            die();

        } catch (PDOException $e) {
            die("Query Failed: " . $e->getMessage());
        }
    }

    // ============================= Job Titles and salary Authentication ============================= //
    if (isset($_POST["addJob"]) && $_POST["addJob"] === "true") {
        $jobTitle = $_POST["jobTitle"];

        try {
            if ($jobTitle) {
                $errors = [];
                if (JobTitleExist($pdo, $jobTitle)) {
                    $errors["JobExist"] = "Job Title Already Exist!";
                }
                if ($errors) {
                    header("Location: ../src/admin/job.php?Job=exist");
                    die();
                } else {
                    $query = "INSERT INTO jobTitles (jobTitle) VALUES (:jobTitle)";
                    $stmt = $pdo->prepare($query);
                    $stmt->bindParam(":jobTitle", $jobTitle);
                    $stmt->execute();

                    header("Location: ../src/admin/job.php?job=success");
                    $stmt = null;
                    $pdo = null;
                    die();
                }

            } else {
                echo "no input";
            }
        } catch (PDOException $e) {
            die("Query Failed: " . $e->getMessage());
        }
    }

    if (isset($_POST["deleteJobTitle"]) && $_POST["deleteJobTitle"] === "true") {
        $deleteJob = $_POST["deleteJob"];
        try {
            $query = "DELETE FROM jobtitles WHERE id = :id;";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":id", $deleteJob);
            $stmt->execute();

            header("Location: ../src/admin/job.php?deleteJob=success");
            $stmt = null;
            $pdo = null;
            die();
        } catch (PDOException $e) {
            die("Query Failed: " . $e->getMessage());
        }
    }

    if (isset($_POST["EditJobTitle"]) && $_POST["EditJobTitle"] === "true") {
        $editJobId = $_POST["editJobId"];
        $editJobTitle = $_POST["editJobTitle"];

        try {
            $errors = [];
            if (JobTitleExist($pdo, $editJobTitle)) {
                $errors["JobExist"] = "Job Title Already Exist!";
            }
            if ($errors) {
                header("Location: ../src/admin/job.php?Job=exist");
                die();
            }
            $query = "UPDATE jobtitles SET jobTitle = :jobTitle WHERE id = :id";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":id", $editJobId);
            $stmt->bindParam(":jobTitle", $editJobTitle);
            $stmt->execute();

            header("Location: ../src/admin/job.php?JobTitleExdit=success");
            $stmt = null;
            $pdo = null;
            die();
        } catch (PDOException $e) {
            die("Query Failed: " . $e->getMessage());
        }
    }

    if (isset($_POST["promotion"]) && $_POST["promotion"] === "true") {
        $users_id_job = $_POST["job_id"];
        $job_title = $_POST["job_title"];
        $salary_Range_From = $_POST["salary_Range_From"];
        $salary_Range_To = $_POST["salary_Range_To"];
        $salary = $_POST["salary"];

        $query = "SELECT * FROM userHr_Informations
        WHERE users_id = :users_id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":users_id", $users_id_job);
        $stmt->execute();
        $getJob = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($getJob) {
            $jobtitleRecent = $getJob["jobTitle"];
        }

        $query = "UPDATE userHr_Informations SET jobTitle = :jobTitle, salary_Range_From = :salary_Range_From, salary_Range_To = :salary_Range_To, salary = :salary WHERE users_id = :users_id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":users_id", $users_id_job);
        $stmt->bindParam(":jobTitle", $job_title);
        $stmt->bindParam(":salary_Range_From", $salary_Range_From);
        $stmt->bindParam(":salary_Range_To", $salary_Range_To);
        $stmt->bindParam(":salary", $salary);
        $stmt->execute();

        $scriptPath = realpath(__DIR__ . "/emailSender.php");
        $command = "start /B php " .
            escapeshellarg($scriptPath) . ' ' .
            escapeshellarg($users_id_job) . ' ' .
            escapeshellarg("promoted") . ' ' .
            escapeshellarg($jobtitleRecent) . ' ' .
            escapeshellarg($job_title) . ' ' .
            escapeshellarg($salary);

        pclose(popen($command, "r"));

        $query = "INSERT INTO reports (users_id, report_type) VALUES (:users_id, 'employeePromotion')";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":users_id", $users_id_job);
        $stmt->execute();

        header("Location: ../src/admin/job.php?promotion=success&tab=salaryManage");
        $stmt = null;
        $pdo = null;
        exit;
    }

    if (isset($_POST["editSalary"]) && $_POST["editSalary"] === "true") {
        $users_id_job = $_POST["users_id"];
        $job_title = $_POST["job_title"];
        $salary_Range_From = $_POST["salary_Range_From"];
        $salary_Range_To = $_POST["salary_Range_To"];
        $salary = $_POST["salary"];

        $query = "UPDATE userHr_Informations SET jobTitle = :jobTitle, salary_Range_From = :salary_Range_From, salary_Range_To = :salary_Range_To, salary = :salary WHERE users_id = :users_id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":users_id", $users_id_job);
        $stmt->bindParam(":jobTitle", $job_title);
        $stmt->bindParam(":salary_Range_From", $salary_Range_From);
        $stmt->bindParam(":salary_Range_To", $salary_Range_To);
        $stmt->bindParam(":salary", $salary);
        $stmt->execute();

        header("Location: ../src/admin/job.php?salary=success&tab=salaryManage");
        $stmt = null;
        $pdo = null;
        exit;
    }

    // ============================= ADMIN SETTINGS ============================= //
    if (isset($_POST["forgotPassword"]) && $_POST["forgotPassword"] === "true") {
        $usersnameAuth = $_POST["username"] ?? '';
        $mailCode = $_POST["mailCode"] ?? '';
        $new_password = $_POST["new_password"] ?? '';
        $confirm_password = $_POST["confirm_password"] ?? '';

        // =============== SEND TO EMAIL ====================== //

        try {
            $query = "SELECT username FROM users WHERE id = 1";
            $stmt = $pdo->prepare($query);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            $getUsername = $user["username"];



            if ($usersnameAuth !== null && $usersnameAuth === $getUsername) {
                $emailAuth = substr(str_shuffle("qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM123456789"), 0, 6);
                $employeeId = 1;
                $scriptPath = realpath(__DIR__ . "/emailSender.php");
                $command = "start /B php " .
                    escapeshellarg($scriptPath) . ' ' .
                    escapeshellarg($employeeId) . ' ' .
                    escapeshellarg("password") . ' ' .
                    escapeshellarg('') . ' ' .
                    escapeshellarg('') . ' ' .
                    escapeshellarg('') . ' ' .
                    escapeshellarg('') . ' ' .
                    escapeshellarg('') . ' ' .
                    escapeshellarg($emailAuth) . '"';
                pclose(popen($command, "r"));
                $_SESSION["EmailAuth"] = $emailAuth;
                header("Location: ../src/admin/changePass.php?username=success");
                die();
            } else if ($usersnameAuth !== '' && $usersnameAuth !== $getUsername) {
                header("Location: ../src/admin/settings.php?passwordAuthFailes=failed");
                die();
            } else if ($usersnameAuth !== '') {
                header("Location: ../src/admin/settings.php?passwordAuth=null");
                die();
            } elseif ($mailCode !== null && $mailCode == $_SESSION["EmailAuth"]) {
                if ($new_password !== $confirm_password) {
                    header("Location: ../src/admin/changePass.php?password=notMatch");
                    die();
                }
                if (empty($new_password) || empty($confirm_password)) {
                    header("Location: ../src/admin/changePass.php?password=empty");
                    die();
                }
                $hasedPass = password_hash($new_password, PASSWORD_DEFAULT);
                $query = "UPDATE users SET password = :password WHERE id = 1";
                $stmt = $pdo->prepare($query);
                $stmt->bindParam(":password", $hasedPass);
                $stmt->execute();

                header("Location: ../src/admin/settings.php?passwordChange=success");
                die();
            } elseif ($mailCode !== null && $mailCode !== $_SESSION["EmailAuth"]) {
                header("Location: ../src/admin/changePass.php?code=notMatch");
                die();
            }
        } catch (PDOException $e) {
            die("Query Failed: " . $e->getMessage());
        }
    }

    // ============================= Employee Authentication ============================= //
    if (isset($_POST["acceptEmployee"]) && $_POST["acceptEmployee"] === "true") {
        $employeeId = $_POST["employeeId"];
        try {
            $query = "SELECT email, fname, lname FROM userinformations WHERE users_id = :users_id";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":users_id", $employeeId);
            $stmt->execute();
            $emailResult = $stmt->fetch(PDO::FETCH_ASSOC);

            $query = "UPDATE userrequest SET status = 'validated' WHERE users_id = :users_id";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":users_id", $employeeId);
            $stmt->execute();

            $query = "UPDATE reports SET report_type = 'employeeValidated' WHERE users_id = :users_id";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam("users_id", $employeeId);
            $stmt->execute();

            $query = "INSERT INTO leaveCounts (users_id, VacationBalance, SickBalance, SpecialBalance, OthersBalance
            ) VALUES (
            :users_id, 10, 10, 10, 10);";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":users_id", $employeeId);
            $stmt->execute();

            $scriptPath = realpath(__DIR__ . "/emailSender.php");
            $command = "start /B php " .
                escapeshellarg($scriptPath) . ' ' .
                escapeshellarg($employeeId) . ' ' .
                escapeshellarg("accepted") . ' ' .
                escapeshellarg('') . ' ' .
                escapeshellarg('') . ' ' .
                escapeshellarg('') . ' ' .
                escapeshellarg('') . ' ' .
                escapeshellarg('') . ' ' .
                escapeshellarg('') . ' ' .
                escapeshellarg('');

            pclose(popen($command, "r"));

            header("Location: ../src/admin/employee.php?acceptEmployee=success&tab=accept");
            $stmt = null;
            $pdo = null;
            die();
        } catch (PDOException $e) {
            die("Query Failed: " . $e->getMessage());
        }
    }


    if (isset($_POST["rejectEmployee"]) && $_POST["rejectEmployee"] === "true") {
        $employeeId = $_POST["employeeId"];
        try {
            $query = "UPDATE userrequest SET status = 'rejected' WHERE users_id = :users_id";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":users_id", $employeeId);
            $stmt->execute();

            $query = "UPDATE reports SET report_type = 'employeeRejected' WHERE users_id = :users_id";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam("users_id", $employeeId);
            $stmt->execute();

            $scriptPath = realpath(__DIR__ . "/emailSender.php");
            $command = "start /B php " .
                escapeshellarg($scriptPath) . ' ' .
                escapeshellarg($employeeId) . ' ' .
                escapeshellarg("rejected") . ' ' .
                escapeshellarg('') . ' ' .
                escapeshellarg('') . ' ' .
                escapeshellarg('') . ' ' .
                escapeshellarg('') . ' ' .
                escapeshellarg('') . ' ' .
                escapeshellarg('');

            pclose(popen($command, "r"));

            header("Location: ../src/admin/employee.php?rejectEmployee=success&tab=request");
            $stmt = null;
            $pdo = null;
            die();
        } catch (PDOException $e) {
            die("Query Failed: " . $e->getMessage());
        }
    }

    if (isset($_POST["deleteValidatedEmployee"]) && $_POST["deleteValidatedEmployee"] === "true") {
        $delete_user_id = $_POST["delete_user_id"];
        try {
            $query = "DELETE FROM users WHERE id = :id";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":id", $delete_user_id);
            $stmt->execute();
            header("Location: ../src/admin/employee.php?deleteValidatedEmployee=success&tab=delete");
            $stmt = null;
            $pdo = null;
            die();
        } catch (PDOException $e) {
            die("Query Failed: " . $e->getMessage());
        }
    }

    // ============================= PROFILING Authentication ============================= //
    if (isset($_POST["requestUpdate"]) && $_POST["requestUpdate"] === "true") {
        $users_id = (int) $_POST["users_id"];
        $lname = $_POST["lname"];
        $fname = $_POST["fname"];
        $mname = $_POST["mname"];
        $suffix = $_POST["suffix"];
        $employeeID = $_POST["employeeID"];
        $department = $_POST["department"];
        $jobTitle = $_POST["jobTitle"];
        $salary_rate = $_POST["salary_rate"];
        $salary_Range_From = $_POST["salary_Range_From"];
        $salary_Range_To = $_POST["salary_Range_To"];
        $salary = $_POST["salary"];
        $citizenship = $_POST["citizenship"];
        $gender = $_POST["gender"];
        $civil_status = $_POST["civil_status"];
        $religion = $_POST["religion"];
        $age = $_POST["age"];
        $birthday = $_POST["birthday"];
        $birthPlace = $_POST["birthPlace"];
        $contact = $_POST["contact"];
        $email = $_POST["email"];
        $scheduleFrom = $_POST["scheduleFrom"];
        $scheduleTo = $_POST["scheduleTo"];
        $houseBlock = $_POST["houseBlock"];
        $street = $_POST["street"];
        $subdivision = $_POST["subdivision"];
        $barangay = $_POST["barangay"];
        $city_muntinlupa = $_POST["city_muntinlupa"];
        $province = $_POST["province"];
        $zipCode = $_POST["zipCode"];
        $profile = $_POST["current_profile_image"];

        $errors = [];

        try {
            if (isset($_FILES["user_profile"]) && $_FILES["user_profile"]["error"] === 0) {
                $profile = $_FILES["user_profile"];

                if (empty_image($profile)) {
                    $errors["image_Empty"] = "Please insert your profile image!";
                }

                if (fileSize_notCompatible($profile)) {
                    $errors["large_File"] = "The image must not exceed 5MB!";
                }

                $allowed_types = ["image/jpeg", "image/jpg", "image/png"];
                if (image_notCompatible($profile, $allowed_types)) {
                    $errors["file_Types"] = "Only JPG, JPEG, PNG files are allowed.";
                }

                if (!$errors) {
                    $target_dir = "../assets/image/upload/";
                    $image_file_name = uniqid() . "-" . basename($profile["name"]);
                    $target_file = $target_dir . $image_file_name;

                    if (move_uploaded_file($profile["tmp_name"], $target_file)) {
                        $profile = $image_file_name;
                    } else {
                        $errors["upload_Error"] = "There was an error uploading your image.";
                    }
                }
            } else {
                $profile = $_POST["current_profile_image"];
            }

            if (invalid_email($email)) {
                $errors["invalid_email"] = "Your email is invalid!";
            }
            if (email_registeredUpdate($pdo, $email, $users_id)) {
                $errors["email_registered"] = "Your email is already registered!";
            }

            if ($errors) {
                header("Location: ../src/admin/profileReq.php?users_id=" . $users_id . "&updateReqFailed=failed");
                exit();
            }

            updateReq(
                $pdo,
                $users_id,
                $lname,
                $fname,
                $mname,
                $suffix,
                $employeeID,
                $department,
                $jobTitle,
                $salary_rate,
                $salary_Range_From,
                $salary_Range_To,
                $salary,
                $citizenship,
                $gender,
                $civil_status,
                $religion,
                $age,
                $birthday,
                $birthPlace,
                $contact,
                $email,
                $scheduleFrom,
                $scheduleTo,
                $houseBlock,
                $street,
                $subdivision,
                $barangay,
                $city_muntinlupa,
                $province,
                $zipCode,
                $profile
            );

            header("Location: ../src/admin/profileReq.php?updateReq=success&users_id=" . $users_id);
            exit();
        } catch (PDOException $e) {
            die("Query Failed: " . $e->getMessage());
        }
    }

    if (isset($_POST["validatedUpdate"]) && $_POST["validatedUpdate"] === "true") {
        $users_id = (int) $_POST["users_id"];
        $lname = $_POST["lname"];
        $fname = $_POST["fname"];
        $mname = $_POST["mname"];
        $suffix = $_POST["suffix"];
        $employeeID = $_POST["employeeID"];
        $department = $_POST["department"];
        $jobTitle = $_POST["jobTitle"];
        $salary_rate = $_POST["salary_rate"];
        $salary_Range_From = $_POST["salary_Range_From"];
        $salary_Range_To = $_POST["salary_Range_To"];
        $salary = $_POST["salary"];
        $citizenship = $_POST["citizenship"];
        $gender = $_POST["gender"];
        $civil_status = $_POST["civil_status"];
        $religion = $_POST["religion"];
        $age = $_POST["age"];
        $birthday = $_POST["birthday"];
        $birthPlace = $_POST["birthPlace"];
        $contact = $_POST["contact"];
        $email = $_POST["email"];
        $scheduleFrom = $_POST["scheduleFrom"];
        $scheduleTo = $_POST["scheduleTo"];
        $houseBlock = $_POST["houseBlock"];
        $street = $_POST["street"];
        $subdivision = $_POST["subdivision"];
        $barangay = $_POST["barangay"];
        $city_muntinlupa = $_POST["city_muntinlupa"];
        $province = $_POST["province"];
        $zipCode = $_POST["zipCode"];
        $profile = $_POST["current_profile_image"];

        $errors = [];

        try {
            if (isset($_FILES["user_profile"]) && $_FILES["user_profile"]["error"] === 0) {
                $profile = $_FILES["user_profile"];

                if (empty_image($profile)) {
                    $errors["image_Empty"] = "Please insert your profile image!";
                }

                if (fileSize_notCompatible($profile)) {
                    $errors["large_File"] = "The image must not exceed 5MB!";
                }

                $allowed_types = ["image/jpeg", "image/jpg", "image/png"];
                if (image_notCompatible($profile, $allowed_types)) {
                    $errors["file_Types"] = "Only JPG, JPEG, PNG files are allowed.";
                }

                if (!$errors) {
                    $target_dir = "../assets/image/upload/";
                    $image_file_name = uniqid() . "-" . basename($profile["name"]);
                    $target_file = $target_dir . $image_file_name;

                    if (move_uploaded_file($profile["tmp_name"], $target_file)) {
                        $profile = $image_file_name;
                    } else {
                        $errors["upload_Error"] = "There was an error uploading your image.";
                    }
                }
            } else {
                $profile = $_POST["current_profile_image"];
            }

            if (invalid_email($email)) {
                $errors["invalid_email"] = "Your email is invalid!";
            }
            if (email_registeredUpdate($pdo, $email, $users_id)) {
                $errors["email_registered"] = "Your email is already registered!";
            }

            if ($errors) {
                header("Location: ../src/admin/profile.php?users_id=" . $users_id . "&updateValFailed=failed");
                exit();
            }

            updateReq(
                $pdo,
                $users_id,
                $lname,
                $fname,
                $mname,
                $suffix,
                $employeeID,
                $department,
                $jobTitle,
                $salary_rate,
                $salary_Range_From,
                $salary_Range_To,
                $salary,
                $citizenship,
                $gender,
                $civil_status,
                $religion,
                $age,
                $birthday,
                $birthPlace,
                $contact,
                $email,
                $scheduleFrom,
                $scheduleTo,
                $houseBlock,
                $street,
                $subdivision,
                $barangay,
                $city_muntinlupa,
                $province,
                $zipCode,
                $profile
            );

            header("Location: ../src/admin/profile.php?updateVal=success&users_id=" . $users_id . "&tab=personal");
            exit();
        } catch (PDOException $e) {
            die("Query Failed: " . $e->getMessage());
        }
    }

    if (isset($_POST["educationalUpdate"]) && $_POST["educationalUpdate"] === "true") {
        $users_id = $_POST['users_id'] ?? null;

        $educations = [
            [
                'level' => 'elementary',
                'school_name' => $_POST['elementary_school'] ?? null,
                'course_or_strand' => null,
                'year_started' => $_POST['elementary_year_started'] ?? null,
                'year_ended' => $_POST['elementary_year_ended'] ?? null,
                'honors' => $_POST['elementary_honors'] ?? null
            ],
            [
                'level' => 'high_school',
                'school_name' => $_POST['high_school_school'] ?? null,
                'course_or_strand' => null,
                'year_started' => $_POST['high_school_year_started'] ?? null,
                'year_ended' => $_POST['high_school_year_ended'] ?? null,
                'honors' => $_POST['high_school_honors'] ?? null
            ],
            [
                'level' => 'senior_high',
                'school_name' => $_POST['senior_high_school'] ?? null,
                'course_or_strand' => $_POST['senior_high_course'] ?? null,
                'year_started' => $_POST['senior_high_year_started'] ?? null,
                'year_ended' => $_POST['senior_high_year_ended'] ?? null,
                'honors' => $_POST['senior_high_honors'] ?? null
            ],
            [
                'level' => 'college',
                'school_name' => $_POST['college_school'] ?? null,
                'course_or_strand' => $_POST['college_course'] ?? null,
                'year_started' => $_POST['college_year_started'] ?? null,
                'year_ended' => $_POST['college_year_ended'] ?? null,
                'honors' => $_POST['college_honors'] ?? null
            ],
            [
                'level' => 'graduate',
                'school_name' => $_POST['graduate_school'] ?? null,
                'course_or_strand' => $_POST['graduate_course'] ?? null,
                'year_started' => $_POST['graduate_year_started'] ?? null,
                'year_ended' => $_POST['graduate_year_ended'] ?? null,
                'honors' => $_POST['graduate_honors'] ?? null
            ]
        ];

        try {
            $pdo->beginTransaction();

            $deleteStmt = $pdo->prepare("DELETE FROM educational_background WHERE users_id = ?");
            $deleteStmt->execute([$users_id]);

            $insertSql = "
                INSERT INTO educational_background 
                (users_id, level, school_name, course_or_strand, year_started, year_ended, honors, created_at, updated_at)
                VALUES 
                (:users_id, :level, :school_name, :course_or_strand, :year_started, :year_ended, :honors, NOW(), NOW())
            ";
            $insertStmt = $pdo->prepare($insertSql);

            foreach ($educations as $edu) {
                if (empty($edu['school_name']))
                    continue;

                $year_started = !empty($edu['year_started']) ? $edu['year_started'] : null;
                $year_ended = !empty($edu['year_ended']) ? $edu['year_ended'] : null;

                $insertStmt->execute([
                    ':users_id' => $users_id,
                    ':level' => $edu['level'],
                    ':school_name' => $edu['school_name'],
                    ':course_or_strand' => $edu['course_or_strand'],
                    ':year_started' => $year_started,
                    ':year_ended' => $year_ended,
                    ':honors' => $edu['honors'],
                ]);
            }

            $pdo->commit();

            header("Location: ../src/admin/profile.php?upsert=success&users_id=" . $users_id . "&tab=educational");
            exit;
        } catch (PDOException $e) {
            $pdo->rollBack();
            header("Location: ../src/admin/profile.php?upsert=failed&users_id=" . $users_id . "&tab=educational");
            exit;
        }
    }

    if (isset($_POST["familyUpdate"]) && $_POST["familyUpdate"] === "true") {
        $users_id = $_POST['users_id'] ?? null;

        $father_name = $_POST['father_name'] ?? '';
        $father_occupation = $_POST['father_occupation'] ?? '';
        $father_contact = $_POST['father_contact'] ?? '';

        $mother_name = $_POST['mother_name'] ?? '';
        $mother_occupation = $_POST['mother_occupation'] ?? '';
        $mother_contact = $_POST['mother_contact'] ?? '';

        $guardian_name = $_POST['guardian_name'] ?? '';
        $guardian_relationship = $_POST['guardian_relationship'] ?? '';
        $guardian_contact = $_POST['guardian_contact'] ?? '';

        $father_houseBlock = $_POST['father_houseBlock'] ?? '';
        $father_street = $_POST['father_street'] ?? '';
        $father_subdivision = $_POST['father_subdivision'] ?? '';
        $father_barangay = $_POST['father_barangay'] ?? '';
        $father_city_muntinlupa = $_POST['father_city_muntinlupa'] ?? '';
        $father_province = $_POST['father_province'] ?? '';
        $father_zip_code = $_POST['father_zip_code'] ?? '';

        $mother_houseBlock = $_POST['mother_houseBlock'] ?? '';
        $mother_street = $_POST['mother_street'] ?? '';
        $mother_subdivision = $_POST['mother_subdivision'] ?? '';
        $mother_barangay = $_POST['mother_barangay'] ?? '';
        $mother_city_muntinlupa = $_POST['mother_city_muntinlupa'] ?? '';
        $mother_province = $_POST['mother_province'] ?? '';
        $mother_zip_code = $_POST['mother_zip_code'] ?? '';

        $guardian_houseBlock = $_POST['guardian_houseBlock'] ?? '';
        $guardian_street = $_POST['guardian_street'] ?? '';
        $guardian_subdivision = $_POST['guardian_subdivision'] ?? '';
        $guardian_barangay = $_POST['guardian_barangay'] ?? '';
        $guardian_city_muntinlupa = $_POST['guardian_city_muntinlupa'] ?? '';
        $guardian_province = $_POST['guardian_province'] ?? '';
        $guardian_zip_code = $_POST['guardian_zip_code'] ?? '';

        if (!$users_id) {
            header("Location: ../src/admin/profile.php?upsert=failed&tab=family");
            exit;
        }

        try {
            $checkStmt = $pdo->prepare("SELECT id FROM family_information WHERE users_id = :users_id");
            $checkStmt->execute([':users_id' => $users_id]);
            $existingFamily = $checkStmt->fetch(PDO::FETCH_ASSOC);

            $familyParams = [
                ':users_id' => $users_id,
                ':father_name' => $father_name,
                ':father_occupation' => $father_occupation,
                ':father_contact' => $father_contact,
                ':mother_name' => $mother_name,
                ':mother_occupation' => $mother_occupation,
                ':mother_contact' => $mother_contact,
                ':guardian_name' => $guardian_name,
                ':guardian_relationship' => $guardian_relationship,
                ':guardian_contact' => $guardian_contact
            ];

            $addressParams = [
                ':users_id' => $users_id,
                ':father_houseBlock' => $father_houseBlock,
                ':father_street' => $father_street,
                ':father_subdivision' => $father_subdivision,
                ':father_barangay' => $father_barangay,
                ':father_city_muntinlupa' => $father_city_muntinlupa,
                ':father_province' => $father_province,
                ':father_zip_code' => $father_zip_code,
                ':mother_houseBlock' => $mother_houseBlock,
                ':mother_street' => $mother_street,
                ':mother_subdivision' => $mother_subdivision,
                ':mother_barangay' => $mother_barangay,
                ':mother_city_muntinlupa' => $mother_city_muntinlupa,
                ':mother_province' => $mother_province,
                ':mother_zip_code' => $mother_zip_code,
                ':guardian_houseBlock' => $guardian_houseBlock,
                ':guardian_street' => $guardian_street,
                ':guardian_subdivision' => $guardian_subdivision,
                ':guardian_barangay' => $guardian_barangay,
                ':guardian_city_muntinlupa' => $guardian_city_muntinlupa,
                ':guardian_province' => $guardian_province,
                ':guardian_zip_code' => $guardian_zip_code
            ];

            if ($existingFamily) {
                $updateFamilyInfoStmt = $pdo->prepare("UPDATE family_information SET
                    father_name = :father_name,
                    father_occupation = :father_occupation,
                    father_contact = :father_contact,
                    mother_name = :mother_name,
                    mother_occupation = :mother_occupation,
                    mother_contact = :mother_contact,
                    guardian_name = :guardian_name,
                    guardian_relationship = :guardian_relationship,
                    guardian_contact = :guardian_contact
                    WHERE users_id = :users_id");

                $updateFamilyInfoStmt->execute($familyParams);

                $updateFamilyAddressStmt = $pdo->prepare("UPDATE family_informationAddress SET
                    father_houseBlock = :father_houseBlock,
                    father_street = :father_street,
                    father_subdivision = :father_subdivision,
                    father_barangay = :father_barangay,
                    father_city_muntinlupa = :father_city_muntinlupa,
                    father_province = :father_province,
                    father_zip_code = :father_zip_code,
                    
                    mother_houseBlock = :mother_houseBlock,
                    mother_street = :mother_street,
                    mother_subdivision = :mother_subdivision,
                    mother_barangay = :mother_barangay,
                    mother_city_muntinlupa = :mother_city_muntinlupa,
                    mother_province = :mother_province,
                    mother_zip_code = :mother_zip_code,
                    
                    guardian_houseBlock = :guardian_houseBlock,
                    guardian_street = :guardian_street,
                    guardian_subdivision = :guardian_subdivision,
                    guardian_barangay = :guardian_barangay,
                    guardian_city_muntinlupa = :guardian_city_muntinlupa,
                    guardian_province = :guardian_province,
                    guardian_zip_code = :guardian_zip_code
                    WHERE users_id = :users_id");

                $updateFamilyAddressStmt->execute($addressParams);
            } else {
                $insertFamilyInfoStmt = $pdo->prepare("INSERT INTO family_information (users_id, father_name, father_occupation, father_contact, mother_name, mother_occupation, mother_contact, guardian_name, guardian_relationship, guardian_contact) 
                    VALUES (:users_id, :father_name, :father_occupation, :father_contact, :mother_name, :mother_occupation, :mother_contact, :guardian_name, :guardian_relationship, :guardian_contact)");

                $insertFamilyInfoStmt->execute($familyParams);

                $insertFamilyAddressStmt = $pdo->prepare("INSERT INTO family_informationAddress (users_id, father_houseBlock, father_street, father_subdivision, father_barangay, father_city_muntinlupa, father_province, father_zip_code, mother_houseBlock, mother_street, mother_subdivision, mother_barangay, mother_city_muntinlupa, mother_province, mother_zip_code, guardian_houseBlock, guardian_street, guardian_subdivision, guardian_barangay, guardian_city_muntinlupa, guardian_province, guardian_zip_code) 
                    VALUES (:users_id, :father_houseBlock, :father_street, :father_subdivision, :father_barangay, :father_city_muntinlupa, :father_province, :father_zip_code, :mother_houseBlock, :mother_street, :mother_subdivision, :mother_barangay, :mother_city_muntinlupa, :mother_province, :mother_zip_code, :guardian_houseBlock, :guardian_street, :guardian_subdivision, :guardian_barangay, :guardian_city_muntinlupa, :guardian_province, :guardian_zip_code)");

                $insertFamilyAddressStmt->execute($addressParams);
            }

            header("Location: ../src/admin/profile.php?upsert=success&tab=family&users_id=" . $users_id);
            exit;

        } catch (PDOException $e) {
            error_log("Error: " . $e->getMessage());

            header("Location: ../src/admin/profile.php?upsert=failed&tab=family&users_id=" . $users_id);
            exit;
        }
    }

    if (isset($_POST["add_employee"]) && $_POST["add_employee"] === "true") {
        $lname = $_POST["lname"];
        $fname = $_POST["fname"];
        $mname = $_POST["mname"];
        $employeeID = $_POST["employeeID"];
        $department = $_POST["department"];
        $jobTitle = $_POST["jobTitle"];
        $slary_rate = $_POST["slary_rate"];
        $salary_Range_From = intval($_POST["salary_Range_From"]);
        $salary_Range_To = intval($_POST["salary_Range_To"]);
        $salary = $_POST["salary"];
        $citizenship = $_POST["citizenship"];
        $gender = $_POST["gender"];
        $civil_status = $_POST["civil_status"];
        $religion = $_POST["religion"];
        $age = $_POST["age"];
        $birthday = $_POST["birthday"];
        $birthPlace = $_POST["birthPlace"];
        $contact = $_POST["contact"];
        $email = $_POST["email"];
        $scheduleFrom = $_POST["scheduleFrom"];
        $scheduleTo = $_POST["scheduleTo"];
        $houseBlock = $_POST["houseBlock"];
        $street = $_POST["street"];
        $subdivision = $_POST["subdivision"];
        $barangay = $_POST["barangay"];
        $city_muntinlupa = $_POST["city_muntinlupa"];
        $province = $_POST["province"];
        $zipCode = $_POST["zipCode"];
        $username = $_POST["username"];
        $password = $_POST["password"];
        $confirmPassword = $_POST["confirmPassword"];

        $errors = [];

        try {

            if (isset($_FILES["user_profile"]) && $_FILES["user_profile"]["error"] === 0) {
                $profile = $_FILES["user_profile"];

                if (empty_image($profile)) {
                    $errors["image_Empty"] = "Please insert your profile image!";
                }

                if (fileSize_notCompatible($profile)) {
                    $errors["large_File"] = "The image must not exceed 5MB!";
                }

                $allowed_types = [
                    "image/jpeg",
                    "image/jpg",
                    "image/png"
                ];

                if (image_notCompatible($profile, $allowed_types)) {
                    $errors["file_Types"] = "Only JPG, JPEG, PNG files are allowed.";
                }

                if (!$errors) {
                    $target_dir = "../assets/image/upload/";
                    $image_file_name = uniqid() . "-" . basename($profile["name"]);
                    $target_file = $target_dir . $image_file_name;

                    if (move_uploaded_file($profile["tmp_name"], $target_file)) {
                        $profile = $image_file_name;
                    } else {
                        $errors["upload_Error"] = "There was an error uploading your image.";
                    }
                }
            } else {
                $default_image = "../assets/image/users.png";
                $target_dir = "../assets/image/upload/";
                $image_file_name = uniqid() . "-users.png";
                $target_file = $target_dir . $image_file_name;

                if (copy($default_image, $target_file)) {
                    $profile = $image_file_name;
                } else {
                    $errors["upload_Error"] = "Failed to assign default profile image.";
                }
            }

            if (
                user_inputs(
                    $lname,
                    $fname,
                    $mname,
                    $employeeID,
                    $jobTitle,
                    $salary_rate,
                    $salary_Range_From,
                    $salary_Range_To,
                    $salary,
                    $citizenship,
                    $gender,
                    $civil_status,
                    $birthday,
                    $contact,
                    $email,
                    $scheduleFrom,
                    $scheduleTo,
                    $street,
                    $barangay,
                    $city_muntinlupa,
                    $province,
                    $zipCode,
                    $username,
                    $password,
                    $confirmPassword
                )
            ) {
                $errors["empty_inputs"] = "Please fill out all fields!";
            }

            if (invalid_email($email)) {
                $errors["invalid_email"] = "your email is invalid!";
            }
            if (email_registered($pdo, $email)) {
                $errors["email_registered"] = "your email is already registered!";
            }
            if (password_notMatch($confirmPassword, $password)) {
                $errors["password_notMatch"] = "Password not match!";
            }
            if (username_taken($pdo, $username)) {
                $errors["username_taken"] = "Username Already Taken!";
            }
            if (password_secured($password)) {
                $errors["password_secured"] = "password must be 8 characters above!";
            }
            if (password_security($password)) {
                $errors["password_security"] = "password must have at least 1 uppercase, numbers and unique characters like # or !.";
            }

            if ($errors) {
                $_SESSION["signup_errors"] = $errors;
                $signup_data = [
                    "lname" => $lname,
                    "fname" => $fname,
                    "mname" => $mname,
                    "employeeID" => $employeeID,
                    "department" => $department,
                    "jobTitle" => $jobTitle,
                    "slary_rate" => $slary_rate,
                    "salary_Range_From" => $salary_Range_From,
                    "salary_Range_To" => $salary_Range_To,
                    "salary" => $salary,
                    "citizenship" => $citizenship,
                    "gender" => $gender,
                    "civil_status" => $civil_status,
                    "religion" => $religion,
                    "age" => $age,
                    "birthday" => $birthday,
                    "birthPlace" => $birthPlace,
                    "contact" => $contact,
                    "email" => $email,
                    "scheduleFrom" => $scheduleFrom,
                    "scheduleTo" => $scheduleTo,
                    "houseBlock" => $houseBlock,
                    "street" => $street,
                    "subdivision" => $subdivision,
                    "barangay" => $barangay,
                    "city_muntinlupa" => $city_muntinlupa,
                    "province" => $province,
                    "zipCode" => $zipCode,
                    "username" => $username,
                    "password" => $password,
                    "confirmPassword" => $confirmPassword
                ];

                $_SESSION["user_signups"] = $signup_data;
                header("Location: ../src/admin/register.php");
                die();
            }

            $createdUserId = adminRegistration(
                $pdo,
                $lname,
                $fname,
                $mname,
                $citizenship,
                $gender,
                $civil_status,
                $religion,
                $age,
                $birthday,
                $birthPlace,
                $contact,
                $email,
                $slary_rate,
                $salary_Range_From,
                $salary_Range_To,
                $employeeID,
                $department,
                $jobTitle,
                $salary,
                $scheduleFrom,
                $scheduleTo,
                $houseBlock,
                $street,
                $subdivision,
                $barangay,
                $city_muntinlupa,
                $province,
                $zipCode,
                $profile,
                $username,
                $password
            );

            $createdUserId += 1;
            $query = "INSERT INTO leaveCounts (users_id, VacationBalance, SickBalance, SpecialBalance, OthersBalance
            ) VALUES (
            :users_id, 10, 10, 10, 10);";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":users_id", $createdUserId);
            $stmt->execute();

            $query = "INSERT INTO personal_data_sheet (users_id) VALUES (:users_id);";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":users_id", $createdUserId);
            $stmt->execute();
            $pds_id = $pdo->lastInsertId();

            $query = "INSERT INTO userGovIDs (pds_id) VALUES (:pds_id);";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":pds_id", $pds_id);
            $stmt->execute();

            $query = "INSERT INTO spouseInfo (pds_id) VALUES (:pds_id);";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":pds_id", $pds_id);
            $stmt->execute();

            $sql = "
                INSERT INTO parents (pds_id, relation)
                VALUES (?, 'Father'), (?, 'Mother')
                ON DUPLICATE KEY UPDATE pds_id = pds_id
            ";

            $stmt = $pdo->prepare($sql);
            $stmt->execute([$pds_id, $pds_id]);

            $levels = ['Elementary', 'Secondary', 'Vocational', 'College', 'Graduate'];

            $eduStmt = $pdo->prepare(
                "INSERT INTO educationInfo (pds_id, level)
                VALUES (:pds_id, :level)"
            );

            foreach ($levels as $lvl) {
                $eduStmt->execute([
                    ':pds_id' => $pds_id,
                    ':level' => $lvl
                ]);
            }

            $query = "INSERT INTO otherInfo (pds_id) VALUES (:pds_id);";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":pds_id", $pds_id);
            $stmt->execute();

            if (!$createdUserId) {
                die("Failed to get newly created user's ID");
            }
            $scriptPath = realpath(__DIR__ . "/emailSender.php");
            $phpPath = 'C:\\xampp\\php\\php.exe';

            $command = 'cmd.exe /C "start /B "" ' .
                escapeshellarg($phpPath) . ' ' .
                escapeshellarg($scriptPath) . ' ' .
                escapeshellarg($createdUserId) . ' ' .
                escapeshellarg("created") . ' ' .
                escapeshellarg('') . ' ' .
                escapeshellarg('') . ' ' .
                escapeshellarg('') . ' ' .
                escapeshellarg($username) . ' ' .
                escapeshellarg($password) . ' ';
            escapeshellarg($password);

            pclose(popen($command, "r"));


            header("Location: ../src/admin/employee.php?acceptEmployee=success&tab=accept");

            $stmt = null;
            $pdo = null;

            die();

        } catch (PDOException $e) {
            die("Query Failed: " . $e->getMessage());
        }
    }

    // =============================== EMPLOYEE AREA =============================== //
    if (isset($_POST["userUpdateProfile"]) && $_POST["userUpdateProfile"] === "true") {
        $users_id = (int) $_POST["users_id"];
        $lname = $_POST["lname"];
        $fname = $_POST["fname"];
        $mname = $_POST["mname"];
        $suffix = $_POST["suffix"];
        $employeeID = $_POST["employeeID"];
        $department = $_POST["department"];
        $jobTitle = $_POST["jobTitle"];
        $salary_rate = $_POST["salary_rate"];
        $salary_Range_From = $_POST["salary_Range_From"];
        $salary_Range_To = $_POST["salary_Range_To"];
        $salary = $_POST["salary"];
        $citizenship = $_POST["citizenship"];
        $gender = $_POST["gender"];
        $civil_status = $_POST["civil_status"];
        $religion = $_POST["religion"];
        $age = $_POST["age"];
        $birthday = $_POST["birthday"];
        $birthPlace = $_POST["birthPlace"];
        $contact = $_POST["contact"];
        $email = $_POST["email"];
        $scheduleFrom = $_POST["scheduleFrom"];
        $scheduleTo = $_POST["scheduleTo"];
        $houseBlock = $_POST["houseBlock"];
        $street = $_POST["street"];
        $subdivision = $_POST["subdivision"];
        $barangay = $_POST["barangay"];
        $city_muntinlupa = $_POST["city_muntinlupa"];
        $province = $_POST["province"];
        $zipCode = $_POST["zipCode"];
        $profile = $_POST["current_profile_image"];

        $errors = [];

        try {
            if (isset($_FILES["user_profile"]) && $_FILES["user_profile"]["error"] === 0) {
                $profile = $_FILES["user_profile"];

                if (empty_image($profile)) {
                    $errors["image_Empty"] = "Please insert your profile image!";
                }

                if (fileSize_notCompatible($profile)) {
                    $errors["large_File"] = "The image must not exceed 5MB!";
                }

                $allowed_types = ["image/jpeg", "image/jpg", "image/png"];
                if (image_notCompatible($profile, $allowed_types)) {
                    $errors["file_Types"] = "Only JPG, JPEG, PNG files are allowed.";
                }

                if (!$errors) {
                    $target_dir = "../assets/image/upload/";
                    $image_file_name = uniqid() . "-" . basename($profile["name"]);
                    $target_file = $target_dir . $image_file_name;

                    if (move_uploaded_file($profile["tmp_name"], $target_file)) {
                        $profile = $image_file_name;
                    } else {
                        $errors["upload_Error"] = "There was an error uploading your image.";
                    }
                }
            } else {
                $profile = $_POST["current_profile_image"];
            }

            if (invalid_email($email)) {
                header("Location: ../src/employee/profile.php?users_id=" . $users_id . "&InvalidEmail=failed");
                exit();
            }
            // if (email_registeredUpdate($pdo, $email, $users_id)) { 
            //      header("Location: ../src/employee/profile.php?users_id=" . $users_id . "&mail=failed");
            //      exit();
            // }

            if ($errors) {
                header("Location: ../src/employee/profile.php?users_id=" . $users_id . "&updateValFailed=failed");
                exit();
            }

            updateReq(
                $pdo,
                $users_id,
                $lname,
                $fname,
                $mname,
                $suffix,
                $employeeID,
                $department,
                $jobTitle,
                $salary_rate,
                $salary_Range_From,
                $salary_Range_To,
                $salary,
                $citizenship,
                $gender,
                $civil_status,
                $religion,
                $age,
                $birthday,
                $birthPlace,
                $contact,
                $email,
                $scheduleFrom,
                $scheduleTo,
                $houseBlock,
                $street,
                $subdivision,
                $barangay,
                $city_muntinlupa,
                $province,
                $zipCode,
                $profile
            );
            header("Location: ../src/employee/profile.php?updateVal=success&users_id=" . $users_id . "&tab=personal");
            exit();
        } catch (PDOException $e) {
            die("Query Failed: " . $e->getMessage());
        }
    }


    if (isset($_POST["familyEmployeeUpdate"]) && $_POST["familyEmployeeUpdate"] === "true") {
        $users_id = $_POST['users_id'] ?? null;

        $father_name = $_POST['father_name'] ?? '';
        $father_occupation = $_POST['father_occupation'] ?? '';
        $father_contact = $_POST['father_contact'] ?? '';
        $mother_name = $_POST['mother_name'] ?? '';
        $mother_occupation = $_POST['mother_occupation'] ?? '';
        $mother_contact = $_POST['mother_contact'] ?? '';
        $guardian_name = $_POST['guardian_name'] ?? '';
        $guardian_relationship = $_POST['guardian_relationship'] ?? '';
        $guardian_contact = $_POST['guardian_contact'] ?? '';

        $father_houseBlock = $_POST['father_houseBlock'] ?? '';
        $father_street = $_POST['father_street'] ?? '';
        $father_subdivision = $_POST['father_subdivision'] ?? '';
        $father_barangay = $_POST['father_barangay'] ?? '';
        $father_city_muntinlupa = $_POST['father_city_muntinlupa'] ?? '';
        $father_province = $_POST['father_province'] ?? '';
        $father_zip_code = $_POST['father_zip_code'] ?? '';

        $mother_houseBlock = $_POST['mother_houseBlock'] ?? '';
        $mother_street = $_POST['mother_street'] ?? '';
        $mother_subdivision = $_POST['mother_subdivision'] ?? '';
        $mother_barangay = $_POST['mother_barangay'] ?? '';
        $mother_city_muntinlupa = $_POST['mother_city_muntinlupa'] ?? '';
        $mother_province = $_POST['mother_province'] ?? '';
        $mother_zip_code = $_POST['mother_zip_code'] ?? '';

        $guardian_houseBlock = $_POST['guardian_houseBlock'] ?? '';
        $guardian_street = $_POST['guardian_street'] ?? '';
        $guardian_subdivision = $_POST['guardian_subdivision'] ?? '';
        $guardian_barangay = $_POST['guardian_barangay'] ?? '';
        $guardian_city_muntinlupa = $_POST['guardian_city_muntinlupa'] ?? '';
        $guardian_province = $_POST['guardian_province'] ?? '';
        $guardian_zip_code = $_POST['guardian_zip_code'] ?? '';

        if (!$users_id) {
            header("Location: ../src/employee/profile.php?upsert=failed&tab=family");
            exit;
        }

        try {
            $checkStmt = $pdo->prepare("SELECT id FROM family_information WHERE users_id = :users_id");
            $checkStmt->execute([':users_id' => $users_id]);
            $existingFamily = $checkStmt->fetch(PDO::FETCH_ASSOC);

            $params = [
                ':users_id' => $users_id,
                ':father_name' => $father_name,
                ':father_occupation' => $father_occupation,
                ':father_contact' => $father_contact,
                ':mother_name' => $mother_name,
                ':mother_occupation' => $mother_occupation,
                ':mother_contact' => $mother_contact,
                ':guardian_name' => $guardian_name,
                ':guardian_relationship' => $guardian_relationship,
                ':guardian_contact' => $guardian_contact
            ];

            if ($existingFamily) {
                $sqlFamily = "UPDATE family_information SET
                    father_name = :father_name,
                    father_occupation = :father_occupation,
                    father_contact = :father_contact,
                    mother_name = :mother_name,
                    mother_occupation = :mother_occupation,
                    mother_contact = :mother_contact,
                    guardian_name = :guardian_name,
                    guardian_relationship = :guardian_relationship,
                    guardian_contact = :guardian_contact
                    WHERE users_id = :users_id";

                $stmtFamily = $pdo->prepare($sqlFamily);
                $stmtFamily->execute($params);

                $sqlAddress = "UPDATE family_informationAddress SET
                    father_houseBlock = :father_houseBlock,
                    father_street = :father_street,
                    father_subdivision = :father_subdivision,
                    father_barangay = :father_barangay,
                    father_city_muntinlupa = :father_city_muntinlupa,
                    father_province = :father_province,
                    father_zip_code = :father_zip_code,
                    mother_houseBlock = :mother_houseBlock,
                    mother_street = :mother_street,
                    mother_subdivision = :mother_subdivision,
                    mother_barangay = :mother_barangay,
                    mother_city_muntinlupa = :mother_city_muntinlupa,
                    mother_province = :mother_province,
                    mother_zip_code = :mother_zip_code,
                    guardian_houseBlock = :guardian_houseBlock,
                    guardian_street = :guardian_street,
                    guardian_subdivision = :guardian_subdivision,
                    guardian_barangay = :guardian_barangay,
                    guardian_city_muntinlupa = :guardian_city_muntinlupa,
                    guardian_province = :guardian_province,
                    guardian_zip_code = :guardian_zip_code
                    WHERE users_id = :users_id";

                $stmtAddress = $pdo->prepare($sqlAddress);
                $stmtAddress->execute([
                    ':users_id' => $users_id,
                    ':father_houseBlock' => $father_houseBlock,
                    ':father_street' => $father_street,
                    ':father_subdivision' => $father_subdivision,
                    ':father_barangay' => $father_barangay,
                    ':father_city_muntinlupa' => $father_city_muntinlupa,
                    ':father_province' => $father_province,
                    ':father_zip_code' => $father_zip_code,
                    ':mother_houseBlock' => $mother_houseBlock,
                    ':mother_street' => $mother_street,
                    ':mother_subdivision' => $mother_subdivision,
                    ':mother_barangay' => $mother_barangay,
                    ':mother_city_muntinlupa' => $mother_city_muntinlupa,
                    ':mother_province' => $mother_province,
                    ':mother_zip_code' => $mother_zip_code,
                    ':guardian_houseBlock' => $guardian_houseBlock,
                    ':guardian_street' => $guardian_street,
                    ':guardian_subdivision' => $guardian_subdivision,
                    ':guardian_barangay' => $guardian_barangay,
                    ':guardian_city_muntinlupa' => $guardian_city_muntinlupa,
                    ':guardian_province' => $guardian_province,
                    ':guardian_zip_code' => $guardian_zip_code
                ]);
            } else {
                $sqlFamily = "INSERT INTO family_information (
                    users_id,
                    father_name, father_occupation, father_contact,
                    mother_name, mother_occupation, mother_contact,
                    guardian_name, guardian_relationship, guardian_contact
                ) VALUES (
                    :users_id,
                    :father_name, :father_occupation, :father_contact,
                    :mother_name, :mother_occupation, :mother_contact,
                    :guardian_name, :guardian_relationship, :guardian_contact
                )";

                $stmtFamily = $pdo->prepare($sqlFamily);
                $stmtFamily->execute($params);

                $sqlAddress = "INSERT INTO family_informationAddress (
                    users_id,
                    father_houseBlock, father_street, father_subdivision, father_barangay, father_city_muntinlupa, father_province, father_zip_code,
                    mother_houseBlock, mother_street, mother_subdivision, mother_barangay, mother_city_muntinlupa, mother_province, mother_zip_code,
                    guardian_houseBlock, guardian_street, guardian_subdivision, guardian_barangay, guardian_city_muntinlupa, guardian_province, guardian_zip_code
                ) VALUES (
                    :users_id,
                    :father_houseBlock, :father_street, :father_subdivision, :father_barangay, :father_city_muntinlupa, :father_province, :father_zip_code,
                    :mother_houseBlock, :mother_street, :mother_subdivision, :mother_barangay, :mother_city_muntinlupa, :mother_province, :mother_zip_code,
                    :guardian_houseBlock, :guardian_street, :guardian_subdivision, :guardian_barangay, :guardian_city_muntinlupa, :guardian_province, :guardian_zip_code
                )";

                $stmtAddress = $pdo->prepare($sqlAddress);
                $stmtAddress->execute([
                    ':users_id' => $users_id,
                    ':father_houseBlock' => $father_houseBlock,
                    ':father_street' => $father_street,
                    ':father_subdivision' => $father_subdivision,
                    ':father_barangay' => $father_barangay,
                    ':father_city_muntinlupa' => $father_city_muntinlupa,
                    ':father_province' => $father_province,
                    ':father_zip_code' => $father_zip_code,
                    ':mother_houseBlock' => $mother_houseBlock,
                    ':mother_street' => $mother_street,
                    ':mother_subdivision' => $mother_subdivision,
                    ':mother_barangay' => $mother_barangay,
                    ':mother_city_muntinlupa' => $mother_city_muntinlupa,
                    ':mother_province' => $mother_province,
                    ':mother_zip_code' => $mother_zip_code,
                    ':guardian_houseBlock' => $guardian_houseBlock,
                    ':guardian_street' => $guardian_street,
                    ':guardian_subdivision' => $guardian_subdivision,
                    ':guardian_barangay' => $guardian_barangay,
                    ':guardian_city_muntinlupa' => $guardian_city_muntinlupa,
                    ':guardian_province' => $guardian_province,
                    ':guardian_zip_code' => $guardian_zip_code
                ]);
            }

            header("Location: ../src/employee/profile.php?upsert=success&tab=family");
            exit;

        } catch (PDOException $e) {
            header("Location: ../src/employee/profile.php?upsert=failed&tab=family");
            exit;
        }
    }


    if (isset($_POST["educationalEmployeeUpdate"]) && $_POST["educationalEmployeeUpdate"] === "true") {
        $users_id = $_POST['users_id'] ?? null;

        $educations = [
            [
                'level' => 'elementary',
                'school_name' => $_POST['elementary_school'] ?? null,
                'course_or_strand' => null,
                'year_started' => $_POST['elementary_year_started'] ?? null,
                'year_ended' => $_POST['elementary_year_ended'] ?? null,
                'honors' => $_POST['elementary_honors'] ?? null
            ],
            [
                'level' => 'high_school',
                'school_name' => $_POST['high_school_school'] ?? null,
                'course_or_strand' => null,
                'year_started' => $_POST['high_school_year_started'] ?? null,
                'year_ended' => $_POST['high_school_year_ended'] ?? null,
                'honors' => $_POST['high_school_honors'] ?? null
            ],
            [
                'level' => 'senior_high',
                'school_name' => $_POST['senior_high_school'] ?? null,
                'course_or_strand' => $_POST['senior_high_course'] ?? null,
                'year_started' => $_POST['senior_high_year_started'] ?? null,
                'year_ended' => $_POST['senior_high_year_ended'] ?? null,
                'honors' => $_POST['senior_high_honors'] ?? null
            ],
            [
                'level' => 'college',
                'school_name' => $_POST['college_school'] ?? null,
                'course_or_strand' => $_POST['college_course'] ?? null,
                'year_started' => $_POST['college_year_started'] ?? null,
                'year_ended' => $_POST['college_year_ended'] ?? null,
                'honors' => $_POST['college_honors'] ?? null
            ],
            [
                'level' => 'graduate',
                'school_name' => $_POST['graduate_school'] ?? null,
                'course_or_strand' => $_POST['graduate_course'] ?? null,
                'year_started' => $_POST['graduate_year_started'] ?? null,
                'year_ended' => $_POST['graduate_year_ended'] ?? null,
                'honors' => $_POST['graduate_honors'] ?? null
            ]
        ];

        try {
            $pdo->beginTransaction();

            $deleteStmt = $pdo->prepare("DELETE FROM educational_background WHERE users_id = ?");
            $deleteStmt->execute([$users_id]);

            $insertSql = "
                INSERT INTO educational_background 
                (users_id, level, school_name, course_or_strand, year_started, year_ended, honors, created_at, updated_at)
                VALUES 
                (:users_id, :level, :school_name, :course_or_strand, :year_started, :year_ended, :honors, NOW(), NOW())
            ";
            $insertStmt = $pdo->prepare($insertSql);

            foreach ($educations as $edu) {
                if (empty($edu['school_name']))
                    continue;

                $year_started = !empty($edu['year_started']) ? $edu['year_started'] : null;
                $year_ended = !empty($edu['year_ended']) ? $edu['year_ended'] : null;

                $insertStmt->execute([
                    ':users_id' => $users_id,
                    ':level' => $edu['level'],
                    ':school_name' => $edu['school_name'],
                    ':course_or_strand' => $edu['course_or_strand'],
                    ':year_started' => $year_started,
                    ':year_ended' => $year_ended,
                    ':honors' => $edu['honors'],
                ]);
            }

            $pdo->commit();

            header("Location: ../src/employee/profile.php?upsert=success&users_id=" . $users_id . "&tab=educational");
            exit;
        } catch (PDOException $e) {
            $pdo->rollBack();
            header("Location: ../src/employee/profile.php?upsert=failed&users_id=" . $users_id . "&tab=educational");
            exit;
        }
    }

    // =============================== LEAVE AREA =============================== //
    if (isset($_POST["LeaveEmployee"]) && $_POST["LeaveEmployee"] === "true") {
        $users_id = $_SESSION["user_id"] ?? '';
        $dateLeave = $_POST["dateLeave"];
        $position = $_POST["position"];
        $department = $_POST["department"];
        $leaveType = $_POST["leaveType"];
        $others = $_POST["others"] ?? '';
        $purpose = $_POST["purpose"];
        $inclusiveDateFrom = $_POST["inclusiveDateFrom"];
        $inclusiveDateTo = $_POST["inclusiveDateTo"];
        $daysOfLeave = intval($_POST["daysOfLeave"]);
        $contact = $_POST["contact"];
        $sectionHead = $_POST["sectionHead"];
        $departmentHead = $_POST["departmentHead"];

        try {
            if (
                empty($dateLeave) || empty($position) || empty($department) ||
                empty($leaveType) || empty($purpose) || empty($inclusiveDateFrom) ||
                empty($inclusiveDateTo) || empty($daysOfLeave) || empty($contact) ||
                empty($sectionHead) || empty($departmentHead)
            ) {
                header("Location: ../src/employee/leave.php?empty=fields");
                die();
            }

            $q = "INSERT INTO leavereq (
                    users_id, leaveStatus, leaveType, leaveDate, Others, Purpose,
                    InclusiveFrom, InclusiveTo, numberOfDays, contact,
                    sectionHead, departmentHead
                )
                VALUES (
                    :users_id, 'pending', :leaveType, :leaveDate, :Others, :Purpose,
                    :InclusiveFrom, :InclusiveTo, :numberOfDays, :contact,
                    :sectionHead, :departmentHead
                )";
            $stmt = $pdo->prepare($q);
            $stmt->bindParam(":users_id", $users_id);
            $stmt->bindParam(":leaveType", $leaveType);
            $stmt->bindParam(":leaveDate", $dateLeave);
            $stmt->bindParam(":Others", $others);
            $stmt->bindParam(":Purpose", $purpose);
            $stmt->bindParam(":InclusiveFrom", $inclusiveDateFrom);
            $stmt->bindParam(":InclusiveTo", $inclusiveDateTo);
            $stmt->bindParam(":numberOfDays", $daysOfLeave);
            $stmt->bindParam(":contact", $contact);
            $stmt->bindParam(":sectionHead", $sectionHead);
            $stmt->bindParam(":departmentHead", $departmentHead);
            $stmt->execute();

            $leaveID = $pdo->lastInsertId();

            $q = "INSERT INTO reports (users_id, report_type, leave_id)
                VALUES (:users_id, 'PendingLeave', :leave_id)";
            $stmt = $pdo->prepare($q);
            $stmt->bindParam(":users_id", $users_id);
            $stmt->bindParam(":leave_id", $leaveID);
            $stmt->execute();

            header("Location: ../src/employee/leave.php?success=leave");
            $stmt = null;
            $pdo = null;
            die();
        } catch (PDOException $e) {
            die("Query Failed: " . $e->getMessage());
        }
    }

    if (isset($_POST['LeaveAdminApproval']) && $_POST['LeaveAdminApproval'] === 'true') {

        $users_id = $_POST['users_id'];
        $leave_id = $_POST['leave_id'];
        $reportID = $_POST['reportID'];
        $leaveType = $_POST['leaveType'];
        $disapprovalDetails = $_POST['disapprovalDetails'] ?? '';
        $numberOfDays = $_POST['numberOfDays'] ?? '';

        $vacationBalance = $_POST['vacationBalance'] ?? '';
        $vacationEarned = $_POST['vacationEarned'] ?? '';
        $vacationCredits = $_POST['vacationCredits'] ?? '';
        $vacationLessLeave = $_POST['vacationLessLeave'] ?? '';
        $vacationBalanceToDate = $_POST['vacationBalanceToDate'] ?? '';

        $sickBalance = $_POST['sickBalance'] ?? '';
        $sickEarned = $_POST['sickEarned'] ?? '';
        $sickCredits = $_POST['sickCredits'] ?? '';
        $sickLessLeave = $_POST['sickLessLeave'] ?? '';
        $sickBalanceToDate = $_POST['sickBalanceToDate'] ?? '';

        $specialBalance = $_POST['specialBalance'] ?? '';
        $specialEarned = $_POST['specialEarned'] ?? '';
        $specialCredits = $_POST['specialCredits'] ?? '';
        $specialLessLeave = $_POST['specialLessLeave'] ?? '';
        $specialBalanceToDate = $_POST['specialBalanceToDate'] ?? '';

        $leaveStatus = $_POST['leaveStatus'] ?? '';

        $balance = $vacationBalance !== '' ? $vacationBalance : ($sickBalance !== '' ? $sickBalance : $specialBalance);
        $earned = $vacationEarned !== '' ? $vacationEarned : ($sickEarned !== '' ? $sickEarned : $specialEarned);
        $credits = $vacationCredits !== '' ? $vacationCredits : ($sickCredits !== '' ? $sickCredits : $specialCredits);
        $lessLeave = $vacationLessLeave !== '' ? $vacationLessLeave : ($sickLessLeave !== '' ? $sickLessLeave : $specialLessLeave);
        $balanceToDate = $vacationBalanceToDate !== '' ? $vacationBalanceToDate : ($sickBalanceToDate !== '' ? $sickBalanceToDate : $specialBalanceToDate);

        try {
            $pdo->beginTransaction();
            // =========================== APPROVED LEAVE ======================== //
            if ($leaveStatus === 'approved') {
                $q = "UPDATE leavereq
                SET    leaveStatus = :leaveStatus
                WHERE  leave_id    = :leave_id";
                $st = $pdo->prepare($q);
                $st->bindParam(':leaveStatus', $leaveStatus);
                $st->bindParam(':leave_id', $leave_id, PDO::PARAM_INT);
                $st->execute();

                $q = "INSERT INTO leave_details
                    (leaveID, balance, earned, credits, lessLeave, balanceToDate, disapprovalDetails)
                VALUES
                    (:leaveID, :balance, :earned, :credits, :lessLeave, :balanceToDate, :disapprovalDetails)
                ON DUPLICATE KEY UPDATE
                    balance         = VALUES(balance),
                    earned          = VALUES(earned),
                    credits         = VALUES(credits),
                    lessLeave       = VALUES(lessLeave),
                    balanceToDate   = VALUES(balanceToDate),
                    disapprovalDetails = VALUES(disapprovalDetails)";
                $st = $pdo->prepare($q);
                $st->bindParam(':leaveID', $leave_id, PDO::PARAM_INT);
                $st->bindParam(':balance', $balance);
                $st->bindParam(':earned', $earned);
                $st->bindParam(':credits', $credits);
                $st->bindParam(':lessLeave', $lessLeave);
                $st->bindParam(':balanceToDate', $balanceToDate);
                $st->bindParam(':disapprovalDetails', $disapprovalDetails);
                $st->execute();

                // =========================== LEAVE BALANCE MOT ENOUGH ======================== //
                $finalBalance = intval($balance) - $numberOfDays;
                if (intval($balance) < $numberOfDays) {
                    header('Location: ../src/admin/employeeLeaveReq.php?leave=notEnoughBalance&users_id=' . $users_id . '&leave_id=' . $leave_id);
                    die();
                }

                // =========================== LEAVE COUNTS UPDATE ======================== //
                switch ($leaveType) {
                    case "vacation":
                        $query = "UPDATE leavecounts SET VacationBalance = :VacationBalance WHERE users_id = :users_id";
                        $stmt = $pdo->prepare($query);
                        $stmt->bindParam(":users_id", $users_id);
                        $stmt->bindParam(":VacationBalance", $finalBalance);
                        $stmt->execute();
                        break;
                    case "sick":
                        $query = "UPDATE leavecounts SET SickBalance = :SickBalance WHERE users_id = :users_id";
                        $stmt = $pdo->prepare($query);
                        $stmt->bindParam(":users_id", $users_id);
                        $stmt->bindParam(":SickBalance", $finalBalance);
                        $stmt->execute();
                        break;
                    case "balance":
                        $query = "UPDATE leavecounts SET SpecialBalance = :SpecialBalance WHERE users_id = :users_id";
                        $stmt = $pdo->prepare($query);
                        $stmt->bindParam(":users_id", $users_id);
                        $stmt->bindParam(":SpecialBalance", $finalBalance);
                        $stmt->execute();
                        break;
                    case "others":
                        $query = "UPDATE leavecounts SET OthersBalance = :OthersBalance WHERE users_id = :users_id";
                        $stmt = $pdo->prepare($query);
                        $stmt->bindParam(":users_id", $users_id);
                        $stmt->bindParam(":OthersBalance", $finalBalance);
                        $stmt->execute();
                        break;
                    default:
                        header('Location: ../src/admin/employeeLeaveReq.php?leave=failed&users_id=' . $users_id);
                        break;
                }

                // =========================== LEAVBE DETAILS UPDATE ======================== //
                $q = "UPDATE leave_details
                    SET  approved_at = NOW()
                    WHERE leaveID = :leaveID";
                $st = $pdo->prepare($q);
                $st->bindParam(':leaveID', $leave_id, PDO::PARAM_INT);
                $st->execute();

                // =========================== REPORT UPDATE ======================== //
                $q = "UPDATE reports
                    SET  report_type = 'approvedLeave'
                    WHERE leave_id   = :leave_id";
                $st = $pdo->prepare($q);
                $st->bindParam(':leave_id', $leave_id, PDO::PARAM_INT);
                $st->execute();

                $pdo->commit();

                // =========================== MAIL SENDER ======================== //
                $scriptPath = realpath(__DIR__ . "/emailSender.php");
                $command = "start /B php " .
                    escapeshellarg($scriptPath) . ' ' .
                    escapeshellarg($users_id) . ' ' .
                    escapeshellarg("LeaveApproved") . ' ' .
                    escapeshellarg('') . ' ' .
                    escapeshellarg('') . ' ' .
                    escapeshellarg('') . ' ' .
                    escapeshellarg('') . ' ' .
                    escapeshellarg('') . ' ' .
                    escapeshellarg('') . ' ' .
                    escapeshellarg($leave_id);

                pclose(popen($command, "r"));

                header(
                    'Location: ../src/admin/leave.php?leave=approved'
                    . '&users_id=' . $users_id
                    . '&leave_id=' . $leave_id
                    . '&open_pdf=1'
                );
                exit;
            }
            // =========================== LEAVE DISAPPROVED ======================== //
            if ($leaveStatus === 'disapprove') {
                $q = "UPDATE leavereq
                SET    leaveStatus = :leaveStatus
                WHERE  leave_id    = :leave_id";
                $st = $pdo->prepare($q);
                $st->bindParam(':leaveStatus', $leaveStatus);
                $st->bindParam(':leave_id', $leave_id, PDO::PARAM_INT);
                $st->execute();

                // =========================== LEAVE DETAILS ======================== //
                $q = "INSERT INTO leave_details
                    (leaveID, balance, earned, credits, lessLeave, balanceToDate, disapprovalDetails)
                VALUES
                    (:leaveID, :balance, :earned, :credits, :lessLeave, :balanceToDate, :disapprovalDetails)
                ON DUPLICATE KEY UPDATE
                    balance         = VALUES(balance),
                    earned          = VALUES(earned),
                    credits         = VALUES(credits),
                    lessLeave       = VALUES(lessLeave),
                    balanceToDate   = VALUES(balanceToDate),
                    disapprovalDetails = VALUES(disapprovalDetails)";
                $st = $pdo->prepare($q);
                $st->bindParam(':leaveID', $leave_id, PDO::PARAM_INT);
                $st->bindParam(':balance', $balance);
                $st->bindParam(':earned', $earned);
                $st->bindParam(':credits', $credits);
                $st->bindParam(':lessLeave', $lessLeave);
                $st->bindParam(':balanceToDate', $balanceToDate);
                $st->bindParam(':disapprovalDetails', $disapprovalDetails);
                $st->execute();

                // =========================== LEAVE DETAILS UPDATE ======================== //
                $q = "UPDATE leave_details
                    SET  disapproved_at = NOW()
                    WHERE leaveID = :leaveID
                        AND disapproved_at IS NULL";
                $st = $pdo->prepare($q);
                $st->bindParam(':leaveID', $leave_id, PDO::PARAM_INT);
                $st->execute();

                $q = "UPDATE reports
                    SET  report_type = 'disapprovedLeave'
                    WHERE leave_id   = :leave_id";
                $st = $pdo->prepare($q);
                $st->bindParam(':leave_id', $leave_id, PDO::PARAM_INT);
                $st->execute();

                $pdo->commit();

                // =========================== MAIL SENDER ======================== //
                $scriptPath = realpath(__DIR__ . "/emailSender.php");
                $command = "start /B php " .
                    escapeshellarg($scriptPath) . ' ' .
                    escapeshellarg($users_id) . ' ' .
                    escapeshellarg("LeaveDisapproved") . ' ' .
                    escapeshellarg('') . ' ' .
                    escapeshellarg('') . ' ' .
                    escapeshellarg('') . ' ' .
                    escapeshellarg('') . ' ' .
                    escapeshellarg('') . ' ' .
                    escapeshellarg('') . ' ' .
                    escapeshellarg($leave_id);

                pclose(popen($command, "r"));

                header(
                    'Location: ../src/admin/leave.php?leave=disapproved'
                    . '&users_id=' . $users_id
                    . '&leave_id=' . $leave_id
                    . '&open_pdf=1'
                );
                exit;
            }

            $pdo->rollBack();
            header('Location: ../src/admin/employeeLeaveReq.php?leave=failed&users_id=' . $users_id);
            exit;

        } catch (PDOException $e) {
            $pdo->rollBack();
            die('Query failed: ' . $e->getMessage());
        }
    }

    if (isset($_POST['deleteLeave']) && $_POST['deleteLeave'] === 'true') {
        $leaveId = (int) ($_POST['leave_id'] ?? 0);

        if ($leaveId) {
            $pdo = db_connection();
            $stmt = $pdo->prepare('DELETE FROM leavereq WHERE leave_id = :leave_id');
            $stmt->execute([':leave_id' => $leaveId]);
        }
        header("Location: ../src/admin/leave.php?leave=delete&leave_tab={$tab}");
        exit;
    }


    // ============================== FORGOT PASSWORD ============================== //
    if (isset($_POST["usersForgottenPass"]) && $_POST["usersForgottenPass"] === "true") {
        $usernameForgot = $_POST["usernameAuth"] ?? null;
        $AuthType = $_POST["AuthType"] ?? null;
        $mailCode = $_POST["mailCode"] ?? '';
        $new_password = $_POST["new_password"] ?? '';
        $confirm_password = $_POST["confirm_password"] ?? '';
        try {
            $query = "SELECT username FROM users WHERE username = :username";
            $stmt = $pdo->prepare($query);
            $stmt->execute(['username' => $usernameForgot]);
            $userForgot = $stmt->fetch(PDO::FETCH_ASSOC);
            // ===================== USERNAME NOT MATCH! ===================== //
            if (
                !$userForgot && $AuthType == '' && $mailCode == '' &&
                $new_password == '' && $confirm_password == ''
            ) {
                header("location: ../src/index.php?username=failed");
                die();
            }
            // ===================== USERNAME MATCHED! ===================== //
            else if ($userForgot) {
                $mailCode = substr(str_shuffle("qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM123456789"), 0, 6);
                $query = "SELECT id FROM users WHERE username = :username";
                $stmt = $pdo->prepare($query);
                $stmt->bindParam(":username", $usernameForgot);
                $stmt->execute();
                $hehe = $stmt->fetch(PDO::FETCH_ASSOC);
                $employeeId = $hehe['id'];
                $_SESSION["idNgEmployee"] = $hehe['id'];
                $scriptPath = realpath(__DIR__ . "/emailSender.php");
                $command = "start /B php " .
                    escapeshellarg($scriptPath) . ' ' .
                    escapeshellarg($employeeId) . ' ' .
                    escapeshellarg("ForgotEmployeePass") . ' ' .
                    escapeshellarg('') . ' ' .
                    escapeshellarg('') . ' ' .
                    escapeshellarg('') . ' ' .
                    escapeshellarg('') . ' ' .
                    escapeshellarg('') . ' ' .
                    escapeshellarg($mailCode) . "" .
                    escapeshellarg('');



                pclose(popen($command, "r"));

                $_SESSION["EmailAuth"] = $mailCode;

                header("Location: ../src/functions/changePass.php?username=success");
                die();
            }
            // ===================== CODE MAIL MATCHED! ===================== //
            elseif ($mailCode !== null && $mailCode == $_SESSION["EmailAuth"]) {
                echo "<pre>";
                print_r($_SESSION);
                echo "</pre>";
                echo $employeeId = $_SESSION["idNgEmployee"] ?? 'Wala   ';

                if ($new_password !== $confirm_password) {
                    header("Location: ../src/functions/changePass.php?password=notMatch");
                    die();
                }
                if (empty($new_password) || empty($confirm_password) && $userForgot) {
                    header("Location: ../src/functions/changePass.php?password=empty");
                    die();
                }
                $hasedPass = password_hash($new_password, PASSWORD_DEFAULT);
                $query = "UPDATE users SET password = :password WHERE id = :id";
                $stmt = $pdo->prepare($query);
                $stmt->bindParam(":id", $employeeId);
                $stmt->bindParam(":password", $hasedPass);
                $stmt->execute();
                echo $new_password;
                header("Location: ../src/index.php?passwordChange=success");
                die();
            }
            // ===================== USERNAME NOT MATCHED! ===================== //
            elseif ($mailCode !== null && $mailCode !== $_SESSION["EmailAuth"]) {
                header("Location: ../src/functions/changePass.php?code=notMatch");
                die();
            }
            // ===================== EMPTY INPUTS (IN CASE)! ===================== //
            else if (empty($usernameForgot) && empty($AuthType) && empty($new_password) && empty($confirm_password)) {
                header("Location: ../src/index.php?empty=input");
                die();
            }

        } catch (PDOException $e) {
            die("Query Failed: " . $e->getMessage());
        }

    }

    // ============================== PERSONAL DATA SHEET ============================== //
    if (isset($_POST['pds']) && $_POST['pds'] === "true") {
        $users_id = intval($_POST['users_id'] ?? 0);
        $pdsType = $_POST['pdsType'] ?? '';
        
        if ($users_id <= 0) {
            header("Location: ../error.php?message=Invalid+user+ID");
            exit;
        }

        try {
            $pdo->beginTransaction();

            // Get PDS ID
            $stmt = $pdo->prepare("SELECT pds_id FROM personal_data_sheet WHERE users_id = ?");
            $stmt->execute([$users_id]);
            $pds_id = $stmt->fetchColumn();

            if (!$pds_id) {
                throw new RuntimeException("No personal_data_sheet found for user ID: {$users_id}");
            }

            // Update user information
            $pdo->prepare(
                "UPDATE userInformations SET
                    lname = :ln,
                    fname = :fn,
                    mname = :mn,
                    nickname = :nn,
                    suffix = :sx,
                    citizenship = :ctz,
                    gender = :gen,
                    civil_status = :civ,
                    religion = :rel,
                    age = :age,
                    birthday = :bd,
                    birthPlace = :bp,
                    contact = :cnt,
                    email = :em
                WHERE users_id = :uid"
            )->execute([
                ':uid' => $users_id,
                ':ln' => $_POST['lname'] ?? null,
                ':fn' => $_POST['fname'] ?? null,
                ':mn' => $_POST['mname'] ?? null,
                ':nn' => $_POST['nickname'] ?? null,
                ':sx' => $_POST['suffix'] ?? null,
                ':ctz' => $_POST['citizenship'] ?? null,
                ':gen' => $_POST['gender'] ?? null,
                ':civ' => $_POST['civil_status'] ?? null,
                ':rel' => $_POST['religion'] ?? null,
                ':age' => $_POST['age'] ?? null,
                ':bd' => $_POST['birthday'] ?? null,
                ':bp' => $_POST['birthPlace'] ?? null,
                ':cnt' => $_POST['contact'] ?? null,
                ':em' => $_POST['email'] ?? null
            ]);

            // Update government IDs
            $pdo->prepare(
                "UPDATE userGovIDs SET
                    sss_no = ?,
                    tin_no = ?,
                    pagibig_no = ?,
                    philhealth_no = ?
                WHERE pds_id = ?"
            )->execute([
                $_POST['sss_no'] ?? null,
                $_POST['tin_no'] ?? null,
                $_POST['pagibig_no'] ?? null,
                $_POST['philhealth_no'] ?? null,
                $pds_id
            ]);

            // Update spouse information
            $pdo->prepare(
                "UPDATE spouseInfo SET
                    spouse_surname = :sur,
                    spouse_first = :fir,
                    spouse_middle = :mid,
                    spouse_occupation = :occ,
                    spouse_employer = :emp,
                    spouse_business_address = :addr,
                    spouse_tel = :tel
                WHERE pds_id = :pid"
            )->execute([
                ':pid' => $pds_id,
                ':sur' => $_POST['spouse_surname'] ?? null,
                ':fir' => $_POST['spouse_first'] ?? null,
                ':mid' => $_POST['spouse_middle'] ?? null,
                ':occ' => $_POST['spouse_occupation'] ?? null,
                ':emp' => $_POST['spouse_employer'] ?? null,
                ':addr' => $_POST['spouse_business_address'] ?? null,
                ':tel' => $_POST['spouse_tel'] ?? null
            ]);

            // Update parents information
            $parentStmt = $pdo->prepare(
                "UPDATE parents SET
                    surname = :sur,
                    first_name = :fir,
                    middle_name = :mid,
                    occupation = :occ,
                    address = :addr
                WHERE pds_id = :pid AND relation = :rel"
            );
            
            foreach (['father', 'mother'] as $rel) {
                $parentStmt->execute([
                    ':pid' => $pds_id,
                    ':rel' => $rel,
                    ':sur' => $_POST[strtolower($rel) . '_surname'] ?? null,
                    ':fir' => $_POST[strtolower($rel) . '_first'] ?? null,
                    ':mid' => $_POST[strtolower($rel) . '_middle'] ?? null,
                    ':occ' => $_POST[strtolower($rel) . '_occupation'] ?? null,
                    ':addr' => $_POST[strtolower($rel) . '_address'] ?? null
                ]);
            }

            // Update children information
            $childUpd = $pdo->prepare("UPDATE children SET full_name = ?, dob = ? WHERE id = ? AND pds_id = ?");
            $childIns = $pdo->prepare("INSERT INTO children (pds_id, full_name, dob) VALUES (?, ?, ?)");

            for ($i = 1; $i <= 7; $i++) {
                $cid = intval($_POST["child_id_$i"] ?? 0);
                $name = trim($_POST["child_name_$i"] ?? '');
                $dob = $_POST["child_dob_$i"] ?? null;

                if ($cid > 0) {
                    $childUpd->execute([$name !== '' ? $name : null, $dob, $cid, $pds_id]);
                } elseif ($name !== '') {
                    $childIns->execute([$pds_id, $name, $dob]);
                }
            }

            // Update siblings information
            $sibUpd = $pdo->prepare("
                UPDATE siblings SET
                    full_name = ?, age = ?, occupation = ?, address = ?
                WHERE id = ? AND pds_id = ?
            ");
            $sibIns = $pdo->prepare("
                INSERT INTO siblings (pds_id, full_name, age, occupation, address, birth_order)
                VALUES (?, ?, ?, ?, ?, ?)
            ");

            for ($i = 1; $i <= 8; $i++) {
                $sid = intval($_POST["sibling_id_$i"] ?? 0);
                $name = trim($_POST["sib_name_$i"] ?? '');
                $age = $_POST["sib_age_$i"] ?? null;
                $occ = $_POST["sib_occ_$i"] ?? null;
                $addr = $_POST["sib_addr_$i"] ?? null;

                if ($sid > 0) {
                    $sibUpd->execute([$name !== '' ? $name : null, $age, $occ, $addr, $sid, $pds_id]);
                } elseif ($name !== '') {
                    $sibIns->execute([$pds_id, $name, $age, $occ, $addr, $i]);
                }
            }

            // Update education information
            $updEdu = $pdo->prepare("
                UPDATE educationInfo
                SET school_name = :school,
                    degree_course = :course,
                    school_address = :addr,
                    year_grad = :yr
                WHERE id = :id AND pds_id = :pds
            ");
            $insEdu = $pdo->prepare("
                INSERT INTO educationInfo (pds_id, level, school_name, degree_course, school_address, year_grad)
                VALUES (:pds, :lvl, :school, :course, :addr, :yr)
            ");

            $levels = [
                'elem' => 'Elementary',
                'sec' => 'Secondary',
                'voc' => 'Vocational',
                'college' => 'College',
                'grad' => 'Graduate',
            ];

            foreach ($levels as $prefix => $level) {
                $id = intval($_POST["edu_{$prefix}_id"] ?? 0);
                $school = trim($_POST["{$prefix}_school"] ?? '');
                $course = trim($_POST["{$prefix}_course"] ?? '');
                $addr = trim($_POST["{$prefix}_address"] ?? '');
                $yr = trim($_POST["{$prefix}_year"] ?? '');

                if ($id === 0 && $school === '' && $course === '' && $addr === '' && $yr === '') {
                    continue;
                }

                if ($id > 0) {
                    $updEdu->execute([
                        ':school' => $school,
                        ':course' => $course,
                        ':addr' => $addr,
                        ':yr' => $yr !== '' ? $yr : null,
                        ':id' => $id,
                        ':pds' => $pds_id,
                    ]);
                } else {
                    $insEdu->execute([
                        ':pds' => $pds_id,
                        ':lvl' => $level,
                        ':school' => $school,
                        ':course' => $course,
                        ':addr' => $addr,
                        ':yr' => $yr !== '' ? $yr : null,
                    ]);
                }
            }

            // Update work experience
            $insWork = $pdo->prepare("
                INSERT INTO workExperience (pds_id, date_from, date_to, position_title, department, monthly_salary)
                VALUES (?, ?, ?, ?, ?, ?)
            ");
            $updWork = $pdo->prepare("
                UPDATE workExperience
                SET date_from = ?,
                    date_to = ?,
                    position_title = ?,
                    department = ?,
                    monthly_salary = ?
                WHERE id = ? AND pds_id = ?
            ");

            for ($i = 1; $i <= 5; $i++) {
                $id = (int) ($_POST["exp_{$i}_id"] ?? 0);
                $from = $_POST["exp_{$i}_from"] ?? '';
                $to = $_POST["exp_{$i}_to"] ?? '';
                $title = trim($_POST["exp_{$i}_position"] ?? '');
                $dept = trim($_POST["exp_{$i}_department"] ?? '');
                $salary = $_POST["exp_{$i}_salary"] ?? '';

                if ($id === 0 && $from === '' && $to === '' && $title === '' && $dept === '' && $salary === '') {
                    continue;
                }

                if ($id > 0) {
                    $updWork->execute([$from, $to, $title, $dept, $salary, $id, $pds_id]);
                } else {
                    $insWork->execute([$pds_id, $from, $to, $title, $dept, $salary]);
                }
            }

            // Update seminars and trainings
            $insSem = $pdo->prepare("
                INSERT INTO seminarsTrainings (pds_id, inclusive_dates, title, place)
                VALUES (?, ?, ?, ?)
            ");
            $updSem = $pdo->prepare("
                UPDATE seminarsTrainings
                SET inclusive_dates = ?,
                    title = ?,
                    place = ?
                WHERE id = ? AND pds_id = ?
            ");

            for ($i = 1; $i <= 5; $i++) {
                $id = intval($_POST["seminar_{$i}_id"] ?? 0);
                $dates = trim($_POST["seminar_{$i}_dates"] ?? '');
                $title = trim($_POST["seminar_{$i}_title"] ?? '');
                $place = trim($_POST["seminar_{$i}_place"] ?? '');

                if ($id === 0 && $dates === '' && $title === '' && $place === '') {
                    continue;
                }
                
                if ($id > 0) {
                    $updSem->execute([$dates ?: null, $title ?: null, $place ?: null, $id, $pds_id]);
                } else {
                    $insSem->execute([$pds_id, $dates ?: null, $title, $place ?: null]);
                }
            }

            // Update other information
            $status = $_POST['house_status'] ?? null;
            $type = $_POST['house_type'] ?? null;
            $rent = $_POST['rental_amount'] ?? null;

            $allowedTypes = ['light', 'semi_concrete', 'concrete'];
            if (!in_array($type, $allowedTypes, true)) {
                $type = null;
            }

            $rent = ($rent !== '' && $rent !== null) ? number_format((float) $rent, 2, '.', '') : null;

            $pdo->prepare(
                "UPDATE otherInfo SET
                    special_skills = :skills,
                    house_status = :status,
                    rental_amount = :rent,
                    house_type = :type,
                    household_members = :members,
                    height = :h,
                    weight = :w,
                    blood_type = :b,
                    emergency_contact = :emg,
                    tel_no = :tel
                WHERE pds_id = :pid"
            )->execute([
                ':pid' => $pds_id,
                ':skills' => $_POST['special_skills'] ?? null,
                ':status' => $status,
                ':rent' => $rent,
                ':type' => $type,
                ':members' => $_POST['household_members'] ?? null,
                ':h' => $_POST['height'] ?? null,
                ':w' => $_POST['weight'] ?? null,
                ':b' => $_POST['blood_type'] ?? null,
                ':emg' => $_POST['emergency_contact'] ?? null,
                ':tel' => $_POST['tel_no'] ?? null
            ]);

            $pdo->commit();

            // Redirect based on pdsType
            $redirectPaths = [
                'pending' => "../src/employee/pendingPDS.php?users_id={$users_id}&pending=pds",
                'validated' => "../src/employee/pds.php?users_id={$users_id}&employee=pds",
                'adminPds' => "../src/admin/pds.php?users_id={$users_id}"
            ];

            if (isset($redirectPaths[$pdsType])) {
                header("Location: " . $redirectPaths[$pdsType]);
                exit;
            } else {
                header("Location: ../error.php?message=Invalid+pdsType");
                exit;
            }

        } catch (Throwable $e) {
            $pdo->rollBack();
            header("Location: ../error.php?message=" . urlencode($e->getMessage()));
            exit;
        }
    }
    
    // ============================== CHANGE PASSWORD ============================== //
    if ((isset($_POST["changePassword"]) && $_POST["changePassword"] === "true") || (isset($_POST["changePasswordEmp"]) && $_POST["changePasswordEmp"] === "true")) {
        $currentPassword = $_POST["current_password"] ?? "";
        $newPassword     = $_POST["new_password"] ?? "";
        $confirmPassword = $_POST["confirm_password"] ?? "";
        $userId          = $_SESSION["user_id"] ?? '';
        $userRole        = $_SESSION["user_role"] ?? '';

        // Role-based redirect path
        $redirectPath = ($userRole === "administrator") ? "../src/admin/settings.php" : "../src/employee/settings.php";

        if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
            header("Location: $redirectPath?password=empty");
            exit;
        }

        if ($newPassword !== $confirmPassword) {
            header("Location: $redirectPath?password=newNotMatched");
            exit;
        }

        try {
            $stmt = $pdo->prepare("SELECT password FROM users WHERE id = :id");
            $stmt->execute(['id' => $userId]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$user) {
                header("Location: $redirectPath?password=userNotFound");
                exit;
            }

            if (!password_verify($currentPassword, $user['password'])) {
                header("Location: $redirectPath?password=currentNotMatched");
                exit;
            }

            $newHashed = password_hash($newPassword, PASSWORD_DEFAULT);

            $updateStmt = $pdo->prepare("UPDATE users SET password = :password WHERE id = :id");
            $updateSuccess = $updateStmt->execute([
                'password' => $newHashed,
                'id'       => $userId
            ]);

            if ($updateSuccess) {
                header("Location: $redirectPath?password=success");
                exit;
            } else {
                header("Location: $redirectPath?password=failed");
                exit;
            }

        } catch (PDOException $e) {
            header("Location: $redirectPath?password=failed");
            exit;
        }
    }

    unset($_SESSION['csrf_token']);
}
