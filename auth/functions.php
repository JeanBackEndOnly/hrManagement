<?php
include "../installer/config.php";
// include 'control.php';


function initInstaller() {
    $pdo = db_connect(); 

    try {
        $stmt = $pdo->prepare("SELECT * FROM admin WHERE user_role = :user_role");
        $stmt->execute(['user_role' => 'administrator']);
        $admins = $stmt->fetchAll();

        $currentUrl = $_SERVER['REQUEST_URI'];
        $installerPath = "/github/ZPCO-SYS/installer/";

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


function base_url(){
    $pdo = db_connect();
    

	if(isset($_SERVER['HTTPS'])){
        $protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
    }
    else{
        $protocol = 'http';
    }

    $whitelist = array(
        '127.0.0.1',
        '::1'
    );
    
    if(in_array($_SERVER['REMOTE_ADDR'], $whitelist)){
        return $base_url = $protocol . "://" . $_SERVER['SERVER_NAME'].'/github/ZPCO-SYS/';
    }
    return $base_url = $protocol . "://" . $_SERVER['SERVER_NAME'].'/';

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
    base_url() . 'assets/js/hr.js' ,
    base_url() . 'assets/js/main2.js',
    base_url() . 'assets/js/service-worker.js'
    ];

    foreach($scripts as $script){
        echo '<script type="text/javascript" src="' . $script . '"></script>';
    }

}


function get_option($key) {
    try {
        $pdo = db_connect(); 

        $stmt = $pdo->prepare("SELECT meta_value FROM options WHERE meta_key = :key");
        $stmt->execute(['key' => $key]);

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return $row['meta_value'];
        }
        return '';

    } catch (PDOException $e) {
        error_log("Database error in get_option(): " . $e->getMessage());
        return '';
    }
}

// =========================== save profile =========================== //

function save_profile($args = array(), $user_id = 0) {
    $conn = db_connect();

    try {
        if (!$user_id) {
            $stmt = $conn->prepare("SELECT * FROM admin WHERE username = ?");
            $stmt->execute([$args['username']]);

            if ($stmt->rowCount() > 0) {
                return array(
                    'is_error' => true,
                    'message' => 'Username already exists'
                );
            }

            $columns = implode(', ', array_keys($args));
            $placeholders = implode(', ', array_map(function($key) {
                return ":$key";
            }, array_keys($args)));

            $sql = "INSERT INTO admin ($columns) VALUES ($placeholders)";
            $stmt = $conn->prepare($sql);
            $stmt->execute($args);
        } else {
            $setPart = implode(', ', array_map(function($key) {
                return "$key = :$key";
            }, array_keys($args)));

            $sql = "UPDATE admin SET $setPart WHERE id = :id";
            $stmt = $conn->prepare($sql);

            $args['id'] = $user_id;
            $stmt->execute($args);
        }

        return array(
            'is_error' => false,
            'message' => 'Success'
        );
    } catch (PDOException $e) {
        return array(
            'is_error' => true,
            'message' => 'Database Error: ' . $e->getMessage()
        );
    }
}

// =============================== system logo ====================================//

function save_option($key, $value) {
    $conn = db_connect(); 

    if (is_array($value)) {
        $value = json_encode($value);
    }

    try {
        $stmt = $conn->prepare("SELECT COUNT(*) FROM options WHERE meta_key = :meta_key");
        $stmt->execute([':meta_key' => $key]);
        $exists = $stmt->fetchColumn();

        if ($exists) {
            $stmt = $conn->prepare("UPDATE options SET meta_value = :meta_value WHERE meta_key = :meta_key");
        } else {
            $stmt = $conn->prepare("INSERT INTO options (meta_key, meta_value) VALUES (:meta_key, :meta_value)");
        }

        $result = $stmt->execute([
            ':meta_key'   => $key,
            ':meta_value' => $value
        ]);

        return $result;
    } catch (PDOException $e) {
        error_log("Database error in save_option: " . $e->getMessage());
        return false;
    }
}
function save_user($args = array(), $user_id = 0) {
    $conn = db_connect();

    try {
        if (!$user_id) {
            $stmt = $conn->prepare("SELECT * FROM admin WHERE username = ?");
            $stmt->execute([$args['username']]);

            if ($stmt->rowCount() > 0) {
                return array(
                    'is_error' => true,
                    'message' => 'Username already exists'
                );
            }

            $columns = implode(', ', array_keys($args));
            $placeholders = implode(', ', array_map(function($key) {
                return ":$key";
            }, array_keys($args)));

            $sql = "INSERT INTO admin ($columns) VALUES ($placeholders)";
            $stmt = $conn->prepare($sql);
            $stmt->execute($args);
        } else {
            $setPart = implode(', ', array_map(function($key) {
                return "$key = :$key";
            }, array_keys($args)));

            $sql = "UPDATE admin SET $setPart WHERE id = :id";
            $stmt = $conn->prepare($sql);

            $args['id'] = $user_id;
            $stmt->execute($args);
        }

        return array(
            'is_error' => false,
            'message' => 'Success'
        );
    } catch (PDOException $e) {
        return array(
            'is_error' => true,
            'message' => 'Database Error: ' . $e->getMessage()
        );
    }
}

