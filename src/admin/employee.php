<?php include_once '../../auth/control.php'; 
    $info = getUsersInfo();
    $admin_info = $info['admin_info'];
    $getUsers = $info['getUsers'];
    $hasPending = $info['StatusPending'];
    $hasReject = $info['StatusRejected'];
    $StatusApproved = $info['StatusApproved'];
    $LoggedInHistory = $info['LoggedInHistory'];
    $jobs = $info['jobs'];
    $pendingCount = $info['pendingCount'];
    ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EMPLOYEE MANAGEMENT</title>
    <link rel="stylesheet" href="../../assets/css/hr.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"/>
    <style>
      @import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css');
    </style>
    <script src="../../assets/js/main.js"></script>
    
</head>
<body>
    <div class="header">
        <div class="logo">
            <h3>ZAMBOANGA PUERICULTURE CENTER ORG.</h3>
        </div>
        <div class="otherButtons">
            <button type="submit" onclick="profileMenu()" id="buttonpfpmenu">
                <img src="../../assets/image/users.png" alt="pfp" id="pfpOnTop">
                <p><?php echo $admin_info["firstname"] ." "; ?><i class="fa-solid fa-caret-down"></i></p>
            </button>
            
            <div class="profileMenu" id="profileMenu" style="display: none;">
                <li id="borderBottom"><a href="profile.php"><p><i class="fa-solid fa-user"></i>PROFILE</p></a></li>
                <li id="borderBottom"><a href="settings.php"><p><i class="fa-solid fa-gear"></i>SETTINGS</p></a></li>
                <li><a href="../adminLogout.php" id="l"><p><i class="fa-solid fa-right-from-bracket"></i>LOGOUT</p></a></li>
            </div>
        </div>
    </div>
    <div class="row">
    <div class="sideNav">
            <div class="sideContents" id="sideContents">
                <div class="profileBox">
                <img src="../../assets/image/pueri-logo.png" alt="pfp" id="pfpOnTop">
                    <h4>Since 1913</h4>
                    <p>Zamboanga Peninsula Region IX</p>
                </div>
                <div class="menuBox">
                    <ul>
                        <a href="dashboard.php" id="dashboard-a"><button><i class="fa-solid fa-house-user"></i>DASHBOARD</button></a>
                        <button type="submit" onclick="getHrNavs()">EMPLOYEES<i class="fa-solid fa-caret-down" id="iLeft"></i></button>
                        <ul style="display: none;" id="hrNavs" class="hrNavs">
                            <a href="employee.php"><p><i class="fa-solid fa-users"></i>RECRUITMENTS</p></a>
                            <a href="fillReq.php"><p><i class="fa-solid fa-code-pull-request"></i>FILING REQUEST</p></a>
                            <a href="leave.php"><p><i class="fa-solid fa-file-export"></i>LEAVE REQUEST</p></a>
                            <a href="Jobs.php"><p><i class="fa-solid fa-briefcase"></i>JOB TITLES</p></a>
                        </ul>
                        <button type="submit" onclick="getPayrollNavs()">TRANSACTIONS<i class="fa-solid fa-caret-down" id="iLeft"></i></button>
                        <ul style="display: none;" id="payrollNavs">
                            <a href=""><p>PAYROLL  PROCESS</a>
                            <a href=""><p>PAYROLL CONFIG</a>
                            <a href=""><p>PAYROLL REPORTS</a>
                            <a href=""><p>DEDUCTIONS SLIP</a>
                            <a href=""><p>LOAN REQUEST</a>
                        </ul>
                        <button type="submit" onclick="getBioNavs()">BIOMETRICS<i class="fa-solid fa-caret-down" id="iLeft"></i></button>
                        <ul style="display: none;" id="bioNavs">
                            <a href=""><p>ENROLL DATA</p></a>
                            <a href=""><p>DTR MANAGEMENT</p></a>
                            <a href=""><p>TIME CONFIGURATION</p></a>
                            <a href=""><p>SYSTEM SETTING</p></a>
                            <a href=""><p>HISTORY</p></a>
                        </ul>
                    </ul>
                </div>
            </div>
        </div>
        
        <div class="contents">
            <div class="search">
                <div class="searchInput">
                <input type="text" placeholder="Search.." id="searchInput">
                <button><i class="fa-solid fa-magnifying-glass"></i></button>
                </div>
                <div class="employee_management">
                    <button type="submit" onclick="requestButton()" id="view"><i class="fa-solid fa-user"></i>Request<p id="pendingCountDisplay"></p></button>
                    <button type="submit" onclick="rejectButton()"id="delete"><i class="fa-solid fa-user"></i>Rejected</button>
                    <button type="submit" onclick="addButton()"id="edit"><i class="fa-solid fa-user-plus"></i>Add</button>
                </div>
            </div>
            <div id="employeeContainer" class="naniEmployess">
                <?php
                    foreach ($StatusApproved as $row) {
                        if ($row["status"] == "approved") {
                            echo '<div class="approved" data-employee-id="' . $row['employeeID'] .'">';
                            echo isset($row["user_profile"]) && $row["user_profile"] !== "" ? '<img src="../../assets/image/upload/' . $row["user_profile"] . '" alt="">' :
                            '<img src="../../assets/image/users.png" alt="">';
                                echo '<p class="emp-id">' . $row["employeeID"] . '</p>';
                                echo '<p class="emp-name">' . $row["Lname"] . ", " . $row["Fname"] .'</p>';
                                echo '<p class="emp-job">' . $row["job_Title"] . '</p>';
                                echo '<p class="emp-dept">' . $row["department"] . ' DEPARTMENT</p>';
                                echo '<p class="emp-email" id="e">' . $row["email"] . '</p>';
                                echo '<div class="crudButtons">';
                                    echo '<a href="EmployeeProfile.php?id=' . $row["id"] . '"><button type="button" id="view">VIEW</button></a>';
                                    echo '<button type="button" id="delete" onclick="openDeleteForm(' . $row["id"] . ')">DELETE</button>';
                                echo '</div>';
                            echo '</div>';
                        }
                    }
                ?>
                </div>

            <div class="employeeList" id="employeeList">

                <div class="pending">
                    <div class="accountRequest" id="accountRequest" style="display: none;">
                        <div class="back">
                            <button type="submit" onclick="backButton()">
                                <i class="fa-solid fa-arrow-left" style="font-size: 20px;"></i>
                            </button>
                        </div>
                        <?php
                        
                        if ($hasPending) {
                            foreach ($getUsers as $row) {
                                if ($row["status"] == "pending") {
                                    echo '<div class="approved">';
                                        echo '<img src="../../assets/image/upload/' . $row["user_profile"] . '" alt="">';
                                        echo '<p>' . $row["employeeID"] . '</p>';
                                        echo '<p>' . $row["Lname"] . ", " . $row["Fname"] .'</p>';
                                        echo '<p>' . $row["job_Title"] . '</p>';
                                        echo '<p>' . $row["department"] . ' DEPARTMENT</p>';
                                        echo '<p id="e">' . $row["email"] . '</p>';
                                            echo '<div class="crudButtons">';
                                                echo '<form action="../../auth/authentications.php?id=' . $row["id"] . '" method="post">';
                                                    echo '<input type="hidden" name="csrf_token" value="' . $csrf_token . '">';
                                                    echo '<input type="hidden" name="approve" value="admin">';
                                                    echo '<button type="submit" id="edit">Approve</button>';
                                                echo '</form>';

                                                echo '<form action="../../auth/authentications.php?id=' . $row["id"] . '" method="post">';
                                                    echo '<input type="hidden" name="csrf_token" value="' . $csrf_token . '">';
                                                    echo '<input type="hidden" name="reject" value="request">';
                                                    echo '<button type="submit" id="delete">Decline</button>';
                                                echo '</form>';
                                            echo '</div>';
                                            echo '</div>';
                                }
                            }
                        } else {
                            echo "<h3>No Account Request!</h3>";
                        }
                        ?>
                    </div>
                </div>

                <div class="rejectedRequest" id="rejectedRequest" style="display: none;">
                        <div class="back">
                                <button type="submit" onclick="backButton()"><i class="fa-solid fa-arrow-left" style="font-size: 20px;"></i></button>
                            </div>
                        <?php
                            if ($hasReject) {
                                foreach ($getUsers as $row) {
                                    if ($row["status"] == "Rejected") {
                                        echo '<div class="approved">';
                                            echo '<img src="../../assets/image/upload/' . $row["user_profile"] . '" alt="">';
                                            echo '<p>' . $row["department"] . '</p>';
                                            echo '<p>' . $row["Lname"] . ", " . $row["Fname"] .'</p>';
                                            echo '<p>' . $row["job_Title"] . '</p>';
                                            echo '<p>' . $row["department"] . ' DEPARTMENT</p>';
                                            echo '<p id="e">' . $row["email"] . '</p>';
                                                echo '<div class="crudButtons">';
                                                    echo '<form action="../../auth/authentications.php?id=' . $row["id"] . '" method="post">';
                                                        echo '<input type="hidden" name="csrf_token" value="' . $csrf_token . '">';
                                                        echo '<input type="hidden" name="approve" value="request">';
                                                        echo '<button id="edit">Approve</button>';
                                                    echo '</form>';

                                                    echo '<form action="../../auth/authentications.php?id=' . $row["id"] . '" method="post">';
                                                        echo '<input type="hidden" name="csrf_token" value="' . $csrf_token . '">';
                                                        echo '<input type="hidden" name="delete" value="request">';
                                                        echo '<button id="delete">delete</button>';
                                                    echo '</form>';
                                                echo '</div>';
                                                echo '</div>';
                                    }
                                }
                            } else {
                                echo "<h3>No Account Rejected!</h3>";
                            }
                        ?>
                </div>
                <div class="addmamhen" id="addmamhen" style="display: none;">
                
                    <?php
                        Add_Employee();
                    ?>
                    <div class="outerButton">
                        <button type="submit" id="naniButton" class="btn btn-primary">ADD EMPLOYEE</button>
                    </div>
                    </form>
                </div>
                <div id="statusApprovedContainer">
                </div>
                    <div class="hiddenForms" id="hiddenForm" style="display: none;">
                        <p>ARE YOU SURE YOU WANT TO DELETE THIS USER?</p>
                        <div class="buttonsCenter">
                            <form action="" method="post" id="deleteForm">
                                <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">
                                <input type="hidden" name="delete" value="userAccount">
                                <input type="hidden" name="id" id="usersID" value="">
                                <button type="submit" id="deleteUserByHr">Yes</button> 
                            </form>
                            <button type="button" id="view" onclick="cancelAction()">No</button>
                        </div>
                    </div>
                    
            </div>
        </div>
    </div>
    <?php
        approvedSuccess();
    ?>
   
   <script src="../../assets/js/hr/hr.js"></script>
   <script src="../../assets/js/hr/hrP.js"></script>

   <script>
    document.addEventListener("DOMContentLoaded", () => {
    fetchStatusApproved();
});

