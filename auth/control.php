<?php

declare(strict_types=1);
    require_once '../../installer/session.php';
    require_once '../../installer/config.php';
    require_once '../../auth/view.php';



    function getUsersInfo(){
        $pdo = db_connect();
        
        $query = "SELECT * FROM admin;";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $admin_info = $stmt->fetch(PDO::FETCH_ASSOC);
    
        $query = "SELECT * FROM users
                  INNER JOIN userrequest ON users.id = userrequest.users_id
                  INNER JOIN department ON users.id = department.users_id
                  INNER JOIN addbyadmin ON users.id = addbyadmin.users_id
                  INNER JOIN signup_information ON users.id = signup_information.users_id
                  ORDER BY users.id DESC;";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $getUsers = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        $stmt = $pdo->prepare("
        SELECT users.*, userRequest.status, userRequest.id AS request_id
        FROM users
        INNER JOIN userRequest ON users.id = userRequest.users_id
        WHERE userRequest.status = 'pending'
        ");
        $stmt->execute();
        $StatusPending = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        $stmt = $pdo->prepare("
        SELECT users.*, userRequest.status, userRequest.id AS request_id
        FROM users
        INNER JOIN userRequest ON users.id = userRequest.users_id
        WHERE userRequest.status = 'Rejected'
        ");
        $stmt->execute();
        $StatusRejected = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        $stmt = $pdo->prepare("
        SELECT * FROM users
        INNER JOIN addbyadmin ON users.id = addbyadmin.users_id
        INNER JOIN userRequest ON users.id = userRequest.users_id
        INNER JOIN department ON users.id = department.users_id
        INNER JOIN signup_information ON users.id = signup_information.users_id
        WHERE userRequest.status = 'approved' ORDER BY users.id DESC
        ");
        $stmt->execute();
        $StatusApproved = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $hasPending = false;
        $hasReject = false;
    
        foreach ($StatusPending as $row) {
            if ($row["status"] == "pending") {
                $hasPending = true;
                break;
            }
        }
    
        foreach ($StatusRejected as $row) {
            if ($row["status"] == "Rejected") {
                $hasReject = true;
                break;
            }
        }
    
        $query = "
            SELECT *
            FROM (
                SELECT *, ROW_NUMBER() OVER (PARTITION BY users_id ORDER BY id DESC) AS rn
                FROM user_status
                WHERE DATE(inOut_at) = CURDATE()
            ) AS ranked
            WHERE rn <= 2
            ORDER BY users_id, id DESC;
        ";

        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $LoggedInHistory = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $query = "SELECT COUNT(*), userrequest.status FROM users
        INNER JOIN userrequest ON users.id = userrequest.users_id
        WHERE status = 'approved';";
        $stmt=$pdo->prepare($query);
        $stmt->execute();
        $count = $stmt->fetchColumn();

        $query = "SELECT COUNT(*), userrequest.status FROM department
        INNER JOIN users ON department.users_id = users.id
        INNER JOIN userrequest ON users.id = userrequest.users_id
        WHERE department = 'SCHOOL' AND status = 'approved';";
        $stmt=$pdo->prepare($query);
        $stmt->execute();
        $school = $stmt->fetchColumn();

        $query = "SELECT COUNT(*), userrequest.status FROM department
        INNER JOIN users ON department.users_id = users.id
        INNER JOIN userrequest ON users.id = userrequest.users_id
        WHERE department = 'HOSPITAL' AND status = 'approved';";
        $stmt=$pdo->prepare($query);
        $stmt->execute();
        $hospital = $stmt->fetchColumn();

        $query = "SELECT * FROM jobs;";
        $stmt=$pdo->prepare($query);
        $stmt->execute();
        $jobs = $stmt->fetchAll(PDO::FETCH_ASSOC);

            isset($_SESSION["profileId"]) && $_SESSION["profileId"] !== "" ? $idPo = $_SESSION["profileId"] : null;
            $query = "SELECT * FROM users
            INNER JOIN userrequest ON users.id = userrequest.users_id
            INNER JOIN department ON users.id = department.users_id
            INNER JOIN addbyadmin ON users.id = addbyadmin.users_id
            INNER JOIN signup_information ON users.id = signup_information.users_id
            WHERE users.id = :id;";
            $stmt=$pdo->prepare($query);
            $stmt->bindParam(":id", $idPo);
            $stmt->execute();
            $profile = $stmt->fetch(PDO::FETCH_ASSOC);

        $query = "SELECT signup_information.Lname, leavea.prof, leavea.employee_id, leavea.leave_Type, leavea.Leave_Date, leavea.leave_Status,
        leave_approved.approved_at FROM users
          LEFT JOIN signup_information ON users.id = signup_information.users_id
          LEFT JOIN leavea ON users.id = leavea.users_id
          LEFT JOIN leave_approved ON users.id = leave_approved.leave_id
          WHERE leave_Status = 'approved' ORDER BY users.id ASC";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $leave = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $query = "SELECT signup_information.Lname, leavea.leaveID, leavea.prof, leavea.employee_id, leavea.leave_Type, leavea.Leave_Date, leavea.leave_Status,
        leave_approved.approved_at FROM users
          LEFT JOIN signup_information ON users.id = signup_information.users_id
          LEFT JOIN leavea ON users.id = leavea.users_id
          LEFT JOIN leave_approved ON users.id = leave_approved.leave_id
          WHERE leave_Status = 'pending' ORDER BY users.id ASC";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $pendingLeave = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // ========================== EMPLOYEE ID HERE =================== //

        isset($_SESSION["user_id"]) ? $employeeID = $_SESSION["user_id"] : "NANIIIIIIIIII";

/*         $query = "SELECT * FROM schedule";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $schedule = $stmt->fetchAll(PDO::FETCH_ASSOC);
 */
        $query = "SELECT COUNT(*) FROM userrequest WHERE status = 'pending';";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $pendingCount = $stmt->fetchColumn();
        
        $query = "SELECT COUNT(*) FROM leavea WHERE leave_Status = 'pending';";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $pendinLeaveCount = $stmt->fetchColumn();
        

        $query = "SELECT * FROM users WHERE id = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $employeeID);
        $stmt->execute();
        $usersAccount = $stmt->fetch(PDO::FETCH_ASSOC);


        $query = "SELECT signup_information.Lname, leavea.prof, leavea.employee_id, leavea.leave_Type, leavea.Leave_Date, leavea.leave_Status,
        leave_approved.approved_at, leave_approved.approved_at FROM users
          LEFT JOIN signup_information ON users.id = signup_information.users_id
          LEFT JOIN leavea ON users.id = leavea.users_id
          LEFT JOIN leave_approved ON leavea.leaveID = leave_approved.leave_id
          WHERE leave_Status = 'approved' AND users.id = :id ORDER BY users.id ASC";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":id", $employeeID);
        $stmt->execute();
        $Employeeleave = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $query = "SELECT * FROM users
            INNER JOIN userrequest ON users.id = userrequest.users_id
            INNER JOIN department ON users.id = department.users_id
            INNER JOIN addbyadmin ON users.id = addbyadmin.users_id
            INNER JOIN signup_information ON users.id = signup_information.users_id
            WHERE users.id = :id;";
            $stmt=$pdo->prepare($query);
            $stmt->bindParam(":id", $employeeID);
            $stmt->execute();
            $profileE = $stmt->fetch(PDO::FETCH_ASSOC);    

            $query = "SELECT COUNT(*) FROM leavea WHERE leaveID = :leaveID AND leave_Status = 'approved'";
            $stmt=$pdo->prepare($query);
            $stmt->bindParam(":leaveID", $employeeID);
            $stmt->execute();
            $approvedCounts = $stmt->fetchColumn();

            $query = "SELECT COUNT(*) FROM leavea WHERE leaveID = :leaveID AND leave_Status = 'reject'";
            $stmt=$pdo->prepare($query);
            $stmt->bindParam(":leaveID", $employeeID);
            $stmt->execute();
            $rejectCounts = $stmt->fetchColumn();

            $query = "SELECT addbyadmin.salary_Range_From, addbyadmin.salary_Range_To FROM addbyadmin WHERE id = :id;";
            $stmt=$pdo->prepare($query);
            $stmt->bindParam(":id", $employeeID);
            $stmt->execute();
            $SalaryRange = $stmt->fetch(PDO::FETCH_ASSOC);

            $query = "SELECT * FROM leave_counts
            INNER JOIN users ON leave_counts.users_id = users.id
            INNER JOIN addbyadmin ON users.id = addbyadmin.users_id
            WHERE leave_counts.users_id = :users_id;";
            $stmt=$pdo->prepare($query);
            $stmt->bindParam(":users_id", $employeeID);
            $stmt->execute();
            $leavCounts = $stmt->fetch(PDO::FETCH_ASSOC);

            $query = "SELECT * FROM user_status 
            WHERE users_id = :users_id 
            AND (Logged_in IS NOT NULL OR logged_out IS NOT NULL);";

            $stmt=$pdo->prepare($query);
            $stmt->bindParam(":users_id", $employeeID);
            $stmt->execute();
            $historyLogs = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return ['admin_info' => $admin_info, 'getUsers' => $getUsers, 'StatusRejected' => $StatusRejected,
        'StatusPending' => $StatusPending, 'StatusApproved' => $StatusApproved, 'LoggedInHistory' => $LoggedInHistory,
        'count' => $count,'school' => $school,'hospital' => $hospital,'jobs' => $jobs,'profile' => $profile, 'leave' => $leave
        , 'leavCounts' => $leavCounts, 'Employeeleave' => $Employeeleave, 'pendingLeave' => $pendingLeave, 'profileE' => $profileE,
        'usersAccount' => $usersAccount, 'rejectCounts' => $rejectCounts, 'approvedCounts' => $approvedCounts, 'SalaryRange' => $SalaryRange
    , 'pendingCount' => $pendingCount, 'pendinLeaveCount' => $pendinLeaveCount, 'historyLogs' => $historyLogs];
    }

    