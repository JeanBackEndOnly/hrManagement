<?php
include "../installer/config.php";

function initInstaller() {
    $pdo = db_connection(); 

    try {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE user_role = :user_role");
        $stmt->execute(['user_role' => 'administrator']);
        $admins = $stmt->fetchAll();

        $currentUrl = $_SERVER['REQUEST_URI'];
        $installerPath = "/github/hrManagement/installer/";

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

function base_url() {
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https' : 'http';
    
    $server_name = $_SERVER['SERVER_NAME']; 
    
    if (in_array($server_name, ['127.0.0.1', '::1', 'localhost'])) {
        return $protocol . '://' . $server_name . '/github/hrManagement/'; 
    }
    
    return $protocol . '://' . $server_name . '/'; 
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
    base_url() . 'assets/js/main2.js',
    base_url() . 'assets/js/hr/hrmain.js',
    base_url() . 'assets/js/service-worker.js'
    ];

    foreach($scripts as $script){
        echo '<script type="text/javascript" src="' . $script . '"></script>';
    }

}

function save_user($args = [], $user_id = 0) {
    $conn = db_connection();

    try {
        if (!$user_id) {
            $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
            $stmt->execute([$args['username']]);
            if ($stmt->rowCount() > 0) {
                return ['is_error' => true, 'message' => 'Username already exists'];
            }

            $columns = implode(', ', array_keys($args));
            $placeholders = implode(', ', array_map(fn($key) => ":$key", array_keys($args)));

            $sql = "INSERT INTO users ($columns) VALUES ($placeholders)";
            $stmt = $conn->prepare($sql);
            $stmt->execute($args);
        } else {
            $setPart = implode(', ', array_map(fn($key) => "$key = :$key", array_keys($args)));
            $sql = "UPDATE users SET $setPart WHERE id = :id";
            $args['id'] = $user_id;
            $stmt = $conn->prepare($sql);
            $stmt->execute($args);
        }

        return ['is_error' => false, 'message' => 'User saved successfully'];
    } catch (PDOException $e) {
        return ['is_error' => true, 'message' => 'DB Error: ' . $e->getMessage()];
    }
}

// =================================== LOGIN =================================== //

function empty_inputs($username, $password){
    if(empty($username) || empty($password)){
        return true;
    }else{
        return false;
    }
}
function wrong_password(string $inputPassword, string $hashedPassword): bool {
    return !password_verify($inputPassword, $hashedPassword);
}

// ======================= SIGN-UP ====================================//

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
function user_inputs(
    $lname, $fname, $mname,
    $employeeID, $jobTitle, $slary_rate,
    // $salary_Range_From, $salary_Range_To, $salary,
    $citizenship, $gender, $civil_status, $birthday, $contact, $email,
    $secheduleFrom, $scheduleTo,
    $street, $barangay, $city_muntinlupa, $province, $zipCode,
    $username, $password, $confirmPassword
    ) {
    if (
        empty($lname) || empty($fname) || empty($mname) ||
        empty($employeeID) || empty($jobTitle) || empty($slary_rate) ||
        // empty($salary_Range_From) || empty($salary_Range_To) || empty($salary) ||
        empty($citizenship) || empty($gender) || empty($civil_status) ||
        empty($birthday) || empty($contact) || empty($email) ||
        empty($secheduleFrom) || empty($scheduleTo) ||
        empty($street) || empty($barangay) || empty($city_muntinlupa) ||
        empty($province) || empty($zipCode) ||
        empty($username) || empty($password) || empty($confirmPassword)
    ) {
        return true;
    } else {
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
function email_registered(object $pdo, string $email){
   if(get_email($pdo, $email)) {
        return true;
   }else{
        return false;
   }
}
function email_registeredUpdate($pdo, $email, $current_user_id) {
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM userInformations WHERE email = ? AND users_id != ?");
    $stmt->execute([$email, $current_user_id]);
    return $stmt->fetchColumn() > 0;
}

function password_notMatch(string $confirmPassword, string $hashedPassword){
    if($confirmPassword !== $hashedPassword){
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
function emp_info(
    $pdo, 
    $id, 
    $lname, 
    $fname, 
    $mname, 
    $employeeID, 
    $department, 
    $jobTitle, 
    $slary_rate, 
    // $salary_Range_From, 
    // $salary_Range_To, 
    // $salary, 
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
    $profile
    ) {
    $query = "INSERT INTO userInformations (
        users_id, lname, fname, mname, employeeID, department, jobTitle, slary_rate, 
        -- salary_Range_From, salary_Range_To, salary, 
        citizenship, gender, civil_status, 
        religion, age, birthday, birthPlace, contact, email, secheduleFrom, scheduleTo, 
        houseBlock, street, subdivision, barangay, city_muntinlupa, province, zip_code, 
        user_profile
    ) VALUES (
        :users_id, :lname, :fname, :mname, :employeeID, :department, :jobTitle, :slary_rate, 
        -- :salary_Range_From, :salary_Range_To, :salary,
        :citizenship, :gender, :civil_status, 
        :religion, :age, :birthday, :birthPlace, :contact, :email, :secheduleFrom, :scheduleTo, 
        :houseBlock, :street, :subdivision, :barangay, :city_muntinlupa, :province, :zip_code, 
        :user_profile
    );";

    $stmt = $pdo->prepare($query);

    $stmt->bindParam(":users_id", $id);
    $stmt->bindParam(":lname", $lname);
    $stmt->bindParam(":fname", $fname);
    $stmt->bindParam(":mname", $mname);
    $stmt->bindParam(":employeeID", $employeeID);
    $stmt->bindParam(":department", $department);
    $stmt->bindParam(":jobTitle", $jobTitle);
    $stmt->bindParam(":slary_rate", $slary_rate);
    // $stmt->bindParam(":salary_Range_From", $salary_Range_From);
    // $stmt->bindParam(":salary_Range_To", $salary_Range_To);
    // $stmt->bindParam(":salary", $salary);
    $stmt->bindParam(":citizenship", $citizenship);
    $stmt->bindParam(":gender", $gender);
    $stmt->bindParam(":civil_status", $civil_status);
    $stmt->bindParam(":religion", $religion);
    $stmt->bindParam(":age", $age);
    $stmt->bindParam(":birthday", $birthday);
    $stmt->bindParam(":birthPlace", $birthPlace);
    $stmt->bindParam(":contact", $contact);
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":secheduleFrom", $secheduleFrom);
    $stmt->bindParam(":scheduleTo", $scheduleTo);
    $stmt->bindParam(":houseBlock", $houseBlock);
    $stmt->bindParam(":street", $street);
    $stmt->bindParam(":subdivision", $subdivision);
    $stmt->bindParam(":barangay", $barangay);
    $stmt->bindParam(":city_muntinlupa", $city_muntinlupa);
    $stmt->bindParam(":province", $province);
    $stmt->bindParam(":zip_code", $zipCode);
    $stmt->bindParam(":user_profile", $profile);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Employee added successfully."]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to add employee."]);
    }
}
function emp_infoReqUpdate(
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
    ) {
    $query = "UPDATE userInformations SET
        lname = :lname,
        fname = :fname,
        mname = :mname,
        suffix = :suffix,
        employeeID = :employeeID,
        department = :department,
        jobTitle = :jobTitle,
        slary_rate = :slary_rate,
        salary_Range_From = :salary_Range_From,
        salary_Range_To = :salary_Range_To,
        salary = :salary,
        citizenship = :citizenship,
        gender = :gender,
        civil_status = :civil_status,
        religion = :religion,
        age = :age,
        birthday = :birthday,
        birthPlace = :birthPlace,
        contact = :contact,
        email = :email,
        secheduleFrom = :secheduleFrom,
        scheduleTo = :scheduleTo,
        houseBlock = :houseBlock,
        street = :street,
        subdivision = :subdivision,
        barangay = :barangay,
        city_muntinlupa = :city_muntinlupa,
        province = :province,
        zip_code = :zip_code,
        user_profile = :user_profile
        WHERE users_id = :users_id";

    $stmt = $pdo->prepare($query);

    $stmt->bindParam(":users_id", $users_id);
    $stmt->bindParam(":lname", $lname);
    $stmt->bindParam(":fname", $fname);
    $stmt->bindParam(":mname", $mname);
    $stmt->bindParam(":suffix", $suffix);
    $stmt->bindParam(":employeeID", $employeeID);
    $stmt->bindParam(":department", $department);
    $stmt->bindParam(":jobTitle", $jobTitle);
    $stmt->bindParam(":slary_rate", $salary_rate);
    $stmt->bindParam(":salary_Range_From", $salary_Range_From);
    $stmt->bindParam(":salary_Range_To", $salary_Range_To);
    $stmt->bindParam(":salary", $salary);
    $stmt->bindParam(":citizenship", $citizenship);
    $stmt->bindParam(":gender", $gender);
    $stmt->bindParam(":civil_status", $civil_status);
    $stmt->bindParam(":religion", $religion);
    $stmt->bindParam(":age", $age);
    $stmt->bindParam(":birthday", $birthday);
    $stmt->bindParam(":birthPlace", $birthPlace);
    $stmt->bindParam(":contact", $contact);
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":secheduleFrom", $scheduleFrom);
    $stmt->bindParam(":scheduleTo", $scheduleTo);
    $stmt->bindParam(":houseBlock", $houseBlock);
    $stmt->bindParam(":street", $street);
    $stmt->bindParam(":subdivision", $subdivision);
    $stmt->bindParam(":barangay", $barangay);
    $stmt->bindParam(":city_muntinlupa", $city_muntinlupa);
    $stmt->bindParam(":province", $province);
    $stmt->bindParam(":zip_code", $zipCode);
    $stmt->bindParam(":user_profile", $profile);

    $stmt->execute();
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
function requestAdmin(object $pdo, int $id) {
    $adminStatus = "validated";
    $query = "INSERT INTO userRequest (users_id, status)
    VALUES (:users_id, :status);";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":users_id", $id, PDO::PARAM_INT);
    $stmt->bindParam(":status", $adminStatus);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "User inserted successfully."]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to insert user."]);
    }
}
// =============================== JOB TITLE =========================== //
function JobTitleExist(object $pdo, string $jobTitle){
    if(getJobTitle($pdo, $jobTitle)){
        return true;
    }else{
        return false;
    }
}
// ========== INSERT TO DATABASE ========== //
function employeeRegistration(
    object $pdo,
    string $lname,
    string $fname,
    string $mname,
    string $employeeID,
    string $department,
    string $jobTitle,
    string $slary_rate,
    // string $salary_Range_From,
    // string $salary_Range_To,
    // string $salary,
    string $citizenship,
    string $gender,
    string $civil_status,
    string $religion,
    string $age,
    string $birthday,
    string $birthPlace,
    string $contact,
    string $email,
    string $secheduleFrom,
    string $scheduleTo,
    string $houseBlock,
    string $street,
    string $subdivision,
    string $barangay,
    string $city_muntinlupa,
    string $province,
    string $zipCode,
    string $profile,
    string $username,
    string $password
 ) {
    // $salary_Range_From = (int)$salary_Range_From;
    // $salary_Range_To = (int)$salary_Range_To;
    $id = getUser_account($pdo, $username, $password);

    emp_info(
        $pdo,
        $id,
        $lname,
        $fname,
        $mname,
        $employeeID,
        $department,
        $jobTitle,
        $slary_rate,
        // $salary_Range_From,
        // $salary_Range_To,
        // $salary,
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
    );

    request($pdo, $id);
}
function adminRegistration(
    object $pdo,
    string $lname,
    string $fname,
    string $mname,
    string $employeeID,
    string $department,
    string $jobTitle,
    string $slary_rate,
    string $salary_Range_From,
    string $salary_Range_To,
    string $salary,
    string $citizenship,
    string $gender,
    string $civil_status,
    string $religion,
    string $age,
    string $birthday,
    string $birthPlace,
    string $contact,
    string $email,
    string $secheduleFrom,
    string $scheduleTo,
    string $houseBlock,
    string $street,
    string $subdivision,
    string $barangay,
    string $city_muntinlupa,
    string $province,
    string $zipCode,
    string $profile,
    string $username,
    string $password
 ) {
    $salary_Range_From = (int)$salary_Range_From;
    $salary_Range_To = (int)$salary_Range_To;
    $id = getUser_account($pdo, $username, $password);

    emp_info(
        $pdo,
        $id,
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
    );

    requestAdmin($pdo, $id);

    return $pdo->lastInsertId();
}
function updateReq(
    object $pdo,
    int $users_id,
    string $lname,
    string $fname,
    string $mname,
    string $suffix,
    string $employeeID,
    string $department,
    string $jobTitle,
    string $salary_rate,
    string $salary_Range_From,
    string $salary_Range_To,
    string $salary,
    string $citizenship,
    string $gender,
    string $civil_status,
    string $religion,
    string $age,
    string $birthday,
    string $birthPlace,
    string $contact,
    string $email,
    string $scheduleFrom,
    string $scheduleTo,
    string $houseBlock,
    string $street,
    string $subdivision,
    string $barangay,
    string $city_muntinlupa,
    string $province,
    string $zipCode,
    string $profile
    ) {
    emp_infoReqUpdate(
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
        (int)$salary_Range_From,
        (int)$salary_Range_To,
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
}

