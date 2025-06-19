<?php include '../../templates/Uheader.php'; include '../../templates/adminAuth.php';?>

<main>
    <div class="main-body w-100 h-100 m-0 p-0">
        <div class="header d-flex align-items-center justify-content-between px-3" style="height: 60px; min-width: 100%;">
            <div class="logo d-flex align-items-center">
                <button type="button" onclick="sideNav();"><i class="fa-solid fa-bars fs-4 me-3"></i></button>
                <img src="../../assets/image/pueri-logo.png" alt="Logo" style="height: 40px;" class="me-2">
                <h4 class="m-0">ZAMBOANGA PUERICULTURE CENTER</h4>
            </div>

            <div class="usersButton d-flex align-items-center">
                <a href="settings.php"><i class="fa-solid fa-gear"></i></a>
                <a href="logout.php"><i class="fa-solid fa-right-from-bracket ms-3"></i></a>
                <button class="align-items-center" type="button" onclick="userButton()">
                    <img src="../../assets/image/users.png" class="rounded-circle me-2 ms-4" style="height: 35px; width: 35px;">
                    <span class="fw-bold">ADMIN</span>
                </button>
            </div>
        </div>
        <div class="d-flex w-100 align-items-start" style="height: 91%">
            <div class="sideNav p-0" id="sideHEhe">
                <div class="navs p-0 m-0 mt-2 w-auto">
                    <li class="dashboardLi d-flex align-items-center p-2 mb-2">
                        <a href="dashboard.php" class="d-flex align-items-center w-100">
                            <i id="dashoardi" class="fa-solid fa-house fs-5 me-2 me-side-text2"></i>
                            <p class="text-start side-text m-0" id="pdashboard">Dashboard</p>
                        </a>
                    </li>
                    <li class="hrLi d-flex align-items-center p-2 mb-2 w-100">
                        <button type="button" onclick="hrButton()" class="p-0 m-0 w-100 h-100 d-flex align-items-center">
                            <i id="hri" class="fa-solid me-2 fa-users"></i>
                            <p class="text-start side-text" id="phr">HR Management</p>
                            <i id="iLeftArrowHr" class="fa-solid fa-chevron-left" style="display:none;"></i>
                        </button>
                    </li>

                    <ul id="hrUl" class="flex-column" style="display:none;">
                       <li class="my-1"><a href="employee.php" class="d-flex justify-content-start"><i class="fa-solid me-1 fa-users-gear d-flex align-items-center"></i><p style="display:flex;" id="pNone" class="text-start">RECRUITMENTS</p></a></li>
                        <li class="my-1"><a href="leave.php"  class="d-flex justify-content-start"><i class="fa-solid me-1 d-flex align-items-center fa-file-export"></i><p style="display:flex;" id="pNone" class="text-start">LEAVE REQUEST</p></a></li>
                        <li class="my-1"><a href="job.php"  class="d-flex justify-content-start"><i class="fa-solid me-1 d-flex align-items-center fa-briefcase"></i><p style="display:flex;" id="pNone" class="text-start">JOB & SALARY</p></a></li>
                        <li class="my-1"><a href="reports.php"  class="d-flex justify-content-start"><i class="fa-solid me-1 fa-flag" d-flex align-items-center></i><p style="display:flex;" id="pNone" class="text-start">Reports</p></a></li>
                    </ul>

                    <li class="payrollLi d-flex align-items-center p-2 mb-2">
                        <button type="button" onclick="payrollButton()" class="p-0 m-0 w-100 h-100 d-flex align-items-center">
                            <i id="payrolli" class="fa-solid me-2 fa-peso-sign"></i>
                            <p class="text-start side-text" id="ppr">Payroll Management</p>
                            <i id="iLeftArrowPr" class="fa-solid fa-chevron-left" style="display:none;"></i>
                        </button>
                    </li>

                    <ul id="payrollUl" class="flex-column" style="display:none;">
                        <li class="my-1"><a href="#"><i class="fa-solid me-1 fa-users-gear"></i>RECRUITMENTS</a></li>
                        <li class="my-1"><a href="#"><i class="fa-solid me-1 fa-file-export"></i>LEAVE REQUEST</a></li>
                        <li class="my-1"><a href="#"><i class="fa-solid me-1 fa-briefcase"></i>JOB TITLES</a></li>
                    </ul>

                    <li class="attendanceLi d-flex align-items-center p-2 mb-2">
                        <a href="#" class="p-0 m-0 w-100 h-100 d-flex align-items-center">
                            <i class="fa-solid me-2 fa-clock"></i>
                            <p class="text-start side-text" id="pa">Attendance</p>
                        </a>
                    </li>

                    <li class="settingsLi d-flex align-items-center p-2 mb-2">
                        <a href="settings.php" class="p-0 m-0 w-100 h-100 d-flex align-items-center">
                            <i class="fa-solid me-2 fa-gear"></i>
                            <p class="text-start side-text" id="ps">Settings</p>
                        </a>
                    </li>
                </div>
            </div>
            <div class="contents w-100 h-100 d-flex flex-column align-items-center p-0 m-0">
                <div class="header-employee d-flex flex-row justify-content-between align-items-center" style="height: 7rem; width: 95%;">
                    <div class="h1">
                        <h3 class="m-0">EMPLOYEE MANAGEMENT</h3>
                    </div>
                    <div class="crud-employee d-flex flex-row justify-content-between me-3" style="width: 30rem; height: 2rem">
                        <button type="button" onclick="getValidated()" class="rounded-2 border-2" style="font-size:15px;" id="requet">Validated</button>
                        <button type="button" onclick="getRequest()" class="rounded-2 border-2" style="font-size: 15px;" id="requet">
                            Request <span id="pendingCountDisplay"></span>
                        </button>
                        <button type="button" onclick="getRejected()" class="rounded-2 border-2" style="font-size:15px;" id="reject">Rejected</button>
                        <button type="button" class="rounded-2 border-2" style="font-size:15px;" id="add"><a href="register.php" class="w-100 h-100 d-flex justify-content-center align-items-center" style="text-decoration: none; color: #000;">add</a></button>
                    </div>
                </div>

                <div class="titlesOfList d-flex justify-content-start m-0" id="ListTitles" style="width: 95%;">
                    <div class="Employee-list" id="validatedEmployees" style="display: flex;">
                        <h5>Validated Employee List</h5>
                    </div>
                    <div class="Employee-list" id="employeesRequest" style="display: none;">
                        <h5>Employee Request List</h5>
                    </div>
                    <div class="Employee-list" id="rejectedEmployees" style="display: none;">
                        <h5>Employee Rejected List</h5>
                    </div>
                </div>
                <!-- ======================= VALIDATED EMPLOYEE LIST ============================== -->
                <div id="validateSearch" class="search-validated flex-row justify-content-evenly mx-0 my-1 align-items-center gap-2 rounded-2" style="width: 95%; display: flex;">
                    <div class="search-bar d-flex align-items-center justify-content-start" style="width: 80%; transform: translateX(-10px);">
                        <div class="search-active position-relative w-100 ms-2 d-flex align-items-center justify-content-start">
                            <input type="text" class="form-control ps-5" id="searchValidatedInput" placeholder="Search...">
                            <i class="fa-solid fa-magnifying-glass position-absolute" style="top: 50%; left: 15px; transform: translateY(-50%); color: gray;"></i>
                        </div>
                    </div>
                    <?=renderValidatedSortAndPerPageControls($currentUrl, $validatedPerPage, $validatedSortColumn, $validatedSortOrder);?>
                </div>

                <div class="validated-employee-list" id="validatedList" style="width: 95%; margin: 20px auto; height: 50vh; display: flex; flex-direction: column;">
                    <table class="table table-bordered table-striped mt-3" style="width: 100%; border-collapse: separate; flex: 1 1 auto; display: block;">
                        <thead style="display: table-header-group; width: 100%; background: white; position: sticky; top: 0; z-index: 10; color: #000;">
                            <tr style="display: table; width: 100%; table-layout: fixed;">
                                <th style="width: 5%;">#</th>
                                <th style="width: 25%;">Employee Name</th>
                                <th style="width: 20%;">Emplyee ID</th>
                                <th style="width: 15%;">Department</th>
                                <th style="width: 20%;">Date Added</th>
                                <th style="width: 15%;">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="validatedList" style="display: block; overflow-y: auto; height: calc(50vh - 50px); width: 99.8%; margin-left: 2px;">
                            <?php if (!empty($validated)): ?>
                                <?php $num = 1; ?>
                                <?php foreach($validated as $row): ?>
                                    <tr style="display: table; width: 100%; table-layout: fixed;">
                                        <td style="width: 5%;"><?= $num ?></td>
                                        <td style="width: 25%;"><?= htmlspecialchars($row['lname'] . ', ' . $row['fname'] . ' ' . $row['mname']) ?></td>
                                        <td style="width: 20%;"><?= htmlspecialchars($row['employeeID']) ?></td>
                                        <td style="width: 15%;"><?= htmlspecialchars($row['department']) ?></td>
                                        <td style="width: 20%;"><?= date('F j, Y h:i A', strtotime($row['add_at'])) ?></td>
                                        <td style="width: 15%;">
                                            <button class="btn btn-primary"><a href="profile.php?users_id=<?php echo $row['users_id']; ?>" style="text-decoration: none; color: #fff;">View</a></button>
                                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" onclick="setDeleteId(<?= $row['users_id'] ?>)">Delete</button>
                                        </td>
                                    </tr>
                                    <?php $num++; ?>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr style="display: table; width: 100%; table-layout: fixed;">
                                    <td colspan="6" class="text-center">No validated employees found.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                    <?= renderValidatedPaginationControls($currentUrl, $validatedPage, $validatedTotalPages, $validatedPerPage, $validatedSortColumn, $validatedSortOrder); ?>
                </div>
                <!-- ======================= DELETE MODAL ============================== -->
                <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <form action="../../auth/authentications.php" method="POST">
                            <input type="hidden" name="delete_user_id" id="delete_user_id">
                            <?php isset($_SESSION["csrf_token"]) && $_SESSION["csrf_token"] !== "" ? $csrf = $_SESSION["csrf_token"] : " null "; ?>
                            <input type="hidden" name="csrf_token" value="<?php echo $csrf; ?>">
                            <input type="hidden" name="deleteValidatedEmployee" value="true">
                            <div class="modal-content">
                                <div class="modal-header bg-danger text-white">
                                    <h5 class="modal-title" id="deleteModalLabel" style="color: #fff;">Confirm Delete</h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Are you sure you want to delete this employee?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" name="delete_user" class="btn btn-danger">Yes, Delete</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- ======================= EMPLOYEE REQUEST LIST ============================== -->
                <div id="requestSearch" class="search-request flex-row justify-content-evenly mx-0 my-1 align-items-center gap-2 rounded-2" style="width: 95%; display: none;">
                    <div class="search-bar d-flex align-items-center justify-content-start" style="width: 80%; transform: translateX(-10px);">
                        <div class="search-active position-relative w-100 ms-2 d-flex align-items-center justify-content-start">
                            <input type="text" class="form-control ps-5" id="searchRequestInput" placeholder="Search...">
                            <i class="fa-solid fa-magnifying-glass position-absolute" style="top: 50%; left: 15px; transform: translateY(-50%); color: gray;"></i>
                        </div>
                    </div>
                    <?= renderRequestSortAndPerPageControls($currentUrl, $requestPerPage, $requestSortColumn, $requestSortOrder); ?>
                </div>

                <div class="request-employee-list" id="requestList" style="width: 95%; margin: 20px auto; height: 50vh; display: none; flex-direction: column;">
                    <table class="table table-bordered table-striped mt-3" style="width: 100%; border-collapse: separate; flex: 1 1 auto; display: block;">
                        <thead style="display: table-header-group; width: 100%; background: white; position: sticky; top: 0; z-index: 10; color: #000;">
                            <tr style="display: table; width: 100%; table-layout: fixed;">
                                <th style="width: 5%;">#</th>
                                <th style="width: 25%;">Employee Name</th>
                                <th style="width: 20%;">Emplyee ID</th>
                                <th style="width: 15%;">Department</th>
                                <th style="width: 20%;">Date Requested</th>
                                <th style="width: 15%;">Actions</th>
                            </tr>
                        </thead>
                        <tbody style="display: block; overflow-y: auto; height: calc(50vh - 50px); width: 99.8%; margin-left: 2px;">
                            <?php if (!empty($requestEmployee)): ?>
                                <?php $num = 1; ?>
                                <?php foreach($requestEmployee as $row): ?>
                                    <tr style="display: table; width: 100%; table-layout: fixed;">
                                        <td style="width: 5%;"><?= $num ?></td>
                                        <td style="width: 25%;"><?= htmlspecialchars($row['lname'] . ', ' . $row['fname'] . ' ' . $row['mname']) ?></td>
                                        <td style="width: 20%;"><?= htmlspecialchars($row['employeeID']) ?></td>
                                        <td style="width: 15%;"><?= htmlspecialchars($row['department']) ?></td>
                                        <td style="width: 20%;"><?= date('F j, Y h:i A', strtotime($row['request_date'])) ?></td>
                                        <td style="width: 15%;">
                                            <button class="btn btn-primary"><a href="profileReq.php?users_id=<?php echo $row['users_id']; ?>" style="text-decoration: none; color: #fff;">View</a></button>
                                            <button onclick="openAcceptModal(<?php echo $row['users_id']; ?>)" class="btn btn-success">Validate</button>
                                            <button onclick="openRejectModal(<?php echo $row['users_id']; ?>)" class="btn btn-danger mt-1">Reject</button>
                                        </td>
                                    </tr>
                                    <?php $num++; ?>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr style="display: table; width: 100%; table-layout: fixed;">
                                    <td colspan="6" class="text-center">No request employees found.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                    <?= renderRequestPaginationControls($currentUrl, $requestPage, $requestTotalPages, $requestPerPage, $requestSortColumn, $requestSortOrder); ?>
                </div>
                <!-- ======================= ACCEPT MODAL ============================== -->
                <div class="modal fade" id="acceptModal" tabindex="-1" aria-labelledby="acceptModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <form method="POST" action="../../auth/authentications.php" class="modal-content">
                            <?php isset($_SESSION["csrf_token"]) && $_SESSION["csrf_token"] !== "" ? $csrf = $_SESSION["csrf_token"] : " null "; ?>
                            <input type="hidden" name="csrf_token" value="<?php echo $csrf; ?>">
                            <input type="hidden" name="acceptEmployee" value="true">
                            <input type="hidden" name="employeeId" id="acceptEmployeeId" value="">
                            <div class="modal-header">
                                <h5 class="modal-title" id="acceptModalLabel">Confirm Accept</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p>Are you sure you want to Validate this user as an employee?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-success">Validate</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- ======================= REJECT MODAL ============================== -->
                <div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <form method="POST" action="../../auth/authentications.php" class="modal-content">
                        <?php isset($_SESSION["csrf_token"]) && $_SESSION["csrf_token"] !== "" ? $csrf = $_SESSION["csrf_token"] : " null "; ?>
                        <input type="hidden" name="csrf_token" value="<?php echo $csrf; ?>">
                        <input type="hidden" name="rejectEmployee" value="true">
                        <input type="hidden" name="employeeId" id="rejectEmployeeId" value="">
                        <div class="modal-header">
                            <h5 class="modal-title" id="rejectModalLabel">Confirm Reject</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure you want to reject this employee?</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-danger">Reject</button>
                        </div>
                        </form>
                    </div>
                </div>
                <!-- ======================= EMPLOYEE REJECTED LIST ============================== -->
                <div id="rejectedSearch" class="search-rejected flex-row justify-content-evenly mx-0 my-1 align-items-center gap-2 rounded-2" style="width: 95%; display: none;">
                    <div class="search-bar d-flex align-items-center justify-content-start" style="width: 80%; transform: translateX(-10px);">
                        <div class="search-active position-relative w-100 ms-2 d-flex align-items-center justify-content-start">
                            <input type="text" class="form-control ps-5" id="searchRejectedInput" placeholder="Search...">
                            <i class="fa-solid fa-magnifying-glass position-absolute" style="top: 50%; left: 15px; transform: translateY(-50%); color: gray;"></i>
                        </div>
                    </div>
                    <?= renderRejectSortAndPerPageControls($currentUrl, $rejectedPerPage, $rejectedSortColumn, $rejectedSortOrder); ?>
                </div>

                <div class="rejected-employee-list" id="rejectedList" style="width: 95%; margin: 20px auto; height: 50vh; display: none; flex-direction: column;">
                    <table class="table table-bordered table-striped mt-3" style="width: 100%; border-collapse: separate; flex: 1 1 auto; display: block;">
                        <thead style="display: table-header-group; width: 100%; background: white; position: sticky; top: 0; z-index: 10; color: #000;">
                            <tr style="display: table; width: 100%; table-layout: fixed;">
                                <th style="width: 5%;">#</th>
                                <th style="width: 25%;">Employee Name</th>
                                <th style="width: 20%;">Emplyee ID</th>
                                <th style="width: 15%;">Department</th>
                                <th style="width: 20%;">Date Rejected</th>
                                <th style="width: 15%;">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="rejectedList" style="display: block; overflow-y: auto; height: calc(50vh - 50px); width: 99.8%; margin-left: 2px;">
                            <?php if (!empty($rejectEmployees)): ?>
                                <?php $num = 1; ?>
                                <?php foreach($rejectEmployees as $row): ?>
                                    <tr style="display: table; width: 100%; table-layout: fixed;">
                                        <td style="width: 5%;"><?= $num ?></td>
                                        <td style="width: 25%;"><?= htmlspecialchars($row['lname'] . ', ' . $row['fname'] . ' ' . $row['mname']) ?></td>
                                        <td style="width: 20%;"><?= htmlspecialchars($row['employeeID']) ?></td>
                                        <td style="width: 15%;"><?= htmlspecialchars($row['department']) ?></td>
                                        <td style="width: 20%;"><?= date('F j, Y h:i A', strtotime($row['request_date'])) ?></td>
                                        <td style="width: 15%;">
                                            <button onclick="openAcceptModal(<?php echo $row['users_id']; ?>)" class="btn btn-success">Validate</button>
                                            <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" onclick="setDeleteId(<?= $row['users_id'] ?>)">Delete</button>
                                        </td>
                                    </tr>
                                    <?php $num++; ?>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr style="display: table; width: 100%; table-layout: fixed;">
                                    <td colspan="6" class="text-center">No rejected employees found.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                    <?= renderRejectPaginationControls($currentUrl, $rejectedPage, $rejectedTotalPages, $rejectedPerPage, $rejectedSortColumn, $rejectedSortOrder); ?>
                </div>
            </div>
        </div>
    </div>
