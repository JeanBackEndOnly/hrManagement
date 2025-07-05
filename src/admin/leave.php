<?php include '../../templates/Uheader.php';?>
<?php if (isset($_GET['open_pdf']) && $_GET['open_pdf'] == '1') : ?>
<script>
    window.onload = function () {
        window.open('pdfGenerator.php?users_id=<?php echo $_GET["users_id"]; ?>&leave_id=<?php echo $_GET["leave_id"]; ?>', '_blank');
    };
</script>
<?php endif;  ?>
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
                        <li class="my-1"><a href="payroll/process.php"><i class="fa-solid me-1 fa-users-gear"></i>PROCESS</a></li>
                        <li class="my-1"><a href="payroll/Config.php"><i class="fa-solid me-1 fa-file-export"></i>CONFIG</a></li>
                        <li class="my-1"><a href="payroll/Reports.php"><i class="fa-solid me-1 fa-briefcase"></i>REPORTS</a></li>
                        <li class="my-1"><a href="payroll/Deduction Slip.php"><i class="fa-solid me-1 fa-file-export"></i>DEDUCTION SLIP</a></li>
                        <li class="my-1"><a href="payroll/Loan Request.php"><i class="fa-solid me-1 fa-briefcase"></i>LOAN REQUEST</a></li>
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
            <?php
            
            $currentUrl = strtok($_SERVER['REQUEST_URI'], '?');
            ?>

            <div class="contents w-100 h-100 d-flex flex-column align-items-center p-0 m-0">

                <div class="header-employee d-flex flex-wrap col-md-12 flex-row justify-content-between align-items-center"
                    style="height: 7rem; width: 95%;">
                    <div class="h1 flex-row col-md-5 col-12 align-items-center justify-content-start" style="display:flex;">
                        <h3 class="m-0">LEAVE REQUESTS</h3>
                    </div>

                    <div class="leaveTabButtons d-flex flex-row col-md-5 col-12 align-items-center justify-content-between">
                        <?php
                        $tabs = ['request' => 'REQUEST', 'approved' => 'APPROVED', 'disapproved' => 'DISAPPROVED'];
                        foreach ($tabs as $key => $label): ?>
                            <div class="crud-employee d-flex flex-row col-md-4 col-12 align-items-center justify-content-end"
                                style="width: 32%; height: 2rem">
                                <button type="button"
                                        class="tab-btns w-100 <?= $leaveTab === $key ? 'active' : '' ?>"
                                        onclick="location.href='<?= $currentUrl ?>?leave_tab=<?= $key ?>'"
                                        style="font-size:15px;border:none;box-shadow:none;">
                                    <?= $label ?>
                                </button>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="search-leave flex-row justify-content-evenly mx-0 my-1 align-items-center gap-2 rounded-2"
                    style="width: 95%; display:flex;">
                    <div class="search-bar d-flex align-items-center justify-content-start"
                        style="width: 80%; transform: translateX(-10px);">
                        <div class="search-active position-relative w-100 ms-2 d-flex align-items-center justify-content-start">
                            <input type="text" class="form-control ps-5" placeholder="Search..."
                                id="leaveSearchInput"
                                value="<?= htmlspecialchars($_GET['leave_q'] ?? '') ?>">
                            <i class="fa-solid fa-magnifying-glass position-absolute"
                            style="top:50%; left:15px; transform:translateY(-50%); color:gray;"></i>
                        </div>
                    </div>

                    <div class="count" style="width:8%;">
                        <select class="form-select"
                                onchange="location.href='<?= $currentUrl ?>?leave_tab=<?= $leaveTab ?>&leave_perPage='+this.value">
                            <option disabled>Items</option>
                            <?php foreach ([10,20,50] as $opt): ?>
                                <option value="<?= $opt ?>" <?= $leavePerPage == $opt ? 'selected':'' ?>><?= $opt ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="sort" style="width:8%;">
                        <select class="form-select"
                                onchange="location.href='<?= $currentUrl ?>?leave_tab=<?= $leaveTab ?>&leave_sort=request_date&leave_order='+this.value">
                            <option disabled selected>Sort</option>
                            <option value="asc"  <?= $leaveSortOrder==='asc'  ? 'selected':'' ?>>Oldest</option>
                            <option value="desc" <?= $leaveSortOrder==='desc' ? 'selected':'' ?>>Recent</option>
                        </select>
                    </div>
                </div>

                <div class="leave-list" style="width:95%; margin:10px auto; height:50vh; display:flex; flex-direction:column;">
                    <table class="table table-bordered table-striped mt-3"
                        style="width:100%; border-collapse:separate; flex:1 1 auto; display:block;">
                        <thead style="display:table-header-group; width:100%; background:white; position:sticky; top:0; z-index:10;">
                            <tr style="display:table; width:100%; table-layout:fixed;">
                                <th style="width:5%;">#</th>
                                <th style="width:25%;">Employee</th>
                                <th style="width:25%;">Leave Type</th>
                                <th style="width:20%;">From‑To</th>
                                <th style="width:15%;">Status</th>
                                <th style="width:10%;">Actions</th>
                            </tr>
                        </thead>

                        <tbody style="display:block; overflow-y:auto; height:calc(50vh - 50px); width:99.8%; margin-left:2px;">
                            <?php if ($leaveData): ?>
                                <?php $no = ($leavePage - 1) * $leavePerPage + 1; ?>
                                <?php foreach ($leaveData as $row): ?>
                                    <tr data-row="leave" style="display:table; width:100%; table-layout:fixed;">
                                        <td style="width:5%;"><?= $no ?></td>
                                        <td style="width:25%;"><?= htmlspecialchars($row['lname'] . ', ' . $row['fname']) ?></td>
                                        <td style="width:25%;"><?= htmlspecialchars($row['leaveType']) ?></td>
                                        <td style="width:20%;">
                                            <?= date('M j',  strtotime($row['InclusiveFrom'])) ?>
                                            – <?= date('M j, Y', strtotime($row['InclusiveTo'])) ?>
                                        </td>
                                        <td style="width:15%;">
                                            <?php
                                            echo match ($row['leaveStatus']) {
                                                'approved'    => '<span class="text-success">Approved</span>',
                                                'disapprove' => '<span class="text-danger">Disapproved</span>',
                                                default       => 'Pending'
                                            };
                                            ?>
                                        </td>
                                        <td style="width:10%;">
                                            <a class="btn btn-sm btn-primary"
                                            href="employeeLeaveReq.php?users_id=<?= $row['users_id'] ?>&leave_id=<?= $row['leave_id'] ?>">
                                                View
                                            </a>
                                        </td>
                                    </tr>
                                    <?php $no++; ?>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr style="display:table; width:100%; table-layout:fixed;">
                                    <td colspan="6" class="text-center">No leaves found.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>

                    <div class="d-flex justify-content-between align-items-center mt-1" style="flex-shrink:0;">
                        <div>Page <?= $leavePage ?> of <?= $leaveTotalPages ?></div>
                        <div>
                            <a href="<?= $currentUrl ?>?leave_tab=<?= $leaveTab ?>&leave_page=<?= max(1,$leavePage-1) ?>&leave_perPage=<?= $leavePerPage ?>"
                            class="btn btn-sm btn-outline-primary <?= $leavePage<=1?'disabled':'' ?>">Previous</a>
                            <a href="<?= $currentUrl ?>?leave_tab=<?= $leaveTab ?>&leave_page=<?= min($leaveTotalPages,$leavePage+1) ?>&leave_perPage=<?= $leavePerPage ?>"
                            class="btn btn-sm btn-outline-primary <?= $leavePage>=$leaveTotalPages?'disabled':'' ?>">Next</a>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</main>
<script>
document.addEventListener('DOMContentLoaded', () => {

  const searchInput = document.getElementById('leaveSearchInput');
  const tbody       = document.querySelector('.leave-list tbody');
  if (!searchInput || !tbody) return;

  const rows = Array.from(tbody.querySelectorAll('tr[data-row="leave"]'));
  rows.forEach(r => {              // remember initial display (“table”)
    r._origDisplay = r.style.display || 'table';
    r._cacheText   = r.textContent.toLowerCase();   // cache full text once
  });

  searchInput.addEventListener('keyup', () => {
    const kw = searchInput.value.trim().toLowerCase();
    rows.forEach(row => {
      row.style.display = row._cacheText.includes(kw) ? row._origDisplay : 'none';
    });
  });
});
</script>

<?php include '../../templates/Ufooter.php'?>