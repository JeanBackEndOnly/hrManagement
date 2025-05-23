<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


require_once '../installer/session.php';
 if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    header("Location:../invalid.php");
    die();
}
header('Content-Type: application/json');

require_once '../installer/session.php';
require_once 'functions.php';
require_once 'model.php';

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $pdo = db_connect();
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        header("Location:../invalid.php");
        die();
    }
    // =============================== REGISTER ===================================== //
    
    if(isset($_POST["addeemployee"]) && $_POST["addeemployee"] == "admin"){
        isset($_GET["id"]) ? $id = $_GET["id"] : null;
        $employeeID = $_POST["employeeID"];
        $department = $_POST["department"];
        $rateType = $_POST["rateType"]; 
        $salary_Range_From = intval($_POST["salary_Range_From"]);
        $salary_Range_To = intval($_POST["salary_Range_To"]); 
        $schedule_from = isset($_POST['schedule_from']) ? $_POST['schedule_from'] : '';
        $schedule_to = isset($_POST['schedule_to']) ? $_POST['schedule_to'] : '';
        
        // Force it into proper HH:MM:SS format (adds ":00" if needed)
        if (strlen($schedule_from) === 5) $schedule_from .= ":00";
        if (strlen($schedule_to) === 5) $schedule_to .= ":00";
        $job_Title = $_POST["job_Title"]; 
        $age = $_POST["age"];
        $gender = $_POST["gender"];
        $civil_Status = $_POST["civil_Status"];
        $Religion = $_POST["Religion"];
        $birthday = $_POST["birthday"];
        $birth_Place = $_POST["birth_Place"];
        $Citizenship = $_POST["Citizenship"];
        $Contact_No = $_POST["Contact_No"];
        $house_block = $_POST["house_block"];
        $street = $_POST["street"];
        $subdivision = $_POST["subdivision"];
        $barangay = $_POST["barangay"];
        $city_muntinlupa = $_POST["city_muntinlupa"];
        $province = $_POST["province"];
        $zip_code = $_POST["zip_code"];
        $surname = $_POST["Lname"];
        $First_name = $_POST["Fname"];
        $Middle_name = $_POST["Mname"];
        $suffix = $_POST["suffix"];
        $email = $_POST["email"];
        $username = $_POST["username"];
        $password = $_POST["password"];
        $confirm_password = $_POST["confirm_password"];
    
        $errors = [];
    
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
            $errors["image_file"] = "Please select an image to upload.";
        }
    
        if (admin_empty_inputs($employeeID, $rateType, $salary_Range_From, $salary_Range_To, $job_Title, $gender,
        $Citizenship, $Contact_No, $barangay, $street,
        $city_muntinlupa, $province, $zip_code, $surname, $First_name, $Middle_name, $email, $username,
        $password, $confirm_password)) {
            $errors["empty_inputs"] = "Please fill all Required fields!";
        }
        if(invalid_email($email)){
            $errors["invalid_email"] = "your email is invalid!";
        }
        if(email_registered($pdo, $email)){
            $errors["email_registered"] = "your email is already registered!";
        }
        if(password_notMatch ($confirm_password, $password)){
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
                "employeeID" => $employeeID,
                "department" => $department,
                "rateType" => $rateType,
                "salary_Range_From" => $salary_Range_From,
                "salary_Range_To" => $salary_Range_To,
                "job_Title" => $job_Title,
                "age" => $age,
                "gender" => $gender,
                "civil_Status" => $civil_Status,
                "Religion" => $Religion,
                "birthday" => $birthday,
                "birth_Place" => $birth_Place,
                "Citizenship" => $Citizenship,
                "Contact_No" => $Contact_No,
                "house_block" => $house_block,
                "street" => $street,
                "subdivision" => $subdivision,
                "barangay" => $barangay,
                "city_muntinlupa" => $city_muntinlupa,
                "province" => $province,
                "zip_code" => $zip_code,
                "Fname" => $First_name,
                "Lname" => $surname,
                "Mname" => $Middle_name,
                "suffix" => $suffix,
                "email" => $email,
                "profile" => $profile,
                "username" => $username
            ];
            $_SESSION["admin_signup"] = $signup_data;
            header("Location: ../src/register.php");
            die();
        }
        
        try {
            registerEmployee(
                $pdo,
                $employeeID,  $rateType,  $salary_Range_From,  $salary_Range_To,  $schedule_from,  $schedule_to,  $job_Title,  $age,  $gender,
                $civil_Status,  $Religion,  $birthday,  $birth_Place,  $Citizenship,
                $Contact_No,  $house_block,  $subdivision,  $barangay,  $street,  $city_muntinlupa,
                $province,  $zip_code,  $surname,  $First_name,  $Middle_name,  $suffix,
                $username, $profile,  $email,  $password,  $department
            );
            
            
            
            header("Location: ../src/index.php?signup=success");
    
            $stmt = null;
            $pdo = null;
    
            die();
        } catch (PDOException $e) {
            die("QUERY FAILED: " . $e->getMessage());
        }
    }
    
    if(isset($_POST["approve"]) && $_POST["approve"] == "admin"){
        echo isset($_GET["id"]) ? $id = $_GET["id"] : null;
        if(!empty($id)){
            $query = "UPDATE userrequest SET status = 'approved' WHERE id = :id";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->execute();
            header("Location: ../src/admin/employee.php?approve=success");
            DIE();
        }else{
            echo "id is empty!";
        }
       
    }

