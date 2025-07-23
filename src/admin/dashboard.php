<?php
 include '../../templates/Uheader.php';
 include '../../templates/HN.php';
?>
<style>
    .dashboard{
    background: linear-gradient(40deg, #E53935, #e53835c2, #e538358f, #e538352f) !important;
        border-radius: 10px !important;
        border-radius: 10px !important;
        color: #fff !important;
    }
    .pdashboard, .me-side-text2{
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
                        <h3 class="m-0 titleFont">DASHBOARD</h3>
                        <p style="font-size: 17px !important; margin-top: -1rem !important;">Welcome to Puericulture Web System <span>DASHBOARD</span></p>
                    </div>
                </div>
                <div class="d-flex col-ms-12 flex-row justify-content-start align-items-center flex-wrap" style="height: 7rem; width: 95%;">
                   <a href="employee.php" class="btn-confirm pending BGdashboardContents hoverDashboard AnimationFinalfirst shadow-sm rounded-2 p-2 d-flex flex-column justify-content-center align-items-center bg-white me-3 mt-3 col-md-3 col-12" style="min-height: 100px; text-decoration: none;">
                        <div class="d-flex align-items-center mb-3">
                            <div class="text-center me-3">
                                <h1 class="fw-bold text-primary txtToWhite m-0"><?php echo $validatedCount; ?></h1>
                                <small class="text-secondary">Users</small>
                            </div>
                            <div class="text-start">
                                <h5 class="m-0 fw-semibold text-dark">Validated</h5>
                                <h6 class="m-0 text-muted">Employees</h6>
                            </div>
                        </div>
                    </a>
                    <a href="employee.php?tab=request" class="btn-confirm pending BGdashboardContents hoverDashboard AnimationFinalsecond shadow-sm rounded-2 p-2 d-flex flex-column justify-content-center align-items-center bg-white me-3 mt-3 col-md-3 col-12" style="min-height: 100px; text-decoration: none;">
                        <div class="d-flex align-items-center mb-3">
                            <div class="text-center me-3">
                                <h1 class="fw-bold text-primary txtToWhite m-0"><?php echo $pendingCount; ?></h1>
                                <small class="text-secondary">Users</small>
                            </div>
                            <div class="text-start">
                                <h5 class="m-0 fw-semibold text-dark">Pending</h5>
                                <h6 class="m-0 text-muted">Employees</h6>
                            </div>
                        </div>
                    </a>
                    <a href="reports.php" class="btn-confirm pending BGdashboardContents hoverDashboard AnimationFinalthird shadow-sm rounded-2 p-2 d-flex flex-column justify-content-center align-items-center bg-white me-3 mt-3 col-md-3 col-12" style="min-height: 100px; text-decoration: none;">
                        <div class="d-flex align-items-center mb-3">
                            <div class="text-center me-3">
                                <h1 class="fw-bold text-primary txtToWhite m-0">
                                    <span id="reportsCountDisplay">0</span>
                                </h1>
                                <small class="text-secondary">reports</small>
                            </div>
                            <div class="text-start">
                                <h5 class="m-0 fw-semibold text-dark">Today</h5>
                                <h6 class="m-0 text-muted">Reports</h6>
                            </div>
                        </div>
                    </a>

                    <a href="leave.php" class="btn-confirm leave BGdashboardContents hoverDashboard AnimationFinalLast shadow-sm rounded-2 p-2 d-flex flex-column justify-content-center align-items-center bg-white me-3 mt-3 col-md-3 col-12" style="min-height: 100px; text-decoration: none;">
                        <div class="d-flex align-items-center mb-3">
                            <div class="text-center me-3">
                                <h1 class="fw-bold text-primary txtToWhite m-0">
                                    <span id="leaveCountDisplay">0</span>
                                </h1>
                                <small class="text-secondary">request</small>
                            </div>
                            <div class="text-start">
                                <h5 class="m-0 fw-semibold text-dark">Leave</h5>
                                <h6 class="m-0 text-muted">Request</h6>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</main>
<script>
    function fetchReportsCount() {
        fetch('../functions/api.php')
            .then(response => response.json())
            .then(data => {
                console.log('Fetched data:', data); 
                const reportCount = data.reportsCount ?? 0;
                document.getElementById('reportsCountDisplay').textContent = reportCount;
            })
            .catch(error => {
                console.error('Error fetching data:', error);
            });
    }
    function fetchLeaveReqCount() {
        fetch('../functions/api.php')
            .then(response => response.json())
            .then(data => {
                console.log('Fetched data:', data); 
                const leavePendingCount = data.leavePendingCount ?? 0;
                document.getElementById('leaveCountDisplay').textContent = leavePendingCount;
            })
            .catch(error => {
                console.error('Error fetching data:', error);
            });
    }

    document.addEventListener('DOMContentLoaded', function () {
        fetchPendingCount(); 
        setInterval(fetchPendingCount, 5000); 
    });
    fetchReportsCount(); 
    fetchLeaveReqCount(); 
</script>
<?php include '../../templates/Ufooter.php'?>