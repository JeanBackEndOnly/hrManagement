<?php
 include '../../templates/Uheader.php';
 include '../../templates/HN.php';
?>
<style>
.hr {
    background: linear-gradient(40deg, #E53935, #e53835c2, #e538358f, #e538352f) !important;
    border-radius: 10px !important;
    border-radius: 10px !important;
    color: #fff !important;
}

.hrP,
.me-side-text1 {
    color: #fff !important;
    font-weight: bold !important;
}
</style>
<main>
    <div class="main-body w-100 h-100 m-0 p-0">
        <?php echo renderHeader() ?>
        
        <div class="d-flex w-100 align-items-start" style="height: 91%">
            
            <?php renderNav() ?>

            <div class="contents w-100 h-100 d-flex flex-column align-items-center p-0 m-0">
                <div class="header-employee col-md-12 d-flex flex-row flex-wrap justify-content-between align-items-center" style="height: 7rem; width: 95%;">
                    <div class="h1 AnimationFinalfirst">
                        <h3 class="m-0 titleFont">EMPLOYEE MANAGEMENT</h3>
                        <p style="font-size: 17px !important; margin-top: -1rem !important;">Welcome to Puericulture Web System <span>Manage Employee</span></p>
                    </div>
                    <div class="crud-employee d-flex flex-row justify-content-between me-3 col-md-5 col-12 AnimationFinalfirst" style="height: 2rem">
                        <button type="button" onclick="getValidated()" class="rounded-2 border-2" style="font-size:15px;" id="requet">Validated</button>
                        <button type="button" onclick="getRequest()" class="rounded-2 border-2" style="font-size: 15px;" id="requet">
                            Request <span id="pendingCountDisplay"></span>
                        </button>
                        <button type="button" onclick="getRejected()" class="rounded-2 border-2" style="font-size:15px;" id="reject">Rejected</button>
                        <button type="button" class="rounded-2 border-2" style="font-size:15px;" id="add"><a href="register.php" class="w-100 h-100 d-flex justify-content-center align-items-center" style="text-decoration: none; color: #000;">add</a></button>
                    </div>
                </div>

                <div class="titlesOfList d-flex justify-content-start m-0" id="ListTitles" style="width: 95%;">
                    <div class="Employee-list AnimationFinalfirst" id="validatedEmployees" style="display: flex;">
                        <h5>Validated Employee List</h5>
                    </div>
                    <div class="Employee-list AnimationFinalfirst" id="employeesRequest" style="display: none;">
                        <h5>Employee Request List</h5>
                    </div>
                    <div class="Employee-list AnimationFinalfirst" id="rejectedEmployees" style="display: none;">
                        <h5>Employee Rejected List</h5>
                    </div>
                </div>
                <!-- ======================= VALIDATED EMPLOYEE LIST ============================== -->
                <div id="validateSearch" class="search-validated AnimationFinalsecond flex-row justify-content-evenly mx-0 my-1 align-items-center gap-2 rounded-2" style="width: 95%; display: flex;">
                    <div class="search-bar d-flex align-items-center justify-content-start" style="width: 80%; transform: translateX(-10px);">
                        <div class="search-active position-relative w-100 ms-2 d-flex align-items-center justify-content-start">
                            <input type="text" class="form-control ps-5" id="searchValidatedInput" placeholder="Search...">
                            <i class="fa-solid fa-magnifying-glass position-absolute" style="top: 50%; left: 15px; transform: translateY(-50%); color: gray;"></i>
                        </div>
                    </div>
                    <?=renderValidatedSortAndPerPageControls($currentUrl, $validatedPerPage, $validatedSortColumn, $validatedSortOrder);?>
                </div>

                <div class="validated-employee-list AnimationFinalthird" id="validatedList" style="width: 95%; margin: 20px auto; height: 50vh; display: flex; flex-direction: column;">
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
                                            <button class="btn btn-primary"><a href="profile.php?tab=personal&users_id=<?php echo $row['users_id']; ?>" style="text-decoration: none; color: #fff;">View</a></button>
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
                <div id="requestSearch" class="search-request AnimationFinalsecond flex-row justify-content-evenly mx-0 my-1 align-items-center gap-2 rounded-2" style="width: 95%; display: none;">
                    <div class="search-bar d-flex align-items-center justify-content-start" style="width: 80%; transform: translateX(-10px);">
                        <div class="search-active position-relative w-100 ms-2 d-flex align-items-center justify-content-start">
                            <input type="text" class="form-control ps-5" id="searchRequestInput" placeholder="Search...">
                            <i class="fa-solid fa-magnifying-glass position-absolute" style="top: 50%; left: 15px; transform: translateY(-50%); color: gray;"></i>
                        </div>
                    </div>
                    <?= renderRequestSortAndPerPageControls($currentUrl, $requestPerPage, $requestSortColumn, $requestSortOrder); ?>
                </div>

                <div class="request-employee-list AnimationFinalthird" id="requestList" style="width: 95%; margin: 20px auto; height: 50vh; display: none; flex-direction: column;">
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
                <div id="rejectedSearch" class="search-rejected AnimationFinalsecond flex-row justify-content-evenly mx-0 my-1 align-items-center gap-2 rounded-2" style="width: 95%; display: none;">
                    <div class="search-bar d-flex align-items-center justify-content-start" style="width: 80%; transform: translateX(-10px);">
                        <div class="search-active position-relative w-100 ms-2 d-flex align-items-center justify-content-start">
                            <input type="text" class="form-control ps-5" id="searchRejectedInput" placeholder="Search...">
                            <i class="fa-solid fa-magnifying-glass position-absolute" style="top: 50%; left: 15px; transform: translateY(-50%); color: gray;"></i>
                        </div>
                    </div>
                    <?= renderRejectSortAndPerPageControls($currentUrl, $rejectedPerPage, $rejectedSortColumn, $rejectedSortOrder); ?>
                </div>

                <div class="rejected-employee-list AnimationFinalthird" id="rejectedList" style="width: 95%; margin: 20px auto; height: 50vh; display: none; flex-direction: column;">
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
<script src="../../assets/js/hr/employee.js"></script>
<?php include '../../templates/Ufooter.php'?>