//     if(isset($_POST["approve"]) && $_POST["approve"] == "request"){
//         echo isset($_GET["id"]) ? $id = $_GET["id"] : null;
//         if (!empty($id)) {
//         $query = "UPDATE userrequest SET status = 'approved' WHERE id = :id";
//         $stmt = $pdo->prepare($query);
//         $stmt->bindParam(":id", $id, PDO::PARAM_INT);
//         $stmt->execute();

//         $query = "SELECT status FROM userrequest WHERE id = :id";
//         $stmt = $pdo->prepare($query);
//         $stmt->bindParam(":id", $id, PDO::PARAM_INT);
//         $stmt->execute();
//         $status = $stmt->fetch(PDO::FETCH_ASSOC);

//         echo $status && isset($status["status"]) ? $status["status"] : "Status fetch failed";

//         $stmt = null;
//         $pdo = null;
//         exit;
//     } else {
//         echo "Invalid ID.";
//         exit;
//     }
// }

    if(isset($_POST["reject"]) && $_POST["reject"] == "request"){
        isset($_GET["id"]) ? $id = $_GET["id"] : null;
        
        $query = "UPDATE userrequest  SET status = 'Rejected' WHERE id = :id;";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        header("Location: ../src/admin/employee.php?rejected=success");

        $stmt = null;
        $pdo = null;
        die();
    }

    if(isset($_POST["delete"]) && $_POST["delete"] == "request"){
        isset($_GET["id"]) ? $id = $_GET["id"] : null;
        
        $query = "DELETE FROM users
        WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        header("Location: ../src/admin/employee.php?deleted=success");

        $stmt = null;
        $pdo = null;
        die();
    }
    // ================ ADDED BY ADMIN ================= //

