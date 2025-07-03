<?php
include __DIR__ . '/../installer/config.php';


function base_url(): string
{
    $proto = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
           ? 'https' : 'http';
    $host  = $_SERVER['HTTP_HOST'];

    $dir = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
    return "{$proto}://{$host}{$dir}/";
}

/* ---------- current page (debug helper) --------------------- */
function get_current_page(): string
{
    $proto = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    return "{$proto}://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
}

function initInstaller(): void
{
    $pdo = db_connection();
    $hasAdmin = (bool)$pdo->query("SELECT 1 FROM users WHERE user_role = 'administrator' LIMIT 1")->fetchColumn();

    $installer = '/github/hrManagement/installer/';
    $here      = $_SERVER['REQUEST_URI'];

    if (!$hasAdmin && $here !== $installer) {
        header('Location: ' . base_url() . 'installer/');
        exit;
    }
    if ($hasAdmin && $here === $installer) {
        header('Location: ' . base_url() . 'src/');
        exit;
    }
}

/* ---------- CSS & manifest tags ----------------------------- */
function render_styles(): void
{
    $base = '../';  
    foreach ([
        'assets/css/all.min.css',
        'assets/css/custom-bs.min.css',
        'assets/css/main_frontend.css',
        'assets/css/main.css',
    ] as $css) {
        echo '<link rel="stylesheet" href="' . $base . $css . '">' . PHP_EOL;
    }
    echo '<link rel="manifest" href="' . $base . 'webApp/manifest.json">' . PHP_EOL;
}

