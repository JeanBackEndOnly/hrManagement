<?php
if (!function_exists('db_connection')) {
    function db_connection()
    {
        $host = 'localhost';
        $username = 'root';
        $password = '';
        $database = 'hrPuericulture';

        try {
            $pdo = new PDO("mysql:host=$host;charset=utf8mb4", $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $pdo->exec("CREATE DATABASE IF NOT EXISTS `$database` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci");

            $pdo = new PDO("mysql:host=$host;dbname=$database;charset=utf8mb4", $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $tableQueries = [
                "CREATE TABLE IF NOT EXISTS users (
                    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                    session_id VARCHAR(255) NULL,
                    username VARCHAR(100) NOT NULL,
                    password VARCHAR(255) NOT NULL,
                    user_role VARCHAR(20) NOT NULL,
                    created_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
                )",
                "CREATE TABLE IF NOT EXISTS userInformations(
                id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                users_id INT(11) NOT NULL,
                lname VARCHAR(100) NOT NULL,
                fname VARCHAR(150) NOT NULL,
                mname VARCHAR(150) NOT NULL,
                suffix VARCHAR(6),
                employeeID VARCHAR(150) NOT NULL,
                department VARCHAR(50) NOT NULL,
                jobTitle VARCHAR(50) NOT NULL,
                slary_rate VARCHAR(10) NOT NULL,
                salary_Range_From DECIMAL(10,2) NOT NULL,
                salary_Range_To DECIMAL(10,2) NOT NULL,
                salary DECIMAL(10,2) NOT NULL,
                citizenship VARCHAR(50) NOT NULL,
                gender VARCHAR(50) NOT NULL,
                civil_status VARCHAR(50) NOT NULL,
                religion VARCHAR(50),
                age VARCHAR(50),
                birthday VARCHAR(50) NOT NULL,
                birthPlace VARCHAR(50),
                contact VARCHAR(50) NOT NULL,
                email VARCHAR(50) NOT NULL,
                secheduleFrom VARCHAR(255) NOT NULL,
                scheduleTo VARCHAR(50) NOT NULL,
                houseBlock VARCHAR(50),
                street VARCHAR(50) NOT NULL,
                subdivision VARCHAR(50),
                barangay VARCHAR(50) NOT NULL,
                city_muntinlupa VARCHAR(50) NOT NULL,
                province VARCHAR(50) NOT NULL,
                zip_code VARCHAR(10) NOT NULL,
                user_profile VARCHAR(255),
                add_at datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (users_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE
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
                father_houseBlock VARCHAR(50),
                father_street VARCHAR(100),
                father_subdivision VARCHAR(100),
                father_barangay VARCHAR(100),
                father_city_muntinlupa VARCHAR(100),
                father_province VARCHAR(100),
                father_zip_code VARCHAR(10),

                mother_name VARCHAR(100),
                mother_occupation VARCHAR(100),
                mother_contact VARCHAR(20),
                mother_houseBlock VARCHAR(50),
                mother_street VARCHAR(100),
                mother_subdivision VARCHAR(100),
                mother_barangay VARCHAR(100),
                mother_city_muntinlupa VARCHAR(100),
                mother_province VARCHAR(100),
                mother_zip_code VARCHAR(10),

                guardian_name VARCHAR(100),
                guardian_relationship VARCHAR(100),
                guardian_contact VARCHAR(20),
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


            ];

            foreach ($tableQueries as $query) {
                $pdo->exec($query);
            }

            return $pdo;

        } catch (PDOException $e) {
            die("Database error: " . $e->getMessage());
        }
    }
}