if(isset($_POST["addeemployee"]) && $_POST["addeemployee"] == "Byadmin"){
    isset($_GET["id"]) ? $id = $_GET["id"] : null;
        $employeeID = $_POST["employeeID"];
        $department = $_POST["department"];
        $rateType = $_POST["rateType"]; 
        $salary_Range_From = intval($_POST["salary_Range_From"]);
        $salary_Range_To = intval($_POST["salary_Range_To"]); 
        // $schedule_from = intval($_POST["schedule_from"]); 
        // $schedule_to = intval($_POST["schedule_to"]); 
        $schedule_from = isset($_POST['schedule_from']) ? $_POST['schedule_from'] : '';
        $schedule_to = isset($_POST['schedule_to']) ? $_POST['schedule_to'] : '';
        
        // Force it into proper HH:MM:SS format (adds ":00" if needed)
        if (strlen($schedule_from) === 5) $schedule_from .= ":00";
        if (strlen($schedule_to) === 5) $schedule_to .= ":00";

        $job_Title = $_POST["job_Title"]; 
        $age = $_POST["age"];
        $gender = $_POST["gender"];
        $civil_Status = $_POST["civil_Status"];
        $Religion = $_POST["Religion"];
        $birthday = $_POST["birthday"];
        $birth_Place = $_POST["birth_Place"];
        $Citizenship = $_POST["Citizenship"];
        $Contact_No = $_POST["Contact_No"];
        $house_block = $_POST["house_block"];
        $street = $_POST["street"];
        $subdivision = $_POST["subdivision"];
        $barangay = $_POST["barangay"];
        $city_muntinlupa = $_POST["city_muntinlupa"];
        $province = $_POST["province"];
        $zip_code = $_POST["zip_code"];
        $surname = $_POST["Lname"];
        $First_name = $_POST["Fname"];
        $Middle_name = $_POST["Mname"];
        $suffix = $_POST["suffix"];
        $email = $_POST["email"];
        $username = $_POST["username"];
        $password = $_POST["password"];
        $confirm_password = $_POST["confirm_password"];
    
        $errors = [];
    
        if (admin_empty_inputs($employeeID, $rateType, $salary_Range_From, $salary_Range_To, $job_Title, $gender,
        $Citizenship, $Contact_No, $barangay, $street,
        $city_muntinlupa, $province, $zip_code, $surname, $First_name, $Middle_name, $email, $username,
        $password, $confirm_password)) {
            $errors["empty_inputs"] = "Please fill all Required fields!";
        }
        if(invalid_email($email)){
            $errors["invalid_email"] = "your email is invalid!";
        }
        if(email_registered($pdo, $email)){
            $errors["email_registered"] = "your email is already registered!";
        }
        if(password_notMatch ($confirm_password, $password)){
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
            $_SESSION["admin_Errors"] = $errors;
            $signup_data = [
                "employeeID" => $employeeID,
                "department" => $department,
                "rateType" => $rateType,
                "salary_Range_From" => $salary_Range_From,
                "salary_Range_To" => $salary_Range_To,
                "job_Title" => $job_Title,
                "age" => $age,
                "gender" => $gender,
                "civil_Status" => $civil_Status,
                "Religion" => $Religion,
                "birthday" => $birthday,
                "birth_Place" => $birth_Place,
                "Citizenship" => $Citizenship,
                "Contact_No" => $Contact_No,
                "house_block" => $house_block,
                "street" => $street,
                "subdivision" => $subdivision,
                "barangay" => $barangay,
                "city_muntinlupa" => $city_muntinlupa,
                "province" => $province,
                "zip_code" => $zip_code,
                "Fname" => $First_name,
                "Lname" => $surname,
                "Mname" => $Middle_name,
                "suffix" => $suffix,
                "email" => $email,
                "username" => $username
            ];
            $_SESSION["admin_signup"] = $signup_data;
            header("Location: ../src/admin/employee.php");
            die();
        }
        
        try {
            AddedByHr(
                $pdo,
                $employeeID,  $rateType,  $salary_Range_From,  $salary_Range_To, $schedule_from, $schedule_to,  $job_Title,  $age,  $gender,
                $civil_Status,  $Religion,  $birthday,  $birth_Place,  $Citizenship,
                $Contact_No,  $house_block,  $subdivision,  $barangay,  $street,  $city_muntinlupa,
                $province,  $zip_code,  $surname,  $First_name,  $Middle_name,  $suffix,
                $username,  $email,  $password,  $department
            );
            
            
            header("Location: ../src/admin/employee.php?admin=success");
    
            $stmt = null;
            $pdo = null;
    
            die();
        } catch (PDOException $e) {
            die("QUERY FAILED: " . $e->getMessage());
        }
    }

// ================== CHANGE PASSWORD ADMIN ============================= //

if(isset($_POST["password"]) && $_POST["password"] == "change"){
    $current_password = $_POST["current_password"];
    $new_password = $_POST["new_password"];
    $confirm_password = $_POST["confirm_password"];
    
    try {
        $errors = [];
        if(password_notMatch ($confirm_password, $password)){
            $errors["password_notMatch"] = "Password not match!";
        }

    } catch (PDOException $e) {
        die("QUERY FAILED: " . $e->getMessage());
    }
}

