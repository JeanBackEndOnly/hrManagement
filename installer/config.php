<?php
if (!function_exists('db_connection')) {
    function db_connection()
    {
        static $pdo = null;
        if ($pdo !== null) return $pdo;

        $host = 'localhost';
        $username = 'root';
        $password = '';
        $database = 'hrPuericulture';

        try {
            // Step 1: Connect without selecting a DB
            $pdoTemp = new PDO("mysql:host=$host;charset=utf8mb4", $username, $password);
            $pdoTemp->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Step 2: Create database if it doesn't exist
            $pdoTemp->exec("CREATE DATABASE IF NOT EXISTS `$database` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci");

            // Step 3: Connect to the newly created DB
            $pdo = new PDO("mysql:host=$host;dbname=$database;charset=utf8mb4", $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Step 4: Create all tables
            $tableQueries = [
                "CREATE TABLE IF NOT EXISTS users (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    username VARCHAR(255) NOT NULL UNIQUE,
                    password VARCHAR(255) NOT NULL,
                    email VARCHAR(255) NOT NULL,
                    user_role VARCHAR(50) NOT NULL,
                    subRole VARCHAR(50) NOT NULL,
                    user_profile BLOB,
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                )",
                "CREATE TABLE IF NOT EXISTS userInformations(
                id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                users_id INT(11) NOT NULL,
                lname VARCHAR(100) NOT NULL,
                fname VARCHAR(150) NOT NULL,
                mname VARCHAR(150) NOT NULL,
                nickname VARCHAR(7),
                suffix VARCHAR(6),
                citizenship VARCHAR(50) NOT NULL,
                gender VARCHAR(50) NOT NULL,
                civil_status VARCHAR(50) NOT NULL,
                religion VARCHAR(50),
                age VARCHAR(50),
                birthday VARCHAR(50) NOT NULL,
                birthPlace VARCHAR(50),
                contact VARCHAR(50) NOT NULL,
                email VARCHAR(50) NOT NULL,
                add_at datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (users_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE
            )",
            "CREATE TABLE IF NOT EXISTS userHr_Informations(
                id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                users_id INT(11) NOT NULL,
                slary_rate VARCHAR(10) NOT NULL,
                salary_Range_From DECIMAL(12,2) NOT NULL,
                salary_Range_To DECIMAL(12,2) NOT NULL,
                employeeID VARCHAR(150) NOT NULL,
                department VARCHAR(50) NOT NULL,
                jobTitle VARCHAR(50) NOT NULL,
                salary DECIMAL(10,2) NOT NULL,
                scheduleFrom VARCHAR(255) NOT NULL,
                scheduleTo VARCHAR(50) NOT NULL,
                houseBlock VARCHAR(50),
                street VARCHAR(50) NOT NULL,
                subdivision VARCHAR(50),
                barangay VARCHAR(50) NOT NULL,
                city_muntinlupa VARCHAR(50) NOT NULL,
                province VARCHAR(50) NOT NULL,
                zip_code VARCHAR(10) NOT NULL,
                FOREIGN KEY (users_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE
            )",
            "CREATE TABLE IF NOT EXISTS personal_data_sheet (
                pds_id           INT AUTO_INCREMENT PRIMARY KEY,
                users_id      INT NOT NULL,             
                accomplished_on DATE NOT NULL DEFAULT CURRENT_DATE,
                FOREIGN KEY (users_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE
            );",
            "CREATE TABLE IF NOT EXISTS userGovIDs (
                id           INT AUTO_INCREMENT PRIMARY KEY,
                pds_id INT NOT NULL,
                sss_no         VARCHAR(30),
                tin_no         VARCHAR(30),
                pagibig_no     VARCHAR(30),
                philhealth_no  VARCHAR(30),
                FOREIGN KEY (pds_id) REFERENCES personal_data_sheet(pds_id)
                ON DELETE CASCADE ON UPDATE CASCADE
            )",
            "CREATE TABLE IF NOT EXISTS spouseInfo (
                id              INT(11)      NOT NULL AUTO_INCREMENT PRIMARY KEY,
                pds_id        INT(11)      NOT NULL,
                spouse_surname  VARCHAR(60),
                spouse_first    VARCHAR(60),
                spouse_middle   VARCHAR(60),
                spouse_occupation      VARCHAR(80),
                spouse_employer        VARCHAR(120),
                spouse_business_address   VARCHAR(255),
                spouse_tel    VARCHAR(30),
                FOREIGN KEY (pds_id) REFERENCES personal_data_sheet(pds_id)
                ON DELETE CASCADE ON UPDATE CASCADE
            )",

            "CREATE TABLE IF NOT EXISTS children (
                id          INT(11)      NOT NULL AUTO_INCREMENT PRIMARY KEY,
                pds_id    INT(11)      NOT NULL,
                full_name   VARCHAR(120),
                dob         DATE,
                FOREIGN KEY (pds_id) REFERENCES personal_data_sheet(pds_id)
                ON DELETE CASCADE ON UPDATE CASCADE,
                INDEX idx_child_user (pds_id)
            )",

            "CREATE TABLE IF NOT EXISTS parents (
                id           INT(11)      NOT NULL AUTO_INCREMENT PRIMARY KEY,
                pds_id     INT(11)      NOT NULL,
                relation     ENUM('Father','Mother') NOT NULL,
                surname      VARCHAR(60),
                first_name   VARCHAR(60),
                middle_name  VARCHAR(60),
                occupation   VARCHAR(80),
                address      VARCHAR(255),
                FOREIGN KEY (pds_id) REFERENCES personal_data_sheet(pds_id)
                ON DELETE CASCADE ON UPDATE CASCADE,
                UNIQUE KEY uq_user_relation (pds_id, relation)
            )",

            "CREATE TABLE IF NOT EXISTS siblings (
                id          INT(11)      NOT NULL AUTO_INCREMENT PRIMARY KEY,
                pds_id    INT(11)      NOT NULL,
                full_name   VARCHAR(120),
                age         TINYINT,
                occupation  VARCHAR(80),
                address     VARCHAR(255),
                birth_order TINYINT UNSIGNED,
                FOREIGN KEY (pds_id) REFERENCES personal_data_sheet(pds_id)
                ON DELETE CASCADE ON UPDATE CASCADE,
                INDEX idx_sib_user (pds_id)
            )",

            "CREATE TABLE IF NOT EXISTS educationInfo (
                id             INT(11)      NOT NULL AUTO_INCREMENT PRIMARY KEY,
                pds_id       INT(11)      NOT NULL,
                level          ENUM('Elementary','Secondary','Vocational','College','Graduate') NOT NULL,
                school_name    VARCHAR(120),
                degree_course  VARCHAR(120),
                school_address VARCHAR(255),
                year_grad      YEAR,
                FOREIGN KEY (pds_id) REFERENCES personal_data_sheet(pds_id)
                ON DELETE CASCADE ON UPDATE CASCADE,
                UNIQUE KEY uq_user_level (pds_id, level)
            )",

            "CREATE TABLE IF NOT EXISTS workExperience (
                id              INT(11)      NOT NULL AUTO_INCREMENT PRIMARY KEY,
                pds_id        INT(11)      NOT NULL,
                date_from       DATE,
                date_to         DATE,
                position_title  VARCHAR(120),
                department      VARCHAR(160),
                monthly_salary  DECIMAL(12,2),
                FOREIGN KEY (pds_id) REFERENCES personal_data_sheet(pds_id)
                ON DELETE CASCADE ON UPDATE CASCADE,
                INDEX idx_work_user (pds_id)
            )",

            "CREATE TABLE IF NOT EXISTS seminarsTrainings (
                id              INT(11)      NOT NULL AUTO_INCREMENT PRIMARY KEY,
                pds_id        INT(11)      NOT NULL,
                inclusive_dates VARCHAR(80),
                title           VARCHAR(180),
                place           VARCHAR(120),
                FOREIGN KEY (pds_id) REFERENCES personal_data_sheet(pds_id)
                ON DELETE CASCADE ON UPDATE CASCADE,
                INDEX idx_trn_user (pds_id)
            )",

            "CREATE TABLE IF NOT EXISTS otherInfo (
                id              INT(11)      NOT NULL AUTO_INCREMENT PRIMARY KEY,
                pds_id        INT(11)      NOT NULL,
                special_skills    TEXT,
                house_status      ENUM('Owned','Rented'),
                rental_amount     DECIMAL(10,2),
                house_type        ENUM('light','semi_concrete','concrete'),
                household_members TEXT,
                height DECIMAL(4,2),
                weight DECIMAL(5,2),
                blood_type VARCHAR(4),
                emergency_contact VARCHAR(120),
                tel_no VARCHAR(20),
                FOREIGN KEY (pds_id) REFERENCES personal_data_sheet(pds_id)
                ON DELETE CASCADE ON UPDATE CASCADE
            )",

            "CREATE TABLE IF NOT EXISTS userRequest(
                id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                users_id INT(11) NOT NULL,
                status VARCHAR(20) NOT NULL,
                request_date datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (users_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE
            )",
            "CREATE TABLE IF NOT EXISTS jobTitles(
                id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                jobTitle VARCHAR(50) NOT NULL,
                addAt datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
            )",
            "CREATE TABLE IF NOT EXISTS family_information (
                id INT AUTO_INCREMENT PRIMARY KEY,
                
                users_id INT NOT NULL,
                
                father_name VARCHAR(100),
                father_occupation VARCHAR(100),
                father_contact VARCHAR(20),

                mother_name VARCHAR(100),
                mother_occupation VARCHAR(100),
                mother_contact VARCHAR(20),

                guardian_name VARCHAR(100),
                guardian_relationship VARCHAR(100),
                guardian_contact VARCHAR(20),

                FOREIGN KEY (users_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE
            )",
            "CREATE TABLE IF NOT EXISTS family_informationAddress (
                id INT AUTO_INCREMENT PRIMARY KEY,
                
                users_id INT NOT NULL,
                
                father_houseBlock VARCHAR(50),
                father_street VARCHAR(100),
                father_subdivision VARCHAR(100),
                father_barangay VARCHAR(100),
                father_city_muntinlupa VARCHAR(100),
                father_province VARCHAR(100),
                father_zip_code VARCHAR(10),

                mother_houseBlock VARCHAR(50),
                mother_street VARCHAR(100),
                mother_subdivision VARCHAR(100),
                mother_barangay VARCHAR(100),
                mother_city_muntinlupa VARCHAR(100),
                mother_province VARCHAR(100),
                mother_zip_code VARCHAR(10),

                guardian_houseBlock VARCHAR(50),
                guardian_street VARCHAR(100),
                guardian_subdivision VARCHAR(100),
                guardian_barangay VARCHAR(100),
                guardian_city_muntinlupa VARCHAR(100),
                guardian_province VARCHAR(100),
                guardian_zip_code VARCHAR(10),

                FOREIGN KEY (users_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE
            )",
            "CREATE TABLE IF NOT EXISTS educational_background (
                id INT AUTO_INCREMENT PRIMARY KEY,
                users_id INT(11) NOT NULL,

                level ENUM('elementary', 'high_school', 'senior_high', 'college', 'graduate') NOT NULL,
                school_name VARCHAR(255) DEFAULT NULL,
                course_or_strand VARCHAR(255) DEFAULT NULL,
                year_started YEAR DEFAULT NULL,
                year_ended YEAR DEFAULT NULL,
                honors VARCHAR(255) DEFAULT NULL,

                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

                FOREIGN KEY (users_id) REFERENCES users(id)
                    ON DELETE CASCADE
                    ON UPDATE CASCADE
            )",
            "CREATE TABLE IF NOT EXISTS admin_history (
                id INT AUTO_INCREMENT PRIMARY KEY,
                admin_id INT NOT NULL,
                login_time DATETIME NOT NULL,
                logout_time DATETIME DEFAULT NULL,
                FOREIGN KEY (admin_id) REFERENCES users(id) ON DELETE CASCADE
            )",
            "CREATE TABLE IF NOT EXISTS employee_history (
                id INT AUTO_INCREMENT PRIMARY KEY,
                employee_id INT NOT NULL,
                login_time DATETIME NOT NULL,
                logout_time DATETIME DEFAULT NULL,
                FOREIGN KEY (employee_id) REFERENCES users(id) ON DELETE CASCADE
            )",
            "CREATE TABLE IF NOT EXISTS leaveReq (
                leave_id     INT(11) NOT NULL AUTO_INCREMENT,
                users_id     INT(11) NOT NULL,
                leaveStatus  VARCHAR(10) NOT NULL,
                leaveType    VARCHAR(20) NOT NULL,
                leaveDate    DATE NOT NULL,
                Others VARCHAR(255),
                Purpose VARCHAR(255) NOT NULL,
                InclusiveFrom date NOT NULL,
                InclusiveTo date NOT NULL,
                numberOfDays INT NOT NULL,
                contact VARCHAR(13) NOT NULL,
                sectionHead VARCHAR(120) NOT NULL,
                departmentHead VARCHAR(120) NOT NULL,
                request_date DATE NOT NULL DEFAULT CURRENT_DATE,
                PRIMARY KEY (leave_id),
                FOREIGN KEY (users_id) REFERENCES users(id) ON DELETE CASCADE
            ) ENGINE = InnoDB",

            "CREATE TABLE IF NOT EXISTS reports (
                reportID     INT(11) NOT NULL AUTO_INCREMENT,
                users_id     INT(11) NOT NULL,
                leave_id     INT(11) NULL,
                report_type  VARCHAR(255) NOT NULL,
                report_date  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY (reportID),                       
                FOREIGN KEY (users_id) REFERENCES users(id)        ON DELETE CASCADE,
                FOREIGN KEY (leave_id) REFERENCES leaveReq(leave_id) ON DELETE CASCADE
            ) ENGINE = InnoDB",
            "CREATE TABLE IF NOT EXISTS leave_details (
                leaveDetails_id INT AUTO_INCREMENT PRIMARY KEY,
                leaveID INT NOT NULL,
                balance INT NOT NULL,
                earned BIGINT NOT NULL,
                credits BIGINT NOT NULL, 
                lessLeave BIGINT NOT NULL,
                balanceToDate BIGINT NOT NULL, 
                disapprovalDetails TEXT,
                approved_at date NULL,
                disapproved_at date NULL,
                FOREIGN KEY (leaveID) REFERENCES leaveReq(leave_id) ON DELETE CASCADE
            )",
            "CREATE TABLE IF NOT EXISTS leaveCounts (
                leaveCountID     INT          AUTO_INCREMENT PRIMARY KEY,
                users_id         INT          NOT NULL,
                VacationBalance  DECIMAL(6,2) NOT NULL DEFAULT 0.00,
                SickBalance      DECIMAL(6,2) NOT NULL DEFAULT 0.00,
                SpecialBalance   DECIMAL(6,2) NOT NULL DEFAULT 0.00,
                OthersBalance    DECIMAL(6,2) NOT NULL DEFAULT 0.00,
                FOREIGN KEY (users_id) REFERENCES users(id) ON DELETE CASCADE
            )",
            ];
            // $pdo = db_connection();

            // Sample credentials
            foreach ($tableQueries as $query) {
                $pdo->exec($query);
            }

            // Step 5: Insert default admin users
            $defaultAdmins = [
                [
                    'username' => 'HR@pueri2025',
                    'password' => password_hash('admin123', PASSWORD_DEFAULT),
                    'email' => 'pagotaisidromarcojean@gmail.com',
                    'user_role' => 'Administrator',
                    'subRole' => 'HR'
                ],
                [
                    'username' => 'PAYROLL@pueri2025',
                    'password' => password_hash('admin123', PASSWORD_DEFAULT),
                    'email' => 'payroll@example.com',
                    'user_role' => 'Administrator',
                    'subRole' => 'PAYROLL'
                ]
            ];

            foreach ($defaultAdmins as $admin) {
                $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE username = :username");
                $stmt->execute(['username' => $admin['username']]);
                if ($stmt->fetchColumn() == 0) {
                    $stmt = $pdo->prepare("INSERT INTO users (username, password, email, user_role, subRole) VALUES (:username, :password, :email, :user_role, :subRole)");
                    $stmt->execute([
                        'username' => $admin['username'],
                        'password' => $admin['password'],
                        'email' => $admin['email'],
                        'user_role' => $admin['user_role'],
                        'subRole' => $admin['subRole']
                    ]);
                }
            }

            return $pdo;

        } catch (PDOException $e) {
            die("Database error: " . $e->getMessage());
        }
    }
}