function render_scripts(): void
{
    $base = '../';  
    foreach ([
        'assets/js/jquery.min.js',
        'assets/js/main.js',
        'assets/js/perfect-scrollbar.min.js',
        'assets/js/smooth-scrollbar.min.js',
        'assets/js/sweetalert.min.js',
        'assets/js/all.min.js',
        'assets/js/bootstrap.min.js',
        'assets/js/custom-bs.js',
        'assets/js/hr/hrmain.js',
        'assets/js/EmpRes.js',
        'assets/js/login.js',
        'main.js',             
    ] as $js) {
        echo '<script src="' . $base . $js . '"></script>' . PHP_EOL;
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
function getUser_account(object $pdo, string $profile, string $username, string $password) {
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    $userRole = "employee";
    $query = "INSERT INTO users (user_profile, username, password, user_role) VALUES (:user_profile, :username, :password, :user_role);";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':user_profile', $profile);
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
    $citizenship, 
    $gender, 
    $civil_status, 
    $religion, 
    $age, 
    $birthday, 
    $birthPlace, 
    $contact, 
    $email
    ) {
    $query = "INSERT INTO userInformations (
        users_id, lname, fname, mname, citizenship, gender, civil_status, 
        religion, age, birthday, birthPlace, contact, email
    ) VALUES (
        :users_id, :lname, :fname, :mname, :citizenship, :gender, :civil_status, 
        :religion, :age, :birthday, :birthPlace, :contact, :email
    );";

    $stmt = $pdo->prepare($query);

    $stmt->bindParam(":users_id", $id);
    $stmt->bindParam(":lname", $lname);
    $stmt->bindParam(":fname", $fname);
    $stmt->bindParam(":mname", $mname);
    $stmt->bindParam(":citizenship", $citizenship);
    $stmt->bindParam(":gender", $gender);
    $stmt->bindParam(":civil_status", $civil_status);
    $stmt->bindParam(":religion", $religion);
    $stmt->bindParam(":age", $age);
    $stmt->bindParam(":birthday", $birthday);
    $stmt->bindParam(":birthPlace", $birthPlace);
    $stmt->bindParam(":contact", $contact);
    $stmt->bindParam(":email", $email);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Employee added successfully."]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to add employee."]);
    }
}
function emp_infoHr(
    $pdo, 
    $id, 
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
    $zipCode
    ) {
    
    $query = "INSERT INTO userHr_Informations (
        users_id, employeeID, department, jobTitle, slary_rate, scheduleFrom, scheduleTo, 
        houseBlock, street, subdivision, barangay, city_muntinlupa, province, zip_code
    ) VALUES (
        :users_id, :employeeID, :department, :jobTitle, :slary_rate, :scheduleFrom, :scheduleTo, 
        :houseBlock, :street, :subdivision, :barangay, :city_muntinlupa, :province, :zip_code
    );";

    $stmt = $pdo->prepare($query);

    $stmt->bindParam(":users_id", $id);
    $stmt->bindParam(":employeeID", $employeeID);
    $stmt->bindParam(":department", $department);
    $stmt->bindParam(":jobTitle", $jobTitle);
    $stmt->bindParam(":slary_rate", $slary_rate);
    $stmt->bindParam(":scheduleFrom", $scheduleFrom);
    $stmt->bindParam(":scheduleTo", $scheduleTo);
    $stmt->bindParam(":houseBlock", $houseBlock);
    $stmt->bindParam(":street", $street);
    $stmt->bindParam(":subdivision", $subdivision);
    $stmt->bindParam(":barangay", $barangay);
    $stmt->bindParam(":city_muntinlupa", $city_muntinlupa);
    $stmt->bindParam(":province", $province);
    $stmt->bindParam(":zip_code", $zipCode);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Employee added successfully."]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to add employee."]);
    }
}
function emp_infoAdmin(
    $pdo, 
    $id, 
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
    ) {
    $query = "INSERT INTO userInformations (
        users_id, lname, fname, mname, citizenship, gender, civil_status, 
        religion, age, birthday, birthPlace, contact, email
        ) VALUES (
            :users_id, :lname, :fname, :mname, :citizenship, :gender, :civil_status, 
            :religion, :age, :birthday, :birthPlace, :contact, :email
        );";

        $stmt = $pdo->prepare($query);

        $stmt->bindParam(":users_id", $id);
        $stmt->bindParam(":lname", $lname);
        $stmt->bindParam(":fname", $fname);
        $stmt->bindParam(":mname", $mname);
        $stmt->bindParam(":citizenship", $citizenship);
        $stmt->bindParam(":gender", $gender);
        $stmt->bindParam(":civil_status", $civil_status);
        $stmt->bindParam(":religion", $religion);
        $stmt->bindParam(":age", $age);
        $stmt->bindParam(":birthday", $birthday);
        $stmt->bindParam(":birthPlace", $birthPlace);
        $stmt->bindParam(":contact", $contact);
        $stmt->bindParam(":email", $email);

        $stmt->execute();
}
function emp_infoAdminHr(
    $pdo, 
    $id, 
    $employeeID, 
    $department, 
    $jobTitle, 
    $slary_rate, 
    $salary_Range_From, 
    $salary_Range_To, 
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
    ) {

    $query = "INSERT INTO userHr_Informations (
        users_id, employeeID, department, jobTitle, slary_rate, 
        salary_Range_From, salary_Range_To, salary, scheduleFrom, scheduleTo, 
        houseBlock, street, subdivision, barangay, city_muntinlupa, province, zip_code

    ) VALUES (
        :users_id, :employeeID, :department, :jobTitle, :slary_rate, 
        :salary_Range_From, :salary_Range_To, :salary, :scheduleFrom, :scheduleTo, 
        :houseBlock, :street, :subdivision, :barangay, :city_muntinlupa, :province, :zip_code

    );";

    $stmt = $pdo->prepare($query);

    $stmt->bindParam(":users_id", $id);
    $stmt->bindParam(":employeeID", $employeeID);
    $stmt->bindParam(":department", $department);
    $stmt->bindParam(":jobTitle", $jobTitle);
    $stmt->bindParam(":slary_rate", $slary_rate);
    $stmt->bindParam(":salary_Range_From", $salary_Range_From);
    $stmt->bindParam(":salary_Range_To", $salary_Range_To);
    $stmt->bindParam(":salary", $salary);
    $stmt->bindParam(":scheduleFrom", $scheduleFrom);
    $stmt->bindParam(":scheduleTo", $scheduleTo);
    $stmt->bindParam(":houseBlock", $houseBlock);
    $stmt->bindParam(":street", $street);
    $stmt->bindParam(":subdivision", $subdivision);
    $stmt->bindParam(":barangay", $barangay);
    $stmt->bindParam(":city_muntinlupa", $city_muntinlupa);
    $stmt->bindParam(":province", $province);
    $stmt->bindParam(":zip_code", $zipCode);
    $stmt->execute();
}
function emp_infoReqUpdate(
    $pdo,
    $users_id,
    $lname,
    $fname,
    $mname,
    $suffix,
    $citizenship,
    $gender,
    $civil_status,
    $religion,
    $age,
    $birthday,
    $birthPlace,
    $contact,
    $email
    ) {
    $query = "UPDATE userInformations SET
        lname = :lname,
        fname = :fname,
        mname = :mname,
        suffix = :suffix,
        citizenship = :citizenship,
        gender = :gender,
        civil_status = :civil_status,
        religion = :religion,
        age = :age,
        birthday = :birthday,
        birthPlace = :birthPlace,
        contact = :contact,
        email = :email
        WHERE users_id = :users_id";

    $stmt = $pdo->prepare($query);

    $stmt->bindParam(":users_id", $users_id);
    $stmt->bindParam(":lname", $lname);
    $stmt->bindParam(":fname", $fname);
    $stmt->bindParam(":mname", $mname);
    $stmt->bindParam(":suffix", $suffix);
    $stmt->bindParam(":citizenship", $citizenship);
    $stmt->bindParam(":gender", $gender);
    $stmt->bindParam(":civil_status", $civil_status);
    $stmt->bindParam(":religion", $religion);
    $stmt->bindParam(":age", $age);
    $stmt->bindParam(":birthday", $birthday);
    $stmt->bindParam(":birthPlace", $birthPlace);
    $stmt->bindParam(":contact", $contact);
    $stmt->bindParam(":email", $email);

    $stmt->execute();
}
function emp_infoReqUpdateHr(
    $pdo,
    $users_id,
    $employeeID,
    $department,
    $jobTitle,
    $salary_rate,
    $salary_Range_From,
    $salary_Range_To,
    $salary,
    $scheduleFrom,
    $scheduleTo,
    $houseBlock,
    $street,
    $subdivision,
    $barangay,
    $city_muntinlupa,
    $province,
    $zipCode
    ) {

    $query = "UPDATE userHr_Informations SET
        employeeID = :employeeID,
        department = :department,
        jobTitle = :jobTitle,
        slary_rate = :slary_rate,
        salary_Range_From = :salary_Range_From,
        salary_Range_To = :salary_Range_To,
        salary = :salary,
        scheduleFrom = :scheduleFrom,
        scheduleTo = :scheduleTo,
        houseBlock = :houseBlock,
        street = :street,
        subdivision = :subdivision,
        barangay = :barangay,
        city_muntinlupa = :city_muntinlupa,
        province = :province,
        zip_code = :zip_code
        WHERE users_id = :users_id";

    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":users_id", $users_id);
    $stmt->bindParam(":employeeID", $employeeID);
    $stmt->bindParam(":department", $department);
    $stmt->bindParam(":jobTitle", $jobTitle);
    $stmt->bindParam(":slary_rate", $salary_rate);
    $stmt->bindParam(":salary_Range_From", $salary_Range_From);
    $stmt->bindParam(":salary_Range_To", $salary_Range_To);
    $stmt->bindParam(":salary", $salary);
    $stmt->bindParam(":scheduleFrom", $scheduleFrom);
    $stmt->bindParam(":scheduleTo", $scheduleTo);
    $stmt->bindParam(":houseBlock", $houseBlock);
    $stmt->bindParam(":street", $street);
    $stmt->bindParam(":subdivision", $subdivision);
    $stmt->bindParam(":barangay", $barangay);
    $stmt->bindParam(":city_muntinlupa", $city_muntinlupa);
    $stmt->bindParam(":province", $province);
    $stmt->bindParam(":zip_code", $zipCode);

    $stmt->execute();
}