// ================== CHANGE PASSWORD EMPLOYEE ============================= //

if (isset($_POST["password"]) && $_POST["password"] == "employee") {
    isset($_GET["id"]) ? $id = $_GET["id"] : null;
    $current_password = $_POST["current_password"];
    $new_password = $_POST["new_password"];
    $confirm_password = $_POST["confirm_password"];

    try {
        $errors = [];

        if (password_notMatch($confirm_password, $new_password)) {
            $errors["password_notMatch"] = "Password not match!";
        }
        if (currentPassword($pdo, $id, $current_password)) {
            $errors["password_notMatch"] = "Current Password not match!";
        }
        if ($errors) {
            $_SESSION["signup_errors"] = $errors;
            header("Location: ../src/employee/settings.php");
            die();
        }

        updatePassword($pdo, $id, $new_password);
        header("Location: ../src/employee/settings.php?password=success");

        $stmt = null;
        $pdo = null;

        die();

    } catch (PDOException $e) {
        die("QUERY FAILED: " . $e->getMessage());
    }
}

// =================== DELETE USER ================== //

if(isset($_POST["delete"]) && $_POST["delete"] == "userAccount"){
    $usersID = $_POST["id"];

    if($usersID){
        $query = "DELETE FROM users WHERE id = :id;";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $usersID);
        if ($stmt->execute()) {
            echo json_encode(["success" => true, "message" => "User inserted successfully."]);
        } else {
            echo json_encode(["success" => false, "message" => "Failed to insert user."]);
        }
        header("Location: ../src/admin/employee.php?deleted=success");
        $pdo=null;
        $stmt=null;
        die();
    }else{
        header("Location: ../src/admin/employee.php?no=id");
        die();
    }
    

}

// =================== ADD JOB TITLE ================== //
if(isset($_POST["addJobs"]) && $_POST["addJobs"] == "admin"){
    $job = $_POST["jobs"];

        if(empty($job)){
            header("Location: ../src/admin/Jobs.php?job=empty");
            die();
        }else{
            $query = "INSERT INTO jobs (jobs) VALUES (:jobs);";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(":jobs", $job);
            if ($stmt->execute()) {
                echo json_encode(["success" => true, "message" => "JOB inserted successfully."]);
            } else {
                echo json_encode(["success" => false, "message" => "Failed to insert JOBS."]);
            }
            header("Location: ../src/admin/Jobs.php?job=success");
            $pdo=null;
            $stmt=null;
            die();
        }

        
}

