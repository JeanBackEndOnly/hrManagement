<?php
 include '../../templates/Uheader.php';
 include '../../templates/HN.php';
?>
<style>
.reportsHightLight {
    background: linear-gradient(40deg, #E53935, #e53835c2, #e538358f, #e538352f) !important;
    color: #fff !important;
}

.reportsP{
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
                <div class="header-employee d-flex flex-row justify-content-between align-items-center " style="height: 7rem; width: 95%;">
                     <div class="h1 AnimationFinalfirst">
                        <h3 class="m-0 titleFont">LEAVE MANAGEMENT</h3>
                        <p style="font-size: 17px !important; margin-top: -1rem !important;"><span>Manage reports</span></p>
                    </div>
                </div>
                <div class="search-titles AnimationFinalsecond flex-row justify-content-evenly mx-0 my-1 align-items-center gap-2 rounded-2" style="width: 95%; display: flex;" id="headerTableReport">
                    <div class="search-bar d-flex align-items-center justify-content-start" style="width: 70%; transform: translateX(-10px);">
                        <div class="search-active position-relative w-100 ms-2 d-flex align-items-center justify-content-start">
                            <input type="text" class="form-control ps-5" placeholder="Search..." id="reportsSearchInput">
                            <i class="fa-solid fa-magnifying-glass position-absolute" style="top: 50%; left: 15px; transform: translateY(-50%); color: gray;"></i>
                        </div>
                    </div>
                    <?php
                    $currentUrl = basename($_SERVER['PHP_SELF']);
                    $dateFilter = $_GET['dateFilter'] ?? 'all';
                    $reportsPerPage = getPerPage('reports_perPage');
                    $reportSortColumn = getSortColumn('reports_sort', 'report_date');
                    $reportSortOrder = getSortOrder('reports_order', 'desc');

                    function buildReportQueryString($params) {
                        return http_build_query($params);
                    }
                    ?>
                    <div class="date" style="width: 10%;">
                        <select class="form-select" onchange="location.href='<?= $currentUrl ?>?<?= buildReportQueryString(['dateFilter' => 'all', 'reports_perPage' => $reportsPerPage, 'reports_sort' => $reportSortColumn, 'reports_order' => $reportSortOrder]) ?>' + (this.value !== 'all' ? '&dateFilter=' + this.value : '')">
                            <option disabled>Date</option>
                            <option value="all" <?= $dateFilter == 'all' ? 'selected' : '' ?>>All Time</option>
                            <option value="today" <?= $dateFilter == 'today' ? 'selected' : '' ?>>Today</option>
                            <option value="week" <?= $dateFilter == 'week' ? 'selected' : '' ?>>This Week</option>
                            <option value="month" <?= $dateFilter == 'month' ? 'selected' : '' ?>>This Month</option>
                            <option value="year" <?= $dateFilter == 'year' ? 'selected' : '' ?>>This Year</option>
                        </select>
                    </div>
                    <div class="count" style="width: 8%;">
                        <select class="form-select" onchange="location.href='<?= $currentUrl ?>?<?= buildReportQueryString(['reports_perPage' => 'REPLACE_ME', 'reports_sort' => $reportSortColumn, 'reports_order' => $reportSortOrder, 'dateFilter' => $dateFilter]) ?>'.replace('REPLACE_ME', this.value)">
                            <option disabled>Items</option>
                            <option value="10" <?= ($reportsPerPage == 10) ? 'selected' : '' ?>>10</option>
                            <option value="20" <?= ($reportsPerPage == 20) ? 'selected' : '' ?>>20</option>
                            <option value="50" <?= ($reportsPerPage == 50) ? 'selected' : '' ?>>50</option>
                        </select>
                    </div>
                    <div class="sort" style="width: 8%;">
                        <select class="form-select" onchange="location.href='<?= $currentUrl ?>?<?= buildReportQueryString(['reports_perPage' => $reportsPerPage, 'reports_sort' => $reportSortColumn, 'reports_order' => 'REPLACE_ME', 'dateFilter' => $dateFilter]) ?>'.replace('REPLACE_ME', this.value)">
                            <option disabled <?= (!in_array($reportSortOrder, ['asc', 'desc'])) ? 'selected' : '' ?>>Sort</option>
                            <option value="asc" <?= ($reportSortOrder == 'asc') ? 'selected' : '' ?>>A-Z</option>
                            <option value="desc" <?= ($reportSortOrder == 'desc') ? 'selected' : '' ?>>Z-A</option>
                        </select>
                    </div>
                </div>
                <div class="report-list AnimationFinalthird" style="width: 95%; margin: 10px auto; height: 50vh; display: flex; flex-direction: column;" id="reportList">
                    <table id="reportsTableBody" class="table table-bordered table-striped mt-3" style="width: 100%; border-collapse: separate; flex: 1 1 auto; display: block;">
                        <thead style="display: table-header-group; width: 100%; background: white; position: sticky; top: 0; z-index: 10; color: #000;">
                            <tr style="display: table; width: 100%; table-layout: fixed;">
                                <th class="col-md-1">#</th>
                                <th class="col-md-3">
                                    <a href="<?= $currentUrl ?>?<?= buildReportQueryString(['reports_sort' => 'lname', 'reports_order' => ($reportSortColumn === 'lname' && $reportSortOrder === 'asc') ? 'desc' : 'asc', 'reports_perPage' => $reportsPerPage, 'reports_page' => 1, 'dateFilter' => $dateFilter]) ?>" style="color:black; text-decoration:none;">
                                        Name <?= $reportSortColumn === 'lname' ? ($reportSortOrder === 'asc' ? '▲' : '▼') : '' ?>
                                    </a>
                                </th>
                                <th class="col-md-2">Details</th>
                                <th class="col-md-2">Department</th>
                                <th class="col-md-2">
                                    <a href="<?= $currentUrl ?>?<?= buildReportQueryString(['reports_sort' => 'report_date', 'reports_order' => ($reportSortColumn === 'report_date' && $reportSortOrder === 'asc') ? 'desc' : 'asc', 'reports_perPage' => $reportsPerPage, 'reports_page' => 1, 'dateFilter' => $dateFilter]) ?>" style="color:black; text-decoration:none;">
                                        Report Date <?= $reportSortColumn === 'report_date' ? ($reportSortOrder === 'asc' ? '▲' : '▼') : '' ?>
                                    </a>
                                </th>
                                <th class="col-md-1">Actions</th>
                            </tr>
                        </thead>
                        <tbody style="display: block; overflow-y: auto; height: calc(50vh - 50px); width: 99.8%; margin-left: 2px;">
                         <?php 
                            $reportData = getReports($reportsPerPage, $reportOffset, $reportSortColumn, $reportSortOrder, $whereClause);
                            $reports = $reportData['reports'];
                            $allLeaveRequests = $reportData['all_leave_requests'];

                            if (!empty($reports) || !empty($allLeaveRequests)): ?>
                                <?php 
                                $num = $reportOffset + 1;
                                $processedLeaveIds = [];
                                
                                foreach ($allLeaveRequests as $leave): 
                                    if (in_array($leave['leave_id'], $processedLeaveIds)) continue;
                                    $processedLeaveIds[] = $leave['leave_id'];
                                    
                                    $reportForLeave = null;
                                    foreach ($reports as $report) {
                                        if ($report['leave_id'] == $leave['leave_id']) {
                                            $reportForLeave = $report;
                                            break;
                                        }
                                    }
                                ?>
                                    <tr>
                                        <td class="col-md-1"><?= $num++ ?></td>
                                        <td class="col-md-3"><?= htmlspecialchars($leave['lname']) ?>, <?= htmlspecialchars($leave['fname']) ?></td>
                                        <td class="col-md-2">
                                            <?php if ($leave['leaveStatus'] === 'approved'): ?>
                                                <p style="color: green;">Leave Request Approved!</p>
                                            <?php elseif ($leave['leaveStatus'] === 'disapprove'): ?>
                                                <p style="color: red;">Leave Request Disapproved!</p>
                                            <?php else: ?>
                                                <p>Requesting for leave!</p>
                                            <?php endif; ?>
                                            <small><?= htmlspecialchars($leave['leaveType']) ?> - <?= date('M d, Y', strtotime($leave['leaveDate'])) ?></small>
                                        </td>
                                        <td class="col-md-2"><?= htmlspecialchars($leave['department']) ?></td>
                                        <td class="col-md-2"><?= $reportForLeave ? date('F j, Y h:i A', strtotime($reportForLeave['report_date'])) : date('F j, Y h:i A', strtotime($leave['request_date'])) ?></td>
                                        <td class="col-md-1">
                                            <?php if ($leave['leaveStatus'] === 'approved'): ?>
                                                <a class="btn btn-sm btn-primary" 
                                                    href="leave.php?users_id=<?= $leave['users_id'] ?>&leave_id=<?= $leave['leave_id'] ?>&open_pdf=1">
                                                    View
                                                </a>
                                            <?php elseif ($leave['leaveStatus'] === 'disapprove'): ?>
                                                <a class="btn btn-sm btn-primary" 
                                                    href="leave.php?users_id=<?= $leave['users_id'] ?>&leave_id=<?= $leave['leave_id'] ?>&open_pdf=1">
                                                    View
                                                </a>
                                            <?php else: ?>
                                                <a class="btn btn-sm btn-primary" 
                                                    href="employeeLeaveReq.php?users_id=<?= $leave['users_id'] ?>&leave_id=<?= $leave['leave_id'] ?>">
                                                    View
                                                </a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>

                                <?php foreach ($reports as $row): 
                                    if (empty($row['leave_id']) || !in_array($row['report_type'], ['PendingLeave', 'approvedLeave', 'disapprovedLeave'])): 
                                ?>
                                    <tr>
                                        <td style="width: 5%;"><?= $num++ ?></td>
                                        <td style="width: 24.%;"><?= htmlspecialchars($row['lname']) ?>, <?= htmlspecialchars($row['fname']) ?></td>
                                        <td style="width: 25%;">
                                            <?php switch ($row['report_type']):
                                                case 'employeeRegistration': echo "Requesting for validation!"; break;
                                                case 'employeePromotion': 
                                                    echo '<p style="color: green;">Got Promoted to ' . htmlspecialchars($row['jobTitle']) . '</p>'; 
                                                    break;
                                                case 'employeeRejected': echo '<p style="color: red;">Employee Rejected!</p>'; break;
                                                case 'employeeValidated': echo '<p style="color: green;">Employee Validated!</p>'; break;
                                                default: echo "No valid variable found!";
                                            endswitch; ?>
                                        </td>
                                        <td style="width: 20%;"><?= htmlspecialchars($row['department']) ?></td>
                                        <td style="width: 20%;"><?= date('F j, Y h:i A', strtotime($row['report_date'])) ?></td>
                                        <td style="width: 10%;">
                                            <?php switch ($row['report_type']):
                                                case 'employeeRegistration':
                                                    echo '<a class="btn btn-sm btn-primary" href="employee.php?tab=request">View</a>';
                                                    break;
                                                case 'employeePromotion':
                                                    echo '<a class="btn btn-sm btn-primary" href="job.php?tab=salaryManage">View</a>';
                                                    break;
                                                case 'employeeRejected':
                                                    echo '<a class="btn btn-sm btn-primary" href="employee.php?tab=reject">View</a>';
                                                    break;
                                                case 'employeeValidated':
                                                    echo '<a class="btn btn-sm btn-primary" href="profile.php?users_id='.$row["users_id"].'">View</a>';
                                                    break;
                                                default: echo "No link available";
                                            endswitch; ?>
                                        </td>
                                    </tr>
                                <?php endif; endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="6" class="text-center">No reports found.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>

                    <div class="d-flex justify-content-between align-items-center mt-1" style="flex-shrink: 0;">
                        <div>
                            Page <?= $reportPage ?> of <?= $reportTotalPages ?>
                        </div>
                        <div>
                            <a href="<?= $currentUrl ?>?<?= buildReportQueryString(['reports_page' => max(1, $reportPage - 1), 'reports_perPage' => $reportsPerPage, 'reports_sort' => $reportSortColumn, 'reports_order' => $reportSortOrder, 'dateFilter' => $dateFilter]) ?>" class="btn btn-sm btn-outline-primary <?= ($reportPage <= 1) ? 'disabled' : '' ?>">Previous</a>
                            <a href="<?= $currentUrl ?>?<?= buildReportQueryString(['reports_page' => min($reportTotalPages, $reportPage + 1), 'reports_perPage' => $reportsPerPage, 'reports_sort' => $reportSortColumn, 'reports_order' => $reportSortOrder, 'dateFilter' => $dateFilter]) ?>" class="btn btn-sm btn-outline-primary <?= ($reportPage >= $reportTotalPages) ? 'disabled' : '' ?>">Next</a>
                        </div>
                    </div>
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
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('reportsSearchInput');
        const tableRows = document.querySelectorAll('#reportsTableBody tbody tr');

        searchInput.addEventListener('input', function () {
            const filter = this.value.toLowerCase();

            tableRows.forEach(row => {
                const nameCell = row.children[1]?.textContent.toLowerCase();
                const deptCell = row.children[3]?.textContent.toLowerCase();

                if (nameCell.includes(filter) || deptCell.includes(filter)) {
                    row.style.display = 'table';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    });
</script>
<?php include '../../templates/Ufooter.php'?>