// ========================= MARCO controls ================================= //

function fileSize_notCompatible(array $profile){
    if($profile["size"] > 5 * 1024 * 1024){
        return true;
    }else{
        return false;
    }
}

function image_notCompatible(array $profile, array $allowed_types){
    if(!in_array($profile["type"], $allowed_types)){
        return true;
    }else{
        return false;
    }
}

function file_notUploaded(array $profile, string $target_file){
    if (!move_uploaded_file($profile["tmp_name"], $target_file)) {
        return true;
    }else{
        return false;
    }
}
function empty_image(array $profile){
    if(empty($profile)){
        return true;
    }else{
        return false;
    }
}

function fileSize_notCompatibles(array $prof){
    if($prof["size"] > 5 * 1024 * 1024){
        return true;
    }else{
        return false;
    }
}

function image_notCompatibles(array $prof, array $allowed_types){
    if(!in_array($prof["type"], $allowed_types)){
        return true;
    }else{
        return false;
    }
}

function file_notUploadeds(array $prof, string $target_file){
    if (!move_uploaded_file($prof["tmp_name"], $target_file)) {
        return true;
    }else{
        return false;
    }
}
function empty_images(array $prof){
    if(empty($prof)){
        return true;
    }else{
        return false;
    }
}

function empty_inputs($surname, $First_name, $Middle_name, $email, $username, $password, $confirm_password){
    if(empty($surname) || empty($First_name) || empty($Middle_name) || empty($email) ||
        empty($username) || empty($password) || empty($confirm_password)){
        return true;
    }else{
        return false;
    }
}
function admin_empty_inputs($employeeID, $rateType, $salary_Range_From, $salary_Range_To, $job_Title, $gender,
$Citizenship, $Contact_No, $barangay, $street,
$city_muntinlupa, $province, $zip_code, $surname, $First_name, $Middle_name, $email, $username,
$password, $confirm_password){
    if(empty($employeeID) || empty($rateType) || empty($salary_Range_From) || empty($salary_Range_To) || empty($job_Title) || empty($gender) 
    || empty($Citizenship) || empty($Contact_No) || empty($barangay) || empty($street)
    || empty($city_muntinlupa) || empty($province) || empty($zip_code)
    || empty($surname) || empty($First_name) || empty($Middle_name) || empty($email) || empty($username) || empty($password) || empty($confirm_password)){
        return true;
        }else{
            return false;
        }
}
function idNotFound(object $pdo, string $employee_id){
    if(getID($pdo, $employee_id)){
        return false;
    }else{
        return true;
    }
}
function emptyLEaveForms($employee_id, $leave_Type, $dates){
    if(empty($employee_id) || empty($leave_Type) || empty($dates)){
        return true;
    }else{
        return false;
    }
}
function noLeave(object $pdo, string $employee_id, string $leave_Type){
    if(getLeaveCounts($pdo, $employee_id, $leave_Type) == 0){
        return true;
    }else{
        return false;
    }
}
function invalid_email(string $email){
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        return true;
    }else{
        return false;
    }
}
function password_notMatch(string $confirm_password, string $hashedPassword){
    if($confirm_password !== $hashedPassword){
        return true;
    }else{
        return false;
    }
}
function username_taken(object $pdo, string $username){
    if(get_username($pdo, $username)) {
        return true;
   }else{
        return false;
   }
}

function email_registered(object $pdo, string $email){
   if(get_email($pdo, $email)) {
        return true;
   }else{
        return false;
   }
}