function fetchStatusApproved() {
    fetch('../api/ajax.php') 
        .then(response => response.json())
        .then(data => {
            if (data.StatusApproved && Array.isArray(data.StatusApproved)) {
                renderStatusApproved(data.StatusApproved);
            } else {
                console.error("No StatusApproved data found.");
            }
        })
        .catch(error => {
            console.error('Error fetching data:', error);
        });
}

function renderStatusApproved(employees) {
    const container = document.getElementById("statusApprovedContainer");
    container.innerHTML = ""; 

    const ul = document.createElement("ul");
    ul.classList.add("employee-list");

    employees.forEach(emp => {
        const li = document.createElement("li");
        li.classList.add("approved");

        const imagePath = emp.user_profile
            ? `../../assets/image/upload/${emp.user_profile}`
            : `../../assets/image/users.png`;

        li.innerHTML = `
            <img src="${imagePath}" alt="Profile Image">
            <p>${emp.employeeID}</p> 
            <p>${emp.Lname + ", " + emp.Fname}</p> 
            <p>${emp.job_Title}</p> 
            <p>${emp.department + " - DEPARTMENT"}</p> 
            <p>${emp.email}</p> 
            <div class="crudButtons">
            <a href="EmployeeProfile.php?id=${emp.id}"><button type="button" id="view">VIEW</button></a>
            <button type="button" id="delete" onclick="openDeleteForm(${emp.id})">DELETE</button>
            </div>
        `;

        ul.appendChild(li);
    });

    container.appendChild(ul);
}
function toggleScheduleFields() {
    const department = document.getElementById('departmentss').value;
    const schoolField = document.getElementById('school_schedule_field');
    const hospitalField = document.getElementById('hospital_schedule_field');

    if (department === "SCHOOL") {
        schoolField.style.display = 'flex';
        hospitalField.style.display = 'none';
    } else if (department === "HOSPITAL") {
        hospitalField.style.display = 'flex';
        schoolField.style.display = 'none';
    } else {
        hospitalField.style.display = 'none';
        schoolField.style.display = 'none';
    }
}

document.addEventListener('DOMContentLoaded', toggleScheduleFields);

document.addEventListener('DOMContentLoaded', function () {
    fetch('../api/ajax.php') // Replace with your actual PHP file
        .then(response => response.json())
        .then(data => {
            if (data.pendingCount !== undefined) {
                document.getElementById('pendingCountDisplay').textContent = `${data.pendingCount}`;
            } else {
                console.error('pendingCount not found in response:', data);
            }
        })
        .catch(error => {
            console.error('Error fetching data:', error);
        });
});
</script>

</body>
</html>