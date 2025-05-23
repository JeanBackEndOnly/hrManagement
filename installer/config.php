<?php

function db_connect()
{
    $host = 'localhost';
    $username = 'root';
    $password = '';
    $database = 'puericulture_db';

    try {
        $pdo = new PDO("mysql:host=$host;charset=utf8mb4", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $pdo->exec("CREATE DATABASE IF NOT EXISTS `$database` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci");

        $pdo = new PDO("mysql:host=$host;dbname=$database;charset=utf8mb4", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $tableQueries = [
            "CREATE TABLE IF NOT EXISTS users (
                id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                username VARCHAR(50) NOT NULL,
                password VARCHAR(255) NOT NULL,
                user_role VARCHAR(20) NOT NULL,
                created_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            )",
            "CREATE TABLE IF NOT EXISTS admin (
                id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                firstname VARCHAR(50) NOT NULL,
                middlename VARCHAR(50) NOT NULL,
                lastname VARCHAR(50) NOT NULL,
                email VARCHAR(100) NOT NULL,
                username VARCHAR(50) NOT NULL,
                password VARCHAR(255) NOT NULL,
                user_role VARCHAR(20) NOT NULL,
                created_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            )",
            "CREATE TABLE IF NOT EXISTS options(
                id INT(6) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                meta_key LONGTEXT NOT NULL,
                meta_value LONGTEXT NULL
            )",
            "CREATE TABLE IF NOT EXISTS personal_information(
                id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                users_id INT NOT NULL,
                suffix VARCHAR(5),
                sex VARCHAR(6) NOT NULL,
                date_of_birth DATE NOT NULL,
                place_of_birth TEXT NOT NULL,
                telephone_no VARCHAR(20),
                mobile_no VARCHAR(20),
                civil_status VARCHAR(20) NOT NULL,
                height VARCHAR(15),
                weight VARCHAR(15),
                blood_type VARCHAR(5),
                gsis_id_no VARCHAR(25),
                pagibig_id_no VARCHAR(25),
                philhealth_no VARCHAR(25),
                sss_no VARCHAR(25),
                tin_no VARCHAR(25),
                agency_no VARCHAR(25),
                citizenship VARCHAR(30) NOT NULL,
                house_block VARCHAR(30),
                street TEXT,
                subdivision TEXT,
                barangay VARCHAR(30),
                city_muntinlupa VARCHAR(30),
                province VARCHAR(30),
                zip_code VARCHAR(10),
                perma_house_block VARCHAR(30),
                perma_street TEXT,
                perma_subdivision TEXT,
                perma_barangay VARCHAR(30),
                perma_city_muntinlupa VARCHAR(30),
                perma_province VARCHAR(30),
                perma_zip_code VARCHAR(10),
                
                fbspouse_surname TEXT,
                fbfirst_name TEXT,
                fbmiddle_name TEXT,
                fbname_extension VARCHAR(5),
                fboccupation TEXT,
                fbemployer_name TEXT,
                fbbusiness_address TEXT,
                fbspouseTelephone_no VARCHAR(20),
                
                fbfather_surname TEXT,
                fbfather_first_name TEXT,
                fbfather_middle_name TEXT,
                fbfather_name_extension VARCHAR(5),
                
                fbmother_surname TEXT,
                fbmother_first_name TEXT,
                fbmother_middle_name TEXT,
                
                fbname_of_children TEXT,
                fbchildren_date_of_birth TEXT,
                
                eblevel TEXT,
                ebname_of_school TEXT,
                ebbasic_education TEXT,
                ebattendance_from VARCHAR(30),
                ebattendance_to VARCHAR(30),
                ebhighest_level TEXT,
                ebyear_graduate VARCHAR(30),
                ebhonors_recieved TEXT,
                
                csecareeservice TEXT,
                cserating VARCHAR(20),
                csedate_of_exam VARCHAR(30),
                cseplace_of_exam TEXT,
                cselicence_number VARCHAR(50),
                cselicense_date VARCHAR(50),
                
                vwname_address_org TEXT,
                vwinclusive_date_from VARCHAR(30),
                vwinclusive_date_to VARCHAR(30),
                vwnumber_of_hours VARCHAR(5),
                vwposition_of_work TEXT,
                
                LaDtitle TEXT,
                LaDinclusive_date_from VARCHAR(30),
                LaDinclusive_date_to VARCHAR(30),
                LaDnumber_of_hours VARCHAR(5),
                LaDtype_of_ld TEXT,
                LaDconducted_by TEXT,
                
                oiSKaH TEXT,
                oirecognition TEXT,
                oimembership TEXT,
                
                first_a VARCHAR(10),
                first_a_yes TEXT,
                first_b VARCHAR(10),
                first_b_yes TEXT,
                
                second_a VARCHAR(10),
                second_a_yes TEXT,
                second_b VARCHAR(10),
                second_b_yes TEXT,
                
                thirty_six VARCHAR(10),
                thirty_six_yes TEXT,
                
                thirty_seven VARCHAR(10),
                thirty_seven_yes TEXT,
                
                third_a VARCHAR(10),
                third_a_yes TEXT,
                third_b VARCHAR(10),
                third_b_yes TEXT,
                
                thirty_eigth VARCHAR(10),
                thirty_eight_yes TEXT,
                
                thirty_nine VARCHAR(10),
                third_nine_yes TEXT,
                
                fourthy VARCHAR(10),
                fourthy_yes TEXT,
                
                fourth_a VARCHAR(10),
                fourth_a_yes TEXT,
                fourth_b VARCHAR(10),
                fourth_b_yes TEXT,
                fourth_c VARCHAR(10),
                fourth_c_yes TEXT,
                
                FOREIGN KEY (users_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE
            ) ROW_FORMAT=DYNAMIC;",
            "CREATE TABLE IF NOT EXISTS userRequest(
                id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                users_id INT(11) NOT NULL,
                status VARCHAR(20) NOT NULL,
                approved_at datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                declined_at datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (users_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE
            )",
            "CREATE TABLE IF NOT EXISTS department(
                id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                users_id INT(11) NOT NULL,
                department VARCHAR(50) NOT NULL,
                created_at datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (users_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE
            )",
            "CREATE TABLE IF NOT EXISTS designation(
                id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                users_id INT(11) NOT NULL,
                designation VARCHAR(50) NOT NULL,
                created_at datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (users_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE
            )",
            "CREATE TABLE IF NOT EXISTS signup_information(
                id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                users_id INT NOT NULL,
                user_profile VARCHAR(255),
                email VARCHAR(255) NOT NULL,
                Lname VARCHAR(100) NOT NULL,
                Fname VARCHAR(150) NOT NULL,
                Mname VARCHAR(150) NOT NULL,
                suffix VARCHAR(150),
                FOREIGN KEY (users_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE
            )",
            "CREATE TABLE IF NOT EXISTS AddByAdmin(
                id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                users_id INT(11) NOT NULL,
                employeeID VARCHAR(50) NOT NULL,
                rateType VARCHAR(50) NOT NULL,
                salary_Range_From DECIMAL(10,2) NOT NULL,
                salary_Range_To DECIMAL(10,2) NOT NULL,
                schedule_from VARCHAR(10) NOT NULL,
                schedule_to VARCHAR(10) NOT NULL,
                job_Title VARCHAR(50) NOT NULL,
                age VARCHAR(50),
                gender VARCHAR(50) NOT NULL,
                civil_Status VARCHAR(50),
                Religion VARCHAR(50),
                birthday VARCHAR(50),
                birth_Place VARCHAR(50),
                Citizenship VARCHAR(50) NOT NULL,
                Contact_No VARCHAR(50) NOT NULL,
                house_block VARCHAR(50),
                street VARCHAR(50) NOT NULL,
                subdivision VARCHAR(50),
                barangay VARCHAR(50) NOT NULL,
                city_muntinlupa VARCHAR(50) NOT NULL,
                province VARCHAR(50) NOT NULL,
                zip_code VARCHAR(10) NOT NULL,
                add_at datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (users_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE
            )",
            "CREATE TABLE IF NOT EXISTS user_status(
                id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                users_id INT(11) NOT NULL,
                Logged_in VARCHAR(10) NOT NULL,
                logged_out VARCHAR(10) NOT NULL,
                inOut_at DATE NOT NULL DEFAULT CURRENT_DATE,
                FOREIGN KEY (users_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE
            )",
            "CREATE TABLE IF NOT EXISTS jobs(
                id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                jobs VARCHAR(50) NOT NULL,
                created_at datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
            )",
            "CREATE TABLE IF NOT EXISTS leaveA(
                leaveID INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                users_id INT(11) NOT NULL,
                prof VARCHAR(255) NOT NULL,
                employee_id VARCHAR(20) NOT NULL,
                leave_Type VARCHAR(10) NOT NULL,
                Leave_Date VARCHAR(10) NOT NULL,
                leave_Status VARCHAR(10),
                request_at DATE NOT NULL DEFAULT CURRENT_DATE,
                FOREIGN KEY (users_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE
            )",
            "CREATE TABLE IF NOT EXISTS leave_approved(
                id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                leave_id INT(11) NOT NULL,
                approved_at date NOT NULL DEFAULT CURRENT_DATE,
                FOREIGN KEY (leave_id) REFERENCES leaveA(leaveID) ON DELETE CASCADE ON UPDATE CASCADE
            )",
            "CREATE TABLE IF NOT EXISTS leave_counts(
                id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                users_id INT(11) NOT NULL,
                Breavement INT(3) NOT NULL,
                Maternity  INT(3) NOT NULL,
                Paternity  INT(3) NOT NULL,
                Sick  INT(3) NOT NULL,
                Vacation  INT(3) NOT NULL,
                Wedding  INT(3) NOT NULL,
                FOREIGN KEY (users_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE
            )"
            ];
            
        foreach ($tableQueries as $sql) {
            $pdo->exec($sql);
        }

        return $pdo;

    } catch (PDOException $e) {
        die("Database error: " . $e->getMessage());
    }


}

$pdo = db_connect();
/* echo "Connected successfully with PDO.";
 */
// Close connection (optional)
$pdo = null;