function wrong_username(bool|array $result){
    if(!$result){
        return true;
    }else{
        return false;
    }
}
function password_secured(string $password) {
    if (strlen($password) < 8) {
        return true;
    }else{
        return false;
    }
}

function password_security(string $password){
    if (preg_match('/[A-Z]/', $password) &&    
        preg_match('/[0-9]/', $password) &&    
        preg_match('/[\W_]/', $password)) {      

        return false;
    } else {
        return true;
    }
}

function registerLink(){
    return "../auth/authentications.php";
}

function getUser_account(object $pdo, string $username, string $password) {
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    $userRole = "employee";
    $query = "INSERT INTO users (username, password, user_role) VALUES (:username, :password, :user_role);";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', $hashedPassword);
    $stmt->bindParam(':user_role', $userRole);
    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "User inserted successfully."]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to insert user."]);
    }
    return(int) $pdo->lastInsertId();
}
function addLeaveCounts(object $pdo, int $id){
    $query = "INSERT INTO leave_counts (
        users_id, Breavement, Maternity, Paternity, Sick, Vacation, Wedding
    ) VALUES (
        :users_id, :breavement, :maternity, :paternity, :sick, :vacation, :wedding
    )";
    
    $stmt = $pdo->prepare($query);
    $stmt = $pdo->prepare($query);
    $stmt->bindValue(":users_id", $id, PDO::PARAM_INT);
    $stmt->bindValue(":breavement", 9, PDO::PARAM_INT);
    $stmt->bindValue(":maternity", 120, PDO::PARAM_INT);
    $stmt->bindValue(":paternity", 7, PDO::PARAM_INT);
    $stmt->bindValue(":sick", 10, PDO::PARAM_INT);
    $stmt->bindValue(":vacation", 7, PDO::PARAM_INT);
    $stmt->bindValue(":wedding", 7, PDO::PARAM_INT);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "User inserted successfully."]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to insert user."]);
    }
}

function request(object $pdo, int $id) {
    $user_Status = "pending";
    $query = "INSERT INTO userRequest (users_id, status)
    VALUES (:users_id, :status);";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":users_id", $id, PDO::PARAM_INT);
    $stmt->bindParam(":status", $user_Status);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "User inserted successfully."]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to insert user."]);
    }
}

function getUser_data(object $pdo, int $id, string $profile, string $surname, string $First_name, string $Middle_name, string $suffix, string $email) {
    $query = "INSERT INTO signup_information (users_id, user_profile, email, Lname, Fname, Mname, suffix)
    VALUES (:users_id, :user_profile, :email, :Lname, :Fname, :Mname, :suffix);";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":users_id", $id, PDO::PARAM_INT);
    $stmt->bindParam(":user_profile", $profile);
    $stmt->bindParam(":Lname", $surname);
    $stmt->bindParam(":Fname", $First_name);
    $stmt->bindParam(":Mname", $Middle_name);
    $stmt->bindParam(":suffix", $suffix);
    $stmt->bindParam(":email", $email);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "User inserted successfully."]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to insert user."]);
    }
}

function admin_getUser_data(object $pdo, int $id, string $surname, string $First_name, string $Middle_name, string $suffix, string $email) {
    $query = "INSERT INTO signup_information (users_id, email, Lname, Fname, Mname, suffix)
    VALUES (:users_id, :email, :Lname, :Fname, :Mname, :suffix);";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":users_id", $id, PDO::PARAM_INT);
    $stmt->bindParam(":Lname", $surname);
    $stmt->bindParam(":Fname", $First_name);
    $stmt->bindParam(":Mname", $Middle_name);
    $stmt->bindParam(":suffix", $suffix);
    $stmt->bindParam(":email", $email);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "User inserted successfully."]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to insert user."]);
    }
}

