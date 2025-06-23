<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
header('Content-Type: application/json');
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
    if (isset($_POST["loginAuth"]) && $_POST["loginAuth"] === "true") {
        $username = $_POST["username"] ?? '';
        $password = $_POST["password"] ?? '';
        $mailCode = $_POST["mailCode"] ?? '';
        $AdminMailCode = $_POST["AdminMailCode"] ?? '';

        $errors = [];

        // if ($mailCode == '' && $AdminMailCode == '' && empty($username) || empty($password)) {
        //     $errors["empty_inputs"] = "Fill all fields!";
        // }

        try {
            $user = getUsername($pdo, $username);

            if ($AuthType == '' && $mailCode == '' && $AdminMailCode == '' && !$user) {
                $errors["login_incorrect"] = "Incorrect username!";
            } elseif ($AuthType == '' && $mailCode == ''&& $AdminMailCode == '' && $mailCode == '' && !password_verify($password, $user["password"])) {
                $errors["login_incorrect"] = "Wrong password!";
            }

            $status = null;
            
            if ($user && $user["user_role"] === "employee") {
                $stmt = $pdo->prepare("SELECT status FROM userRequest WHERE users_id = ? ORDER BY request_date DESC LIMIT 1");
                $stmt->execute([$user['id']]);
                $request = $stmt->fetch(PDO::FETCH_ASSOC);
                
                if ($request) {
                    $status = $request['status'];
                    error_log("Student status found: $status for user ID: {$user['id']}");
                } else {
                    $status = 'pending';
                    error_log("No status record found for user ID: {$user['id']}, defaulting to pending");
                    
                }
            }

            if ($user && $user["user_role"] === "administrator") {
                $activeSession = checkActiveAdminSession($pdo, $user["id"]);
                if ($activeSession && $activeSession !== session_id()) {
                    $errors["login_incorrect"] = "Administrator is already logged in elsewhere!";
                }
            }

            if (!empty($errors)) {
                $_SESSION["errors_login"] = $errors;
                header("Location: ../src/index.php");
                exit();
            }

            session_regenerate_id(true);
            // if($AuthType == '' && $mailCode == $_SESSION["EmailAuth"]){
            
                if ($AuthType == '' && $mailCode == '' && $AdminMailCode == '' && $user["user_role"] === "administrator") {
                    updateUserSession($pdo, $user["id"], session_id());
                }

                if ($AuthType == '' && $mailCode == '' && $AdminMailCode == '' && $user["user_role"] === "employee") {
                        $_SESSION["user_id"] = $user["id"] ?? '';
                        $_SESSION["user_username"] = htmlspecialchars($user["username"]  ?? '');
                        $_SESSION["roles"] = $user["user_role"] ?? '';
                        $_SESSION["last_regeneration"] = time();
                    if ($status === "validated") {
                        $employeeId =  $user["id"] ?? 'WALANG ID';
                        $mailCode = substr(str_shuffle("qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM"), 0, 6);
                        $scriptPath = realpath(__DIR__ . "/emailSender.php"); 
                        $command = "start /B php " .
                            escapeshellarg($scriptPath) . ' ' .  //     1  
                            escapeshellarg($employeeId) . ' ' .      //     2  
                            escapeshellarg("MFA") . ' ' .     //   3    
                            escapeshellarg('') . ' ' .         //      4      
                            escapeshellarg('') . ' ' .            //  5       
                            escapeshellarg('') . ' ' .                 //     6
                            escapeshellarg('') . ' ' .                  // 7
                            escapeshellarg('') . ' ' .                          // 8 == 7
                            escapeshellarg($mailCode) . '"';
                            
                        file_put_contents("debug_command.log", "Command: $command\n", FILE_APPEND);
                        pclose(popen($command, "r"));

                        $_SESSION["EmailAuth"] = $mailCode;
                        header("Location: ../src/MFAauth.php");
                        die();
                    }else if($AuthType == '' && $mailCode == '' && $AdminMailCode == '' && $user["user_role"] === "employee" && $status === "rejected"){
                        header("Location: ../src/employee/rejected.php");
                        error_log("Redirecting employee to pending");
                    }
                    else {
                        header("Location: ../src/employee/pending.php");
                        error_log("Redirecting employee to pending");
                    }
                } 
                elseif ($AuthType == '' && $mailCode == '' && $AdminMailCode == '' && $user["user_role"] === "administrator") {
                    $mailCode = substr(str_shuffle("qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM"), 0, 6);
                    $employeeId =  1;
                    $scriptPath = realpath(__DIR__ . "/emailSender.php"); 
                    $command = "start /B php " .
                        escapeshellarg($scriptPath) . ' ' .  //     1  
                        escapeshellarg($employeeId) . ' ' .      //     2  
                        escapeshellarg("MFA") . ' ' .     //   3    
                        escapeshellarg('') . ' ' .         //      4      
                        escapeshellarg('') . ' ' .            //  5       
                        escapeshellarg('') . ' ' .                 //     6
                        escapeshellarg('') . ' ' .                  // 7
                        escapeshellarg('') . ' ' .                          // 8 == 7
                        escapeshellarg($mailCode) . '"';
                        
                    file_put_contents("debug_command.log", "Command: $command\n", FILE_APPEND);
                    pclose(popen($command, "r"));

                    $_SESSION["EmailAuth"] = $mailCode;
                    header("Location: ../src/adminMfaMailCode.php");
                    die();
                    header("Location: ../src/adminMfa.php");
                }
                elseif ($AuthType == '' && $username == '' && $AdminMailCode == '' && $password == '' && $mailCode == $_SESSION["EmailAuth"]){
                    header("Location: ../src/employee/dashboard.php");
                    die();
                }elseif ($AuthType == '' && $username == '' && $mailCode == '' && $password == '' && $AdminMailCode == $_SESSION["EmailAuth"]){
                    $adminID = 1;
                    $query = "INSERT INTO admin_history (admin_id, login_time) VALUES (?, NOW());";
                    $stmt = $pdo->prepare($query);
                    $stmt->execute([$adminID]); 
                    header("Location: ../src/admin/dashboard.php");
                    die();
                }elseif ($AuthType == '' && $AdminMailCode == '' && $username == '' && $password == '' && $mailCode !== $_SESSION["EmailAuth"]) {
                    header("Location: ../src/MFAauth.php?mfa=failed");
                    die();
                }elseif ($AuthType == '' && $mailCode == '' && $username == '' && $password == '' && $AdminMailCode !== $_SESSION["EmailAuth"]) {
                    header("Location: ../src/MFAauth.php?mfa=failed");
                    die();
                }
                else {
                    header("Location: ../src/index.php");
                    error_log("Redirecting to index (unknown role)");
                }
            // }
        } catch (PDOException $e) {
            error_log("Login error: " . $e->getMessage());
            session_start();
            $_SESSION["errors_login"] = ["login_incorrect" => "System error"];
            header("Location: ../src/index.php");
            exit();
        }
    }


    // ============================= User Registration Authentication ============================= //
    if(isset($_POST["register_user"]) && $_POST["register_user"] === "true") {
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
        $secheduleFrom = $_POST["secheduleFrom"];
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

            if(user_inputs($lname, $fname, $mname, $employeeID, $jobTitle, $slary_rate, 
            $citizenship, $gender, $civil_status, $birthday, $contact, $email, $secheduleFrom, $scheduleTo,
            $street, $barangay, $city_muntinlupa, $province, $zipCode, $username, $password, $confirmPassword)){
                $errors["empty_inputs"] = "Please fill out all fields!.";
            }

            if(invalid_email($email)){
            $errors["invalid_email"] = "your email is invalid!";
            }
            if(email_registered($pdo, $email)){
                $errors["email_registered"] = "your email is already registered!";
            }
            if(password_notMatch ($confirmPassword, $password)){
                $errors["password_notMatch"] = "Password not match!";
            }
            if(username_taken($pdo, $username)){
                $errors["username_taken"] = "Username Already Taken!";
            }
            if(password_secured($password)){
                $errors["password_secured"] = "password must be 8 characters above!";
            }
            if(password_security($password)){
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
                    "secheduleFrom" => $secheduleFrom,
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
                $employeeID,
                $department,
                $jobTitle,
                $slary_rate,
                $citizenship,
                $gender,
                $civil_status,
                $religion,
                $age,
                $birthday,
                $birthPlace,
                $contact,
                $email,
                $secheduleFrom,
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

            header("Location: ../src/index.php?signup=success");
    
            $stmt = null;
            $pdo = null;
    
            die();

        } catch (PDOException $e) {
            die("Query Failed: " . $e->getMessage());
        }
    }

    // ============================= Job Titles and salary Authentication ============================= //
    if(isset($_POST["addJob"]) && $_POST["addJob"] === "true") {
        $jobTitle = $_POST["jobTitle"];

        try {
            if($jobTitle){
                $errors = [];
                if(JobTitleExist($pdo, $jobTitle)){
                    $errors["JobExist"] = "Job Title Already Exist!";
                }
                if($errors){
                    header("Location: ../src/admin/job.php?Job=exist");
                    die();
                }else{
                    $query = "INSERT INTO jobTitles (jobTitle) VALUES (:jobTitle)";
                    $stmt = $pdo->prepare($query);
                    $stmt->bindParam(":jobTitle", $jobTitle);
                    $stmt->execute();

                    header("Location: ../src/admin/job.php?job=success");
                    $stmt=null;
                    $pdo=null;
                    die();
                }
                
            }else{
                echo "no input";
            }
        } catch (PDOException $e) {
            die("Query Failed: " . $e->getMessage());
        }
    }

    if(isset($_POST["deleteJobTitle"]) && $_POST["deleteJobTitle"] === "true") {
        $deleteJob = $_POST["deleteJob"];
        try{
            $query = "DELETE FROM jobtitles WHERE id = :id;";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":id", $deleteJob);
            $stmt->execute();

            header("Location: ../src/admin/job.php?deleteJob=success");
            $stmt=null;
            $pdo=null;
            die();
        }catch(PDOException $e){
            die("Query Failed: " . $getMessage());
        }
    }
    
    if(isset($_POST["EditJobTitle"]) && $_POST["EditJobTitle"] === "true"){
        $editJobId = $_POST["editJobId"];
        $editJobTitle = $_POST["editJobTitle"];

        try {
            $errors = [];
                if(JobTitleExist($pdo, $editJobTitle)){
                    $errors["JobExist"] = "Job Title Already Exist!";
                }
                if($errors){
                    header("Location: ../src/admin/job.php?Job=exist");
                    die();
                }
            $query = "UPDATE jobtitles SET jobTitle = :jobTitle WHERE id = :id";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":id", $editJobId);
            $stmt->bindParam(":jobTitle", $editJobTitle);
            $stmt->execute();

            header("Location: ../src/admin/job.php?JobTitleExdit=success");
            $stmt=null;
            $pdo=null;
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

        $query = "SELECT * FROM userinformations WHERE users_id = :users_id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":users_id", $users_id_job);
        $stmt->execute();
        $getJob = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($getJob) {
            $jobtitleRecent = $getJob["jobTitle"];
        }

        $query = "UPDATE userinformations SET jobTitle = :jobTitle, salary_Range_From = :salary_Range_From, salary_Range_To = :salary_Range_To, salary = :salary WHERE users_id = :users_id";
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

        $query = "UPDATE userinformations SET jobTitle = :jobTitle, salary_Range_From = :salary_Range_From, salary_Range_To = :salary_Range_To, salary = :salary WHERE users_id = :users_id";
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
    if (isset($_POST["changePassword"]) && $_POST["changePassword"] === "true"){
        $currentPassword = $_POST["current_password"] ?? "";
        $newPassword = $_POST["new_password"] ?? "";
        $confirmPassword = $_POST["confirm_password"] ?? "";

        if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
            echo json_encode(["status" => "error", "message" => "All fields are required."]);
            header("Location: ../src/admin/settings.php?password=empty");
            exit;
        }

        if ($newPassword !== $confirmPassword) {
            echo json_encode(["status" => "error", "message" => "New passwords do not match."]);
            header("Location: ../src/admin/settings.php?password=newNotMatched");
            exit;
        }

        try {
            $stmt = $pdo->prepare("SELECT password FROM users WHERE id = :id");
            $stmt->execute(['id' => 1]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$user) {
                echo json_encode(["status" => "error", "message" => "Admin user not found."]);
                exit;
            }

            if (!password_verify($currentPassword, $user['password'])) {
                echo json_encode(["status" => "error", "message" => "Current password is incorrect."]);
                header("Location: ../src/admin/settings.php?password=currentNotMatched");
                exit;
            }

            $newHashed = password_hash($newPassword, PASSWORD_DEFAULT);

            $updateStmt = $pdo->prepare("UPDATE users SET password = :password WHERE id = :id");
            $updateSuccess = $updateStmt->execute([
                'password' => $newHashed,
                'id' => 1
            ]);

            if ($updateSuccess) {
                echo json_encode(["status" => "success", "message" => "Password updated successfully."]);
                header("Location: ../src/admin/settings.php?password=success");
                exit;
            } else {
                echo json_encode(["status" => "error", "message" => "Failed to update password."]);
                header("Location: ../src/admin/settings.php?password=failed");
                exit;
            }

        } catch (PDOException $e) {
            echo json_encode(["status" => "error", "message" => "Database error: " . $e->getMessage()]);
            header("Location: ../src/admin/settings.php?password=failed");
            exit;
        }
    }
    
    if (isset($_POST["forgotPassword"]) && $_POST["forgotPassword"] === "true"){
       $usersnameAuth = $_POST["username"] ?? '';
       $mailCode = $_POST["mailCode"] ?? '';
       $new_password = $_POST["new_password"] ?? '';
       $confirm_password = $_POST["confirm_password"] ?? '';

       // =============== SEND TO EMAIL ====================== //

        try{
            $query = "SELECT username FROM users WHERE id = 1";
            $stmt = $pdo->prepare($query);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            $getUsername = $user["username"];

          

            if($usersnameAuth !== null && $usersnameAuth === $getUsername){
                $emailAuth = substr(str_shuffle("qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM123456789"), 0, 6);
                $employeeId = 1;
                $scriptPath = realpath(__DIR__ . "/emailSender.php"); 
                $command = "start /B php " .
                    escapeshellarg($scriptPath) . ' ' .  //     1  
                    escapeshellarg($employeeId) . ' ' .      //     2  
                    escapeshellarg("password") . ' ' .     //   3    
                    escapeshellarg('') . ' ' .         //      4      
                    escapeshellarg('') . ' ' .            //  5       
                    escapeshellarg('') . ' ' .                 //     6
                    escapeshellarg('') . ' ' .                  // 7
                    escapeshellarg('') . ' ' .                          // 8 == 7
                    escapeshellarg($emailAuth) . '"';                         // 7 == 8
                    // TAng ina yung mail lang pala maliiiiii!!!!!!!!!!
                file_put_contents("debug_command.log", "Command: $command\n", FILE_APPEND);
                pclose(popen($command, "r"));
                $_SESSION["EmailAuth"] = $emailAuth;
                header("Location: ../src/admin/changePass.php?username=success");
                die();
            }else if($usersnameAuth !== '' && $usersnameAuth !== $getUsername){
                header("Location: ../src/admin/settings.php?passwordAuthFailes=failed");
                die();
            }else if($usersnameAuth !== ''){
                 header("Location: ../src/admin/settings.php?passwordAuth=null");
                die();
            }elseif ($mailCode !== null && $mailCode == $_SESSION["EmailAuth"]) {
                if($new_password !== $confirm_password){
                    header("Location: ../src/admin/changePass.php?password=notMatch");
                    die();
                }
                if(empty($new_password) || empty($confirm_password)){
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
            }elseif ($mailCode !== null && $mailCode !== $_SESSION["EmailAuth"]) {
                header("Location: ../src/admin/changePass.php?code=notMatch");
                die();
            }
        }catch(PDOException $e){
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

            $scriptPath = realpath(__DIR__ . "/emailSender.php"); 
            $command = "start /B php " .
                escapeshellarg($scriptPath) . ' ' .  //     1  
                escapeshellarg($employeeId) . ' ' .      //     2  
                escapeshellarg("accepted") . ' ' .     //   3    
                escapeshellarg('') . ' ' .         //      4      
                escapeshellarg('') . ' ' .            //  5       
                escapeshellarg('') . ' ' .                 //     6
                escapeshellarg('') . ' ' .                  // 7
                escapeshellarg('') . ' ' .                  // 8
                escapeshellarg('') ;                         // 9 == 8

            pclose(popen($command, "r"));

            header("Location: ../src/admin/employee.php?acceptEmployee=success&tab=accept");
            $stmt = null;
            $pdo = null;
            die();
        } catch (PDOException $e) {
            die("Query Failed: " . $e->getMessage());
        }
    }


    if(isset($_POST["rejectEmployee"]) && $_POST["rejectEmployee"] === "true"){
        $employeeId = $_POST["employeeId"];
        try{
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
                escapeshellarg('') ;                       

            pclose(popen($command, "r"));

            header("Location: ../src/admin/employee.php?rejectEmployee=success&tab=request");
            $stmt=null;
            $pdo=null;
            die();
        }catch(PDOException $e){
            die("Query Failed: " . $e->getMessage());
        }
    }

    if(isset($_POST["deleteValidatedEmployee"]) && $_POST["deleteValidatedEmployee"] === "true"){
        $delete_user_id = $_POST["delete_user_id"];
        try {
            $query = "DELETE FROM users WHERE id = :id";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":id", $delete_user_id);
            $stmt->execute();
            header("Location: ../src/admin/employee.php?deleteValidatedEmployee=success&tab=delete");
            $stmt=null;
            $pdo=null;
            die();
        } catch (PDOException $e) {
            die("Query Failed: " . $e->getMessage());
        }
    }

    // ============================= PROFILING Authentication ============================= //
    if (isset($_POST["requestUpdate"]) && $_POST["requestUpdate"] === "true") {
        $users_id = (int)$_POST["users_id"];
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
        $users_id = (int)$_POST["users_id"];
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
                if (empty($edu['school_name'])) continue;

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
        $father_houseBlock = $_POST['father_houseBlock'] ?? '';
        $father_street = $_POST['father_street'] ?? '';
        $father_subdivision = $_POST['father_subdivision'] ?? '';
        $father_barangay = $_POST['father_barangay'] ?? '';
        $father_city_muntinlupa = $_POST['father_city_muntinlupa'] ?? '';
        $father_province = $_POST['father_province'] ?? '';
        $father_zip_code = $_POST['father_zip_code'] ?? '';

        $mother_name = $_POST['mother_name'] ?? '';
        $mother_occupation = $_POST['mother_occupation'] ?? '';
        $mother_contact = $_POST['mother_contact'] ?? '';
        $mother_houseBlock = $_POST['mother_houseBlock'] ?? '';
        $mother_street = $_POST['mother_street'] ?? '';
        $mother_subdivision = $_POST['mother_subdivision'] ?? '';
        $mother_barangay = $_POST['mother_barangay'] ?? '';
        $mother_city_muntinlupa = $_POST['mother_city_muntinlupa'] ?? '';
        $mother_province = $_POST['mother_province'] ?? '';
        $mother_zip_code = $_POST['mother_zip_code'] ?? '';

        $guardian_name = $_POST['guardian_name'] ?? '';
        $guardian_relationship = $_POST['guardian_relationship'] ?? '';
        $guardian_contact = $_POST['guardian_contact'] ?? '';
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

            if ($existingFamily) {
                $sql = "UPDATE family_information SET
                    father_name = :father_name,
                    father_occupation = :father_occupation,
                    father_contact = :father_contact,
                    father_houseBlock = :father_houseBlock,
                    father_street = :father_street,
                    father_subdivision = :father_subdivision,
                    father_barangay = :father_barangay,
                    father_city_muntinlupa = :father_city_muntinlupa,
                    father_province = :father_province,
                    father_zip_code = :father_zip_code,
                    
                    mother_name = :mother_name,
                    mother_occupation = :mother_occupation,
                    mother_contact = :mother_contact,
                    mother_houseBlock = :mother_houseBlock,
                    mother_street = :mother_street,
                    mother_subdivision = :mother_subdivision,
                    mother_barangay = :mother_barangay,
                    mother_city_muntinlupa = :mother_city_muntinlupa,
                    mother_province = :mother_province,
                    mother_zip_code = :mother_zip_code,
                    
                    guardian_name = :guardian_name,
                    guardian_relationship = :guardian_relationship,
                    guardian_contact = :guardian_contact,
                    guardian_houseBlock = :guardian_houseBlock,
                    guardian_street = :guardian_street,
                    guardian_subdivision = :guardian_subdivision,
                    guardian_barangay = :guardian_barangay,
                    guardian_city_muntinlupa = :guardian_city_muntinlupa,
                    guardian_province = :guardian_province,
                    guardian_zip_code = :guardian_zip_code
                    WHERE id = :id
                ";

                $stmt = $pdo->prepare($sql);
                $params = [
                    ':id' => $existingFamily['id'],
                    ':father_name' => $father_name,
                    ':father_occupation' => $father_occupation,
                    ':father_contact' => $father_contact,
                    ':father_houseBlock' => $father_houseBlock,
                    ':father_street' => $father_street,
                    ':father_subdivision' => $father_subdivision,
                    ':father_barangay' => $father_barangay,
                    ':father_city_muntinlupa' => $father_city_muntinlupa,
                    ':father_province' => $father_province,
                    ':father_zip_code' => $father_zip_code,
                    
                    ':mother_name' => $mother_name,
                    ':mother_occupation' => $mother_occupation,
                    ':mother_contact' => $mother_contact,
                    ':mother_houseBlock' => $mother_houseBlock,
                    ':mother_street' => $mother_street,
                    ':mother_subdivision' => $mother_subdivision,
                    ':mother_barangay' => $mother_barangay,
                    ':mother_city_muntinlupa' => $mother_city_muntinlupa,
                    ':mother_province' => $mother_province,
                    ':mother_zip_code' => $mother_zip_code,
                    
                    ':guardian_name' => $guardian_name,
                    ':guardian_relationship' => $guardian_relationship,
                    ':guardian_contact' => $guardian_contact,
                    ':guardian_houseBlock' => $guardian_houseBlock,
                    ':guardian_street' => $guardian_street,
                    ':guardian_subdivision' => $guardian_subdivision,
                    ':guardian_barangay' => $guardian_barangay,
                    ':guardian_city_muntinlupa' => $guardian_city_muntinlupa,
                    ':guardian_province' => $guardian_province,
                    ':guardian_zip_code' => $guardian_zip_code,
                ];
                $stmt->execute($params);

            } else {
                // INSERT new record
                $sql = "INSERT INTO family_information (
                    users_id,
                    father_name, father_occupation, father_contact,
                    father_houseBlock, father_street, father_subdivision, father_barangay, father_city_muntinlupa, father_province, father_zip_code,
                    
                    mother_name, mother_occupation, mother_contact,
                    mother_houseBlock, mother_street, mother_subdivision, mother_barangay, mother_city_muntinlupa, mother_province, mother_zip_code,
                    
                    guardian_name, guardian_relationship, guardian_contact,
                    guardian_houseBlock, guardian_street, guardian_subdivision, guardian_barangay, guardian_city_muntinlupa, guardian_province, guardian_zip_code
                ) VALUES (
                    :users_id,
                    :father_name, :father_occupation, :father_contact,
                    :father_houseBlock, :father_street, :father_subdivision, :father_barangay, :father_city_muntinlupa, :father_province, :father_zip_code,
                    
                    :mother_name, :mother_occupation, :mother_contact,
                    :mother_houseBlock, :mother_street, :mother_subdivision, :mother_barangay, :mother_city_muntinlupa, :mother_province, :mother_zip_code,
                    
                    :guardian_name, :guardian_relationship, :guardian_contact,
                    :guardian_houseBlock, :guardian_street, :guardian_subdivision, :guardian_barangay, :guardian_city_muntinlupa, :guardian_province, :guardian_zip_code
                )";

                $stmt = $pdo->prepare($sql);
                $params = [
                    ':users_id' => $users_id,
                    ':father_name' => $father_name,
                    ':father_occupation' => $father_occupation,
                    ':father_contact' => $father_contact,
                    ':father_houseBlock' => $father_houseBlock,
                    ':father_street' => $father_street,
                    ':father_subdivision' => $father_subdivision,
                    ':father_barangay' => $father_barangay,
                    ':father_city_muntinlupa' => $father_city_muntinlupa,
                    ':father_province' => $father_province,
                    ':father_zip_code' => $father_zip_code,
                    
                    ':mother_name' => $mother_name,
                    ':mother_occupation' => $mother_occupation,
                    ':mother_contact' => $mother_contact,
                    ':mother_houseBlock' => $mother_houseBlock,
                    ':mother_street' => $mother_street,
                    ':mother_subdivision' => $mother_subdivision,
                    ':mother_barangay' => $mother_barangay,
                    ':mother_city_muntinlupa' => $mother_city_muntinlupa,
                    ':mother_province' => $mother_province,
                    ':mother_zip_code' => $mother_zip_code,
                    
                    ':guardian_name' => $guardian_name,
                    ':guardian_relationship' => $guardian_relationship,
                    ':guardian_contact' => $guardian_contact,
                    ':guardian_houseBlock' => $guardian_houseBlock,
                    ':guardian_street' => $guardian_street,
                    ':guardian_subdivision' => $guardian_subdivision,
                    ':guardian_barangay' => $guardian_barangay,
                    ':guardian_city_muntinlupa' => $guardian_city_muntinlupa,
                    ':guardian_province' => $guardian_province,
                    ':guardian_zip_code' => $guardian_zip_code,
                ];
                $stmt->execute($params);
            }

            header("Location: ../src/admin/profile.php?upsert=success&tab=family&users_id=" . $users_id);
            exit;

        } catch (PDOException $e) {
            header("Location: ../src/admin/profile.php?upsert=failed&tab=family");
            exit;
        }
    }

    if(isset($_POST["add_employee"]) && $_POST["add_employee"] === "true") {
        $lname = $_POST["lname"];
        $fname = $_POST["fname"];
        $mname = $_POST["mname"];
        $employeeID = $_POST["employeeID"];
        $department = $_POST["department"];
        $jobTitle = $_POST["jobTitle"];
        $slary_rate = $_POST["slary_rate"];
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
        $secheduleFrom = $_POST["secheduleFrom"];
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
                // No image uploaded; copy default image
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

            if(user_inputs($lname, $fname, $mname, $employeeID, $jobTitle, $slary_rate, $salary_Range_From, $salary_Range_To, $salary,
            $citizenship, $gender, $civil_status, $birthday, $contact, $email, $secheduleFrom, $scheduleTo,
            $street, $barangay, $city_muntinlupa, $province, $zipCode, $username, $password, $confirmPassword)){
                $errors["empty_inputs"] = "Please fill out all fields!.";
            }

            if(invalid_email($email)){
            $errors["invalid_email"] = "your email is invalid!";
            }
            if(email_registered($pdo, $email)){
                $errors["email_registered"] = "your email is already registered!";
            }
            if(password_notMatch ($confirmPassword, $password)){
                $errors["password_notMatch"] = "Password not match!";
            }
            if(username_taken($pdo, $username)){
                $errors["username_taken"] = "Username Already Taken!";
            }
            if(password_secured($password)){
                $errors["password_secured"] = "password must be 8 characters above!";
            }
            if(password_security($password)){
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
                    "secheduleFrom" => $secheduleFrom,
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
                $employeeID,
                $department,
                $jobTitle,
                $slary_rate,
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
                $secheduleFrom,
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
            escapeshellarg($password) ;       


            file_put_contents("debug_command.log", "Command: $command\n", FILE_APPEND);
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
    if(isset($_POST["userUpdateProfile"]) && $_POST["userUpdateProfile"] === "true") {
        $users_id = (int)$_POST["users_id"];
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
        $father_houseBlock = $_POST['father_houseBlock'] ?? '';
        $father_street = $_POST['father_street'] ?? '';
        $father_subdivision = $_POST['father_subdivision'] ?? '';
        $father_barangay = $_POST['father_barangay'] ?? '';
        $father_city_muntinlupa = $_POST['father_city_muntinlupa'] ?? '';
        $father_province = $_POST['father_province'] ?? '';
        $father_zip_code = $_POST['father_zip_code'] ?? '';

        $mother_name = $_POST['mother_name'] ?? '';
        $mother_occupation = $_POST['mother_occupation'] ?? '';
        $mother_contact = $_POST['mother_contact'] ?? '';
        $mother_houseBlock = $_POST['mother_houseBlock'] ?? '';
        $mother_street = $_POST['mother_street'] ?? '';
        $mother_subdivision = $_POST['mother_subdivision'] ?? '';
        $mother_barangay = $_POST['mother_barangay'] ?? '';
        $mother_city_muntinlupa = $_POST['mother_city_muntinlupa'] ?? '';
        $mother_province = $_POST['mother_province'] ?? '';
        $mother_zip_code = $_POST['mother_zip_code'] ?? '';

        $guardian_name = $_POST['guardian_name'] ?? '';
        $guardian_relationship = $_POST['guardian_relationship'] ?? '';
        $guardian_contact = $_POST['guardian_contact'] ?? '';
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

            if ($existingFamily) {
                $sql = "UPDATE family_information SET
                    father_name = :father_name,
                    father_occupation = :father_occupation,
                    father_contact = :father_contact,
                    father_houseBlock = :father_houseBlock,
                    father_street = :father_street,
                    father_subdivision = :father_subdivision,
                    father_barangay = :father_barangay,
                    father_city_muntinlupa = :father_city_muntinlupa,
                    father_province = :father_province,
                    father_zip_code = :father_zip_code,
                    
                    mother_name = :mother_name,
                    mother_occupation = :mother_occupation,
                    mother_contact = :mother_contact,
                    mother_houseBlock = :mother_houseBlock,
                    mother_street = :mother_street,
                    mother_subdivision = :mother_subdivision,
                    mother_barangay = :mother_barangay,
                    mother_city_muntinlupa = :mother_city_muntinlupa,
                    mother_province = :mother_province,
                    mother_zip_code = :mother_zip_code,
                    
                    guardian_name = :guardian_name,
                    guardian_relationship = :guardian_relationship,
                    guardian_contact = :guardian_contact,
                    guardian_houseBlock = :guardian_houseBlock,
                    guardian_street = :guardian_street,
                    guardian_subdivision = :guardian_subdivision,
                    guardian_barangay = :guardian_barangay,
                    guardian_city_muntinlupa = :guardian_city_muntinlupa,
                    guardian_province = :guardian_province,
                    guardian_zip_code = :guardian_zip_code
                    WHERE id = :id
                ";

                $stmt = $pdo->prepare($sql);
                $params = [
                    ':id' => $existingFamily['id'],
                    ':father_name' => $father_name,
                    ':father_occupation' => $father_occupation,
                    ':father_contact' => $father_contact,
                    ':father_houseBlock' => $father_houseBlock,
                    ':father_street' => $father_street,
                    ':father_subdivision' => $father_subdivision,
                    ':father_barangay' => $father_barangay,
                    ':father_city_muntinlupa' => $father_city_muntinlupa,
                    ':father_province' => $father_province,
                    ':father_zip_code' => $father_zip_code,
                    
                    ':mother_name' => $mother_name,
                    ':mother_occupation' => $mother_occupation,
                    ':mother_contact' => $mother_contact,
                    ':mother_houseBlock' => $mother_houseBlock,
                    ':mother_street' => $mother_street,
                    ':mother_subdivision' => $mother_subdivision,
                    ':mother_barangay' => $mother_barangay,
                    ':mother_city_muntinlupa' => $mother_city_muntinlupa,
                    ':mother_province' => $mother_province,
                    ':mother_zip_code' => $mother_zip_code,
                    
                    ':guardian_name' => $guardian_name,
                    ':guardian_relationship' => $guardian_relationship,
                    ':guardian_contact' => $guardian_contact,
                    ':guardian_houseBlock' => $guardian_houseBlock,
                    ':guardian_street' => $guardian_street,
                    ':guardian_subdivision' => $guardian_subdivision,
                    ':guardian_barangay' => $guardian_barangay,
                    ':guardian_city_muntinlupa' => $guardian_city_muntinlupa,
                    ':guardian_province' => $guardian_province,
                    ':guardian_zip_code' => $guardian_zip_code,
                ];
                $stmt->execute($params);

            } else {
                // INSERT new record
                $sql = "INSERT INTO family_information (
                    users_id,
                    father_name, father_occupation, father_contact,
                    father_houseBlock, father_street, father_subdivision, father_barangay, father_city_muntinlupa, father_province, father_zip_code,
                    
                    mother_name, mother_occupation, mother_contact,
                    mother_houseBlock, mother_street, mother_subdivision, mother_barangay, mother_city_muntinlupa, mother_province, mother_zip_code,
                    
                    guardian_name, guardian_relationship, guardian_contact,
                    guardian_houseBlock, guardian_street, guardian_subdivision, guardian_barangay, guardian_city_muntinlupa, guardian_province, guardian_zip_code
                ) VALUES (
                    :users_id,
                    :father_name, :father_occupation, :father_contact,
                    :father_houseBlock, :father_street, :father_subdivision, :father_barangay, :father_city_muntinlupa, :father_province, :father_zip_code,
                    
                    :mother_name, :mother_occupation, :mother_contact,
                    :mother_houseBlock, :mother_street, :mother_subdivision, :mother_barangay, :mother_city_muntinlupa, :mother_province, :mother_zip_code,
                    
                    :guardian_name, :guardian_relationship, :guardian_contact,
                    :guardian_houseBlock, :guardian_street, :guardian_subdivision, :guardian_barangay, :guardian_city_muntinlupa, :guardian_province, :guardian_zip_code
                )";

                $stmt = $pdo->prepare($sql);
                $params = [
                    ':users_id' => $users_id,
                    ':father_name' => $father_name,
                    ':father_occupation' => $father_occupation,
                    ':father_contact' => $father_contact,
                    ':father_houseBlock' => $father_houseBlock,
                    ':father_street' => $father_street,
                    ':father_subdivision' => $father_subdivision,
                    ':father_barangay' => $father_barangay,
                    ':father_city_muntinlupa' => $father_city_muntinlupa,
                    ':father_province' => $father_province,
                    ':father_zip_code' => $father_zip_code,
                    
                    ':mother_name' => $mother_name,
                    ':mother_occupation' => $mother_occupation,
                    ':mother_contact' => $mother_contact,
                    ':mother_houseBlock' => $mother_houseBlock,
                    ':mother_street' => $mother_street,
                    ':mother_subdivision' => $mother_subdivision,
                    ':mother_barangay' => $mother_barangay,
                    ':mother_city_muntinlupa' => $mother_city_muntinlupa,
                    ':mother_province' => $mother_province,
                    ':mother_zip_code' => $mother_zip_code,
                    
                    ':guardian_name' => $guardian_name,
                    ':guardian_relationship' => $guardian_relationship,
                    ':guardian_contact' => $guardian_contact,
                    ':guardian_houseBlock' => $guardian_houseBlock,
                    ':guardian_street' => $guardian_street,
                    ':guardian_subdivision' => $guardian_subdivision,
                    ':guardian_barangay' => $guardian_barangay,
                    ':guardian_city_muntinlupa' => $guardian_city_muntinlupa,
                    ':guardian_province' => $guardian_province,
                    ':guardian_zip_code' => $guardian_zip_code,
                ];
                $stmt->execute($params);
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
                if (empty($edu['school_name'])) continue;

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

    // ============================== FORGOT PASSWORD ============================== //
    if (isset($_POST["usersForgottenPass"]) && $_POST["usersForgottenPass"] === "true"){
        $usernameForgot = $_POST["usernameAuth"] ?? null;
        $AuthType = $_POST["AuthType"] ?? null;
        $mailCode = $_POST["mailCode"] ?? '';
        $new_password = $_POST["new_password"] ?? '';
        $confirm_password = $_POST["confirm_password"] ?? '';
        try{
            $query = "SELECT username FROM users WHERE username = :username";
            $stmt = $pdo->prepare($query);
            $stmt->execute(['username' => $usernameForgot]);
            $userForgot = $stmt->fetch(PDO::FETCH_ASSOC);
            // ===================== USERNAME NOT MATCH! ===================== //
            if (!$userForgot && $AuthType == '' && $mailCode == '' &&
            $new_password == '' && $confirm_password == '') {
                header("location: ../src/index.php?username=failed");
                die();
            }
             // ===================== USERNAME MATCHED! ===================== //
            else if($userForgot){
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
                    escapeshellarg($mailCode) . '"';

                file_put_contents("debug_command.log", "Command: $command\n", FILE_APPEND);
                pclose(popen($command, "r"));

                $_SESSION["EmailAuth"] = $mailCode;

                header("Location: ../src/changePass.php?username=success");
                die();
            }
            // ===================== CODE MAIL MATCHED! ===================== //
            elseif ($mailCode !== null && $mailCode == $_SESSION["EmailAuth"]){
                echo "<pre>";
                print_r($_SESSION);
                echo "</pre>";
                echo $employeeId = $_SESSION["user_id"] ?? 'Wala   ';

                if($new_password !== $confirm_password){
                    header("Location: ../src/changePass.php?password=notMatch");
                    die();
                }
                if(empty($new_password) || empty($confirm_password) && $userForgot){
                     header("Location: ../src/changePass.php?password=empty");
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
                header("Location: ../src/changePass.php?code=notMatch");
                die();
            }
            // ===================== EMPTY INPUTS (IN CASE)! ===================== //
            else if(empty($usernameForgot) && empty($AuthType) && empty($new_password) && empty($confirm_password)){
                header("Location: ../src/index.php?empty=input");
                die();
            }

        }catch(PDOException $e){
            die("Query Failed: " . $e->getMessage());
        }
        
    }

    unset($_SESSION['csrf_token']);
}