function emp_infoReqUpdatePp(
    $pdo,
    $users_id,
    $profile
    ) {
    $query = "UPDATE users SET user_profile = :user_profile WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $users_id);
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
    string $citizenship,
    string $gender,
    string $civil_status,
    string $religion,
    string $age,
    string $birthday,
    string $birthPlace,
    string $contact,
    string $email,
    string $slary_rate,
    string $employeeID,
    string $department,
    string $jobTitle,
    string $scheduleFrom,
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
    $id = getUser_account($pdo, $profile, $username, $password);
    emp_info(
        $pdo, 
        $id, 
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
        $email
    );
    emp_infoHr(
       $pdo, 
        $id, 
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
        $zipCode
    );

    request($pdo, $id);

    // return $pdo->lastInsertId();
    return $id;
}
function adminRegistration(
    object $pdo,
    string $lname,
    string $fname,
    string $mname,
    string $citizenship,
    string $gender,
    string $civil_status,
    string $religion,
    string $age,
    string $birthday,
    string $birthPlace,
    string $contact,
    string $email,
    string $slary_rate,
    string $salary_Range_From,
    string $salary_Range_To,
    string $employeeID,
    string $department,
    string $jobTitle,
    string $salary,
    string $scheduleFrom,
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
    $id = getUser_account($pdo, $profile, $username, $password);

    emp_infoAdmin(
        $pdo, 
        $id, 
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
    );
    emp_infoAdminHr(
        $pdo, 
        $id, 
        $employeeID, 
        $department, 
        $jobTitle, 
        $slary_rate, 
        $salary_Range_From, 
        $salary_Range_To, 
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
        $citizenship,
        $gender,
        $civil_status,
        $religion,
        $age,
        $birthday,
        $birthPlace,
        $contact,
        $email,
    );
    emp_infoReqUpdateHr(
        $pdo,
        $users_id,
        $employeeID,
        $department,
        $jobTitle,
        $salary_rate,
        $salary_Range_From,
        $salary_Range_To,
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
    );
    emp_infoReqUpdatePp(
        $pdo,
        $users_id,
        $profile
    );

     return true;
}