function addEmployee($pdo, $id, $employeeID, $rateType, $salary_Range_From, $salary_Range_To, $schedule_from, $schedule_to, $job_Title, $age, $gender, $civil_Status, $Religion,
$birthday, $birth_Place, $Citizenship, $Contact_No, $house_block,$subdivision, $barangay, $street,
$city_muntinlupa, $province, $zip_code){
    $query = "INSERT INTO addbyadmin (
        users_id, employeeID, rateType, salary_Range_From, salary_Range_To, 
        schedule_from, schedule_to, job_Title, age, gender, civil_Status, Religion, 
        birthday, birth_Place, Citizenship, Contact_No, house_block, subdivision, 
        barangay, street, city_muntinlupa, province, zip_code
    ) VALUES (
        :users_id, :employeeID, :rateType, :salary_Range_From, :salary_Range_To, 
        :schedule_from, :schedule_to, :job_Title, :age, :gender, :civil_Status, :Religion, 
        :birthday, :birth_Place, :Citizenship, :Contact_No, :house_block, :subdivision, 
        :barangay, :street, :city_muntinlupa, :province, :zip_code
    );";

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":users_id", $id);
    $stmt->bindParam(":employeeID", $employeeID);
    $stmt->bindParam(":rateType", $rateType);
    $stmt->bindParam(":salary_Range_From", $salary_Range_From);
    $stmt->bindParam(":salary_Range_To", $salary_Range_To);
    $stmt->bindParam(":schedule_from", $schedule_from);
    $stmt->bindParam(":schedule_to", $schedule_to);
    $stmt->bindParam(":job_Title", $job_Title);
    $stmt->bindParam(":age", $age);
    $stmt->bindParam(":gender", $gender);
    $stmt->bindParam(":civil_Status", $civil_Status);
    $stmt->bindParam(":Religion", $Religion);
    $stmt->bindParam(":birthday", $birthday);
    $stmt->bindParam(":birth_Place", $birth_Place);
    $stmt->bindParam(":Citizenship", $Citizenship);
    $stmt->bindParam(":Contact_No", $Contact_No);
    $stmt->bindParam(":house_block", $house_block);
    $stmt->bindParam(":subdivision", $subdivision);
    $stmt->bindParam(":barangay", $barangay);
    $stmt->bindParam(":street", $street);
    $stmt->bindParam(":city_muntinlupa", $city_muntinlupa);
    $stmt->bindParam(":province", $province);
    $stmt->bindParam(":zip_code", $zip_code);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "User inserted successfully."]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to insert user."]);
    }
}
function addHr(object $pdo, int $id) {
    $user_Status = "approved";
    $query = "INSERT INTO userRequest (users_id, status)
    VALUES (:users_id, :status);";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":users_id", $id, PDO::PARAM_INT);
    $stmt->bindParam(":status", $user_Status);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "User inserted successfully."]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to insert user."]);
    }
}
function addDepartment(object $pdo, int $id, string $department){
    $query = "INSERT INTO department (users_id, department)
    VALUES (:users_id, :department);";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":users_id", $id, PDO::PARAM_INT);
    $stmt->bindParam(":department", $department);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "User inserted successfully."]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to insert user."]);
    }
}

function AddedByHr(
    object $pdo,
    string $employeeID, string $rateType, int $salary_Range_From, int $salary_Range_To, string $schedule_from, string $schedule_to, string $job_Title, string $age, string $gender,
    string $civil_Status, string $Religion, string $birthday, string $birth_Place, string $Citizenship,
    string $Contact_No, string $house_block, string $subdivision, string $barangay, string $street, string $city_muntinlupa,
    string $province, string $zip_code, string $surname, string $First_name, string $Middle_name, string $suffix,
    string $username, string $email, string $password, string $department
) {
    $id = getUser_account($pdo, $username, $password);

    admin_getUser_data($pdo, $id, $surname, $First_name, $Middle_name, $suffix, $email);

    addEmployee(
        $pdo, $id, $employeeID, $rateType, $salary_Range_From, $salary_Range_To, $schedule_from, $schedule_to,$job_Title, $age, $gender, $civil_Status, $Religion,
        $birthday, $birth_Place, $Citizenship, $Contact_No, $house_block, $subdivision, $barangay, $street,
        $city_muntinlupa, $province, $zip_code
    );

    addHr($pdo, $id);

    addDepartment($pdo, $id, $department);

    addLeaveCounts($pdo, $id);

}
function registerEmployee(
    object $pdo,
    string $employeeID, string $rateType, $salary_Range_From, $salary_Range_To, string $schedule_from, string $schedule_to, string $job_Title, string $age, string $gender,
    string $civil_Status, string $Religion, string $birthday, string $birth_Place, string $Citizenship,
    string $Contact_No, string $house_block, string $subdivision, string $barangay, string $street, string $city_muntinlupa,
    string $province, string $zip_code, string $surname, string $First_name, string $Middle_name, string $suffix,
    string $username, string $profile, string $email, string $password, string $department
) {
    $salary_Range_From = (int)$salary_Range_From;
    $salary_Range_To = (int)$salary_Range_To;

    $id = getUser_account($pdo, $username, $password);

    getUser_data($pdo, $id, $profile, $surname, $First_name, $Middle_name, $suffix, $email);
    
    addEmployee(
        $pdo, $id, $employeeID, $rateType, $salary_Range_From, $salary_Range_To, $schedule_from, $schedule_to, $job_Title, $age, $gender, $civil_Status, $Religion,
        $birthday, $birth_Place, $Citizenship, $Contact_No, $house_block, $subdivision, $barangay, $street,
        $city_muntinlupa, $province, $zip_code
);

    request($pdo, $id);

    addDepartment($pdo, $id, $department);
    addLeaveCounts($pdo, $id);
}
function currentPassword($pdo, $id, $current_password){
    $hashed_password = get_password($pdo, $id);
    if ($hashed_password === null) {
        return true; // User not found, treat as wrong password
    }
    if (!password_verify($current_password, $hashed_password)) {
        return true; // Password is wrong
    }
    return false; // Password is correct
}