</main>
<div id="loadingAnimation" style="display:none;">
  <div class="loading-lines">
    <div class="line"></div>
    <div class="line"></div>
    <div class="line"></div>
  </div>
</div>
<script>
    function getRequest() {
        fetchPendingCount(); 
    }
    window.onload = function () {
        const urlParams = new URLSearchParams(window.location.search);
        const tab = urlParams.get("tab");

        switch (tab) {
            case "accept":
                if (typeof getValidated === "function") getValidated();
                break;
            case "reject":
                if (typeof getRejected === "function") getRejected();
                break;
            case "request":
                if (typeof getRequest === "function") getRequest();
                break;
        }
    };
      document.getElementById("searchRejectedInput").addEventListener("input", function () {
        const filter = this.value.toLowerCase();
        const rows = document.querySelectorAll("#rejectedList tr");

        rows.forEach(row => {
            if (row.querySelectorAll("td").length < 6) return;
            const rowText = row.textContent.toLowerCase();
            row.style.display = rowText.includes(filter) ? "table" : "none";
        });
    });
    document.getElementById("searchRequestInput").addEventListener("input", function () {
        const filter = this.value.toLowerCase();
        const rows = document.querySelectorAll("#requestList tbody tr");

        rows.forEach(row => {
            if (row.querySelectorAll("td").length < 6) return;

            const rowText = row.textContent.toLowerCase();
            row.style.display = rowText.includes(filter) ? "table" : "none";
        });
    });
    document.getElementById("searchValidatedInput").addEventListener("input", function () {
        const filter = this.value.toLowerCase();
        const rows = document.querySelectorAll("#validatedList tbody tr");

        rows.forEach(row => {
            if (row.querySelectorAll("td").length < 6) return;

            const rowText = row.textContent.toLowerCase();
            row.style.display = rowText.includes(filter) ? "table" : "none";
        });
    });
</script>
<?php include '../../templates/Ufooter.php'?>