if(isset($_POST["update"]) && $_POST["update"] == "Nani"){
    isset($_GET["id"]) ? $id = $_GET["id"] : null;
    $employeeID = $_POST["employeeID"];
    $department = $_POST["department"];
    $rateType = $_POST["rateType"]; 
    $salary_Range_From = intval($_POST["salary_Range_From"]);
    $salary_Range_To = intval($_POST["salary_Range_To"]); 
    $schedule_from = isset($_POST['schedule_from']) ? $_POST['schedule_from'] : '';
    $schedule_to = isset($_POST['schedule_to']) ? $_POST['schedule_to'] : '';
    
    // Force it into proper HH:MM:SS format (adds ":00" if needed)
    if (strlen($schedule_from) === 5) $schedule_from .= ":00";
    if (strlen($schedule_to) === 5) $schedule_to .= ":00";
    $job_Title = $_POST["job_Title"]; 
    $age = $_POST["age"];
    $gender = $_POST["gender"];
    $civil_Status = $_POST["civil_Status"];
    $Religion = $_POST["Religion"];
    $birthday = $_POST["birthday"];
    $birth_Place = $_POST["birth_Place"];
    $Citizenship = $_POST["Citizenship"];
    $Contact_No = $_POST["Contact_No"];
    $house_block = $_POST["house_block"];
    $street = $_POST["street"];
    $subdivision = $_POST["subdivision"];
    $barangay = $_POST["barangay"];
    $city_muntinlupa = $_POST["city_muntinlupa"];
    $province = $_POST["province"];
    $zip_code = $_POST["zip_code"];
    $surname = $_POST["Lname"];
    $First_name = $_POST["Fname"];
    $Middle_name = $_POST["Mname"];
    $suffix = $_POST["suffix"];
    $email = $_POST["email"];

    try {
        $errors = [];
        
        if (isset($_FILES["user_profile"]) && $_FILES["user_profile"]["error"] === 0) {
            $profile = $_FILES["user_profile"];
        
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
            // No image uploaded — it's optional, so just skip without adding an error
            $profile = null; // Or keep the previous value if updating
        }
        
        if(invalid_email($email)){
            $errors["invalid_email"] = "your email is invalid!";
        }

        if($errors){
            $_SESSION["admin_Errors"] = $errors;
            header("Location: ../src/admin/EmployeeProfile.php");
            die();
        } else {
            if ($profile === null) {
                $stmt = $pdo->prepare("SELECT user_profile FROM signup_information WHERE users_id = :id");
                $stmt->execute(["id" => $id]);
                $fetched = $stmt->fetchColumn();
            
                // Ensure the fallback is a string
                $profile = is_string($fetched) ? $fetched : '';
            }
            
        
            updateEmployee(
                $pdo, $id,
                $employeeID, $rateType, $salary_Range_From, $salary_Range_To, $schedule_from, $schedule_to, $job_Title, $age, $gender,
                $civil_Status, $Religion, $birthday, $birth_Place, $Citizenship,
                $Contact_No, $house_block, $subdivision, $barangay, $street, $city_muntinlupa,
                $province, $zip_code, $surname, $First_name, $Middle_name, $suffix,
                $profile, $email, $department
            );
        
            header("Location: ../src/admin/EmployeeProfile.php?update=success");
            $stmt = null;
            $pdo = null;
            die();
        }
        


    } catch (PDOException $e) {
        die("QUERY FAILED: " . $e->getMessage());
    }
}

if(isset($_POST["update"]) && $_POST["update"] == "Employee"){
    isset($_GET["id"]) ? $id = $_GET["id"] : null;
    $employeeID = $_POST["employeeID"];
    $department = $_POST["department"];
    $rateType = $_POST["rateType"]; 
    $salary_Range_From = intval($_POST["salary_Range_From"]);
    $salary_Range_To = intval($_POST["salary_Range_To"]); 
    $job_Title = $_POST["job_Title"]; 
    $age = $_POST["age"];
    $gender = $_POST["gender"];
    $civil_Status = $_POST["civil_Status"];
    $Religion = $_POST["Religion"];
    $birthday = $_POST["birthday"];
    $birth_Place = $_POST["birth_Place"];
    $Citizenship = $_POST["Citizenship"];
    $Contact_No = $_POST["Contact_No"];
    $house_block = $_POST["house_block"];
    $street = $_POST["street"];
    $subdivision = $_POST["subdivision"];
    $barangay = $_POST["barangay"];
    $city_muntinlupa = $_POST["city_muntinlupa"];
    $province = $_POST["province"];
    $zip_code = $_POST["zip_code"];
    $surname = $_POST["Lname"];
    $First_name = $_POST["Fname"];
    $Middle_name = $_POST["Mname"];
    $suffix = $_POST["suffix"];
    $email = $_POST["email"];

    try {
        $errors = [];
        
        if (isset($_FILES["user_profile"]) && $_FILES["user_profile"]["error"] === 0) {
            $profile = $_FILES["user_profile"];
        
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
            // No image uploaded — it's optional, so just skip without adding an error
            $profile = null; // Or keep the previous value if updating
        }
        
        if(invalid_email($email)){
            $errors["invalid_email"] = "your email is invalid!";
        }

        if($errors){
            $_SESSION["admin_Errors"] = $errors;
            header("Location: ../src/admin/EmployeeProfile.php");
            die();
        } else {
            if ($profile === null) {
                $stmt = $pdo->prepare("SELECT user_profile FROM signup_information WHERE users_id = :id");
                $stmt->execute(["id" => $id]);
                $fetched = $stmt->fetchColumn();
            
                // Ensure the fallback is a string
                $profile = is_string($fetched) ? $fetched : '';
            }
            
        
            updateEmployee(
                $pdo, $id,
                $employeeID, $rateType, $salary_Range_From, $salary_Range_To, $job_Title, $age, $gender,
                $civil_Status, $Religion, $birthday, $birth_Place, $Citizenship,
                $Contact_No, $house_block, $subdivision, $barangay, $street, $city_muntinlupa,
                $province, $zip_code, $surname, $First_name, $Middle_name, $suffix,
                $profile, $email, $department
            );
        
            header("Location: ../src/employee/profile.php?update=success&id=" . $id);
            $stmt = null;
            $pdo = null;
            die();
        }
        


    } catch (PDOException $e) {
        die("QUERY FAILED: " . $e->getMessage());
    }
}