function updatePassword(object $pdo, int $id, string $new_password){
    $hash = password_hash($new_password, PASSWORD_BCRYPT);
    $query = "UPDATE users SET password = :password WHERE id = :id;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->bindParam(":password", $hash, PDO::PARAM_STR);
    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Password updated successfully."]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to update password."]);
    }
}
function updateInfo($pdo, $id, $employeeID, $rateType, $salary_Range_From, $salary_Range_To, $schedule_from, $schedule_to, $job_Title, $age, $gender, $civil_Status, $Religion,
$birthday, $birth_Place, $Citizenship, $Contact_No, $house_block, $subdivision, $barangay, $street,
$city_muntinlupa, $province, $zip_code) {

    $query = "UPDATE addbyadmin SET 
        employeeID = :employeeID,
        rateType = :rateType,
        salary_Range_From = :salary_Range_From,
        salary_Range_To = :salary_Range_To,
        schedule_from = :schedule_from,
        schedule_to = :schedule_to,
        job_Title = :job_Title,
        age = :age,
        gender = :gender,
        civil_Status = :civil_Status,
        Religion = :Religion,
        birthday = :birthday,
        birth_Place = :birth_Place,
        Citizenship = :Citizenship,
        Contact_No = :Contact_No,
        house_block = :house_block,
        subdivision = :subdivision,
        barangay = :barangay,
        street = :street,
        city_muntinlupa = :city_muntinlupa,
        province = :province,
        zip_code = :zip_code
        WHERE id = :id";

    $stmt = $pdo->prepare($query);
    $stmt->execute([
        ':employeeID' => $employeeID,
        ':rateType' => $rateType,
        ':salary_Range_From' => $salary_Range_From,
        ':salary_Range_To' => $salary_Range_To,
        ':schedule_from' => $schedule_from,
        ':schedule_to' => $schedule_to,
        ':job_Title' => $job_Title,
        ':age' => $age,
        ':gender' => $gender,
        ':civil_Status' => $civil_Status,
        ':Religion' => $Religion,
        ':birthday' => $birthday,
        ':birth_Place' => $birth_Place,
        ':Citizenship' => $Citizenship,
        ':Contact_No' => $Contact_No,
        ':house_block' => $house_block,
        ':subdivision' => $subdivision,
        ':barangay' => $barangay,
        ':street' => $street,
        ':city_muntinlupa' => $city_muntinlupa,
        ':province' => $province,
        ':zip_code' => $zip_code,
        ':id' => $id
    ]);
}

function updateSignupInfo(object $pdo, int $id, ?string $profile, string $surname, string $First_name, string $Middle_name, string $suffix, string $email) {
    $query = "UPDATE signup_information SET 
        user_profile = :user_profile,
        email = :email,
        Lname = :Lname,
        Fname = :Fname,
        Mname = :Mname,
        suffix = :suffix
        WHERE users_id = :users_id";

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":user_profile", $profile);
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":Lname", $surname);
    $stmt->bindParam(":Fname", $First_name);
    $stmt->bindParam(":Mname", $Middle_name);
    $stmt->bindParam(":suffix", $suffix);
    $stmt->bindParam(":users_id", $id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "User updated successfully."]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to update user."]);
    }
}

    function updateDepartment(object $pdo, int $id, string $department) {
        $query = "UPDATE department SET department = :department WHERE users_id = :users_id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":department", $department);
        $stmt->bindParam(":users_id", $id, PDO::PARAM_INT);
    
        if ($stmt->execute()) {
            echo json_encode(["success" => true, "message" => "Department updated successfully."]);
        } else {
            echo json_encode(["success" => false, "message" => "Failed to update department."]);
        }
    }
    
    function updateEmployee(
        object $pdo,
        int $id,
        string $employeeID, string $rateType, $salary_Range_From, $salary_Range_To, $schedule_from, $schedule_to, string $job_Title, string $age, string $gender,
        string $civil_Status, string $Religion, string $birthday, string $birth_Place, string $Citizenship,
        string $Contact_No, string $house_block, string $subdivision, string $barangay, string $street, string $city_muntinlupa,
        string $province, string $zip_code, string $surname, string $First_name, string $Middle_name, string $suffix,
        ?string $profile, string $email, string $department
    )
     {
        $salary_Range_From = (int)$salary_Range_From;
        $salary_Range_To = (int)$salary_Range_To;
    
        updateSignupInfo($pdo, $id, $profile, $surname, $First_name, $Middle_name, $suffix, $email);
    
        updateInfo(
            $pdo, $id, $employeeID, $rateType, $salary_Range_From, $salary_Range_To, $schedule_from, $schedule_to, $job_Title, $age, $gender, $civil_Status, $Religion,
            $birthday, $birth_Place, $Citizenship, $Contact_No, $house_block, $subdivision, $barangay, $street,
            $city_muntinlupa, $province, $zip_code
        );
    
        updateDepartment($pdo, $id, $department);
    }
    function leave(object $pdo, string $employee_id, string $leave_Type, array $dates, string $prof) {
        $query = "SELECT users_id FROM addbyadmin WHERE employeeID = :employeeID";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":employeeID", $employee_id);
        $stmt->execute();
        $id = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$id) {
            echo json_encode(["success" => false, "message" => "No matching employeeID found."]);
            return;
        }
        
        $users_id = $id['users_id'];
    
        $check = $pdo->prepare("SELECT id FROM users WHERE id = :id");
        $check->bindParam(":id", $users_id, PDO::PARAM_INT);
        $check->execute();
        
        if ($check->rowCount() === 0) {
            echo json_encode(["success" => false, "message" => "users_id $users_id not found in users table."]);
            return;
        }
    
        $query = "INSERT INTO leavea (users_id, employee_id, leave_Type, Leave_Date, leave_Status, prof) 
                  VALUES (:users_id, :employee_id, :leave_Type, :leave_date, 'approved', :prof)";
        
        $leave_ids = [];
        foreach ($dates as $leave_date) {
            $stmt = $pdo->prepare($query);
            $stmt->bindValue(":users_id", $users_id, PDO::PARAM_INT);
            $stmt->bindValue(":employee_id", $employee_id);
            $stmt->bindValue(":leave_Type", $leave_Type);
            $stmt->bindValue(":leave_date", $leave_date);
            $stmt->bindValue(":prof", $prof);
            
            if (!$stmt->execute()) {
                echo json_encode(["success" => false, "message" => "Failed to insert leave date: $leave_date"]);
                return;
            }
    
            $leave_ids[] = $pdo->lastInsertId();
        }
    
        if (count($leave_ids) > 0) {
            $query = "INSERT INTO leave_approved (leave_id) VALUES (:leave_id)";
            $stmt = $pdo->prepare($query);
    
            foreach ($leave_ids as $leave_id) {
                $stmt->bindValue(":leave_id", $leave_id, PDO::PARAM_INT);
                if (!$stmt->execute()) {
                    echo json_encode(["success" => false, "message" => "Failed to insert into leave_approved."]);
                    return;
                }
            }
        }
    
$query = "";
$date_count = count($dates);  