// ========== DELETE JOBS =================== //

if(isset($_POST["job"]) && $_POST["job"] == "delete"){
    $jobID = $_POST["id"];

    if($jobID){
        $query = "DELETE FROM jobs WHERE id = :id;";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $jobID);
        if ($stmt->execute()) {
            echo json_encode(["success" => true, "message" => "User inserted successfully."]);
        } else {
            echo json_encode(["success" => false, "message" => "Failed to insert user."]);
        }
        header("Location: ../src/admin/Jobs.php?deleted=job");
        $pdo=null;
        $stmt=null;
        die();
    }else{
        // header("Location: ../src/admin/Jobs.php?no=id");
        echo $jobID;
        die();
    }
    
}

// ========================= leave breavement ==================== //

if(isset($_POST["leave"]) && $_POST["leave"] == "admin") {
    $employee_id = $_POST["employee_id"];
    echo $leave_Type = $_POST["leave_Type"];
    $dates = $_POST["Leave_Date"]; 
    
    try {
        $errors = [];

        if (isset($_FILES["prof"]) && $_FILES["prof"]["error"] === 0) {
            $prof = $_FILES["prof"];
            if (empty_images($prof)) {
                $errors["image_Empty"] = "Please insert your profile image!";
            }
        
            if (fileSize_notCompatibles($prof)) {
                $errors["large_File"] = "The image must not exceed 5MB!";
            }
        
            $allowed_types = [
                "image/jpeg",
                "image/jpg",
                "image/png"
            ];
        
            if (image_notCompatibles($prof, $allowed_types)) {
                $errors["file_Types"] = "Only JPG, JPEG, PNG files are allowed.";
            }
        
            if (!$errors) {
                $target_dir = "../assets/image/upload/";
                $image_file_name = uniqid() . "-" . basename($prof["name"]);
                $target_file = $target_dir . $image_file_name;
            
                if (move_uploaded_file($prof["tmp_name"], $target_file)) {
                    $prof = $image_file_name;
                } else {
                    $errors["upload_Error"] = "There was an error uploading your image.";
                }
            }
        } else {
            $errors["image_file"] = "Please select an image to upload.";
        }

        if(idNotFound($pdo, $employee_id)) {
            $errors["employee_id"] = "Employee ID not found!";
        }
        if(emptyLEaveForms($employee_id, $leave_Type, $dates)){
            $errors["leave_form"] = "fill up all fields!";
        }
        if(noLeave($pdo, $employee_id, $leave_Type)){
            $errors["NotEnoughCreditLeft"] = "NO LEAVE CREDIT LEFT!";
        }

        if($errors){
            $_SESSION["leaveForm_errors"] = $errors;
            header("Location: ../src/admin/leave.php");
            die();
        }else{
            $_SESSION["breavementCreditToUse"] - 1;

            leave($pdo, $employee_id, $leave_Type, $dates, $prof);
            header("Location: ../src/admin/leave.php?leave=success");
            $stmt = null;
            $pdo=null;
            die();
        }

    } catch (PDOException $e) {
        die("QUERY FAILED: " . $e->getMessage());
    }
}
if(isset($_POST["leave"]) && $_POST["leave"] == "employee") {
    isset($_GET["id"]) ? $id = $_GET["id"] : null;
    $employee_id = $_POST["employeeID"];
    echo $leave_Type = $_POST["leave_Type"];
    $dates = $_POST["Leave_Date"]; 
    
    try {
        $errors = [];

        if (isset($_FILES["prof"]) && $_FILES["prof"]["error"] === 0) {
            $prof = $_FILES["prof"];
            if (empty_images($prof)) {
                $errors["image_Empty"] = "Please insert your profile image!";
            }
        
            if (fileSize_notCompatibles($prof)) {
                $errors["large_File"] = "The image must not exceed 5MB!";
            }
        
            $allowed_types = [
                "image/jpeg",
                "image/jpg",
                "image/png"
            ];
        
            if (image_notCompatibles($prof, $allowed_types)) {
                $errors["file_Types"] = "Only JPG, JPEG, PNG files are allowed.";
            }
        
            if (!$errors) {
                $target_dir = "../assets/image/upload/";
                $image_file_name = uniqid() . "-" . basename($prof["name"]);
                $target_file = $target_dir . $image_file_name;
            
                if (move_uploaded_file($prof["tmp_name"], $target_file)) {
                    $prof = $image_file_name;
                } else {
                    $errors["upload_Error"] = "There was an error uploading your image.";
                }
            }
        } else {
            $errors["image_file"] = "Please select an image to upload.";
        }

        if(idNotFound($pdo, $employee_id)) {
            $errors["employee_id"] = "Employee ID not found!";
        }
        if(emptyLEaveForms($employee_id, $leave_Type, $dates)){
            $errors["leave_form"] = "fill up all fields!";
        }
        if(noLeave($pdo, $employee_id, $leave_Type)){
            $errors["NotEnoughCreditLeft"] = "NO LEAVE CREDIT LEFT!";
        }

        if($errors){
            $_SESSION["leaveForm_errors"] = $errors;
            header("Location: ../src/employee/leave.php");
            die();
        }else{
            $_SESSION["breavementCreditToUse"] - 1;

            leaveRequest($pdo, $employee_id, $leave_Type, $dates, $prof);
            header("Location: ../src/employee/leave.php?leaveE=success");
            $stmt = null;
            $pdo=null;
            die();
        }

    } catch (PDOException $e) {
        die("QUERY FAILED: " . $e->getMessage());
    }
}
if(isset($_POST["delete"]) && $_POST["delete"] == "adminLeave"){
    echo isset($_GET["leaveID"]) && $_GET["leaveID"] !== "" ? $id = $_GET["leaveID"] : null;
    try{ 
        $query = "DELETE FROM leavea WHERE leaveID = :leaveID;";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":leaveID", $id);
        $stmt->execute();

        header("Location: ../src/admin/leave.php?leaveDelete=success");
        $stmt = null;
        $stmpdo = null;
        die();
    }catch (PDOException $e){
        die("QUERY FAILED: " . $e->getMessage());
    }
}
if (isset($_POST["accept"]) && $_POST["accept"] === "admin") {
    echo isset($_GET["leaveID"]) && $_GET["leaveID"] !== "" ? $id = $_GET["leaveID"] : null;
    if (!$id) {
        die("No valid leaveID provided.");
    }

    try {
        
        $query = "UPDATE leavea SET leave_Status = 'approved' WHERE leaveID = :leaveID";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":leaveID", $id, PDO::PARAM_INT);
        $stmt->execute();

        $query = "INSERT INTO leave_approved (leave_id) VALUES (:leave_id)";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":leave_id", $id, PDO::PARAM_INT);
        $stmt->execute();

        header("Location: ../src/admin/leave.php?leaveAksep=success");
        exit;
    } catch (PDOException $e) {
        die("QUERY FAILED: " . $e->getMessage());
    }
}

if (isset($_POST["deleteLeave"]) && $_POST["deleteLeave"] === "admin") {
    echo isset($_GET["leaveID"]) && $_GET["leaveID"] !== "" ? $id = $_GET["leaveID"] : null;
    if (!$id) {
        die("No valid leaveID provided.");
    }

    try {
        
        $query = "UPDATE leavea SET leave_Status = 'reject' WHERE leaveID = :leaveID";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":leaveID", $id, PDO::PARAM_INT);
        $stmt->execute();

        header("Location: ../src/admin/leave.php?rejectedL=success");
        exit;
    } catch (PDOException $e) {
        die("QUERY FAILED: " . $e->getMessage());
    }
}

    unset($_SESSION['csrf_token']);
}