switch ($leave_Type) {
    case "Breavement":
        $query = "UPDATE leave_counts SET Breavement = Breavement - :date_count WHERE users_id = :users_id";
        break;
    case "Maternity":
        $query = "UPDATE leave_counts SET Maternity = Maternity - :date_count WHERE users_id = :users_id";
        break;
    case "Paternity":
        $query = "UPDATE leave_counts SET Paternity = Paternity - :date_count WHERE users_id = :users_id";
        break;
    case "Sick":
        $query = "UPDATE leave_counts SET Sick = Sick - :date_count WHERE users_id = :users_id";
        break;
    case "Vacation":
        $query = "UPDATE leave_counts SET Vacation = Vacation - :date_count WHERE users_id = :users_id";
        break;
    case "Wedding":
        $query = "UPDATE leave_counts SET Wedding = Wedding - :date_count WHERE users_id = :users_id";
        break;
    default:
        echo json_encode(["success" => false, "message" => "Invalid leave type."]);
        return;
}
    }

function leaveRequest(object $pdo, string $employee_id, string $leave_Type, array $dates, string $prof) {
  
    $query = "SELECT users_id FROM addbyadmin WHERE employeeID = :employeeID";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":employeeID", $employee_id);
    $stmt->execute();
    $id = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$id) {
        echo json_encode(["success" => false, "message" => "No matching employeeID found."]);
        return;
    }
    
    $users_id = $id['users_id'];

    $check = $pdo->prepare("SELECT id FROM users WHERE id = :id");
    $check->bindParam(":id", $users_id, PDO::PARAM_INT);
    $check->execute();
    
    if ($check->rowCount() === 0) {
        echo json_encode(["success" => false, "message" => "users_id $users_id not found in users table."]);
        return;
    }
    $query = "INSERT INTO leavea (users_id, employee_id, leave_Type, Leave_Date, leave_Status, prof) 
              VALUES (:users_id, :employee_id, :leave_Type, :leave_date, 'pending', :prof)";
    
    $leave_ids = [];
    foreach ($dates as $leave_date) {
        $stmt = $pdo->prepare($query);
        $stmt->bindValue(":users_id", $users_id, PDO::PARAM_INT);
        $stmt->bindValue(":employee_id", $employee_id);
        $stmt->bindValue(":leave_Type", $leave_Type);
        $stmt->bindValue(":leave_date", $leave_date);
        $stmt->bindValue(":prof", $prof);
        
        if (!$stmt->execute()) {
            echo json_encode(["success" => false, "message" => "Failed to insert leave date: $leave_date"]);
            return;
        }

        $leave_ids[] = $pdo->lastInsertId();
    }

    if (count($leave_ids) > 0) {
        $query = "INSERT INTO leave_approved (leave_id) VALUES (:leave_id)";
        $stmt = $pdo->prepare($query);

        foreach ($leave_ids as $leave_id) {
            $stmt->bindValue(":leave_id", $leave_id, PDO::PARAM_INT);
            if (!$stmt->execute()) {
                echo json_encode(["success" => false, "message" => "Failed to insert into leave_approved."]);
                return;
            }
        }
    }
$query = "";
$date_count = count($dates);  

switch ($leave_Type) {
case "Breavement":
    $query = "UPDATE leave_counts SET Breavement = Breavement - :date_count WHERE users_id = :users_id";
    break;
case "Maternity":
    $query = "UPDATE leave_counts SET Maternity = Maternity - :date_count WHERE users_id = :users_id";
    break;
case "Paternity":
    $query = "UPDATE leave_counts SET Paternity = Paternity - :date_count WHERE users_id = :users_id";
    break;
case "Sick":
    $query = "UPDATE leave_counts SET Sick = Sick - :date_count WHERE users_id = :users_id";
    break;
case "Vacation":
    $query = "UPDATE leave_counts SET Vacation = Vacation - :date_count WHERE users_id = :users_id";
    break;
case "Wedding":
    $query = "UPDATE leave_counts SET Wedding = Wedding - :date_count WHERE users_id = :users_id";
    break;
default:
    echo json_encode(["success" => false, "message" => "Invalid leave type."]);
    return;
} 

$stmt = $pdo->prepare($query);
$stmt->bindParam(":users_id", $users_id, PDO::PARAM_INT);
$stmt->bindValue(":date_count", $date_count, PDO::PARAM_INT); 

if (!$stmt->execute()) {
    echo json_encode(["success" => false, "message" => "Failed to update leave count."]);
    return;
}

    
        echo json_encode(["success" => true, "message" => "All leave dates inserted and approved successfully."]);
    }
    
    
    
    


// ========================= END OF MARCO CONTROLS =============================== //


?>