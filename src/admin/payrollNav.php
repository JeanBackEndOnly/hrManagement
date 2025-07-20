<?php
 include '../../templates/Uheader.php';
 include '../../templates/HN.php';
?>
<style>
.payroll {
    background: linear-gradient(40deg, #E53935, #e53835c2, #e538358f, #e538352f) !important;
    color: #fff !important;
}

.payrollP {
    color: #fff !important;
    font-weight: bold !important;
}
</style>
<main>
     <!-- <li class="my-1"><a class="p-2 d-flex m-0" href="payroll/process.php"><i class="fa-solid text-black me-1 fa-users-gear"></i>PROCESS</a></li>
    <li class="my-1"><a class="p-2 d-flex m-0" href="payroll/Config.php"><i class="fa-solid text-black me-1 fa-file-export"></i>CONFIG</a></li>
    <li class="my-1"><a class="p-2 d-flex m-0" href="payroll/Reports.php"><i class="fa-solid text-black me-1 fa-briefcase"></i>REPORTS</a></li>
    <li class="my-1"><a class="p-2 d-flex m-0" href="payroll/Deduction Slip.php"><i class="fa-solid text-black me-1 fa-file-export"></i>DEDUCTION SLIP</a></li>
    <li class="my-1"><a class="p-2 d-flex m-0" href="payroll/Loan Request.php"><i class="fa-solid text-black me-1 fa-briefcase"></i>LOAN REQUEST</a></li> -->
    <div class="main-body w-100 h-100 m-0 p-0">
        <?php echo renderHeader() ?>
        <div class="d-flex w-100 align-items-start" style="height: 91%">
            <?php renderNav() ?>
            <div class="contents w-100 h-100 d-flex flex-column align-items-center p-0 m-0">
                <div class="header-employee d-flex flex-row justify-content-between align-items-center " style="height: 7rem; width: 95%;">
                    <div class="h1 AnimationFinalfirst">
                        <h3 class="m-0 titleFont">PAYTOLL MANAGEMENT</h3>
                        <p style="font-size: 17px !important; margin-top: -1rem !important;"><span>payroll Navigations</span></p>
                    </div>
                </div>
                <div class="col-md-11 col-11 d-flex flex-wrap m-0 p-0 justify-content-start align-items-center">
                     <!-- <a href="employee.php" class="col-md-5 text-black m-0 p-2 px-3 rounded-2 col-11 navigationsContents mt-2 me-4 AnimationFinalfirst h-auto d-flex h-100 align-items-center">
                        <i class="fa-solid fa-circle me-3" style="color: rgb(7, 207, 7)"></i>
                        <i class="fa-solid fa-users mx-1"></i>
                        <h5 class="m-0 p-0 fw-bold text-muted">EMPLOYEE MANAGEMENT</h5>
                    </a>
                    <a href="leave.php" class="col-md-5 text-black m-0 p-2 px-3 rounded-2 col-11 navigationsContents mt-2 me-4 AnimationFinalfirst h-auto d-flex h-100 align-items-center">
                        <i class="fa-solid fa-circle me-3" style="color: rgb(7, 207, 7)"></i>
                        <i class="fa-solid fa-users mx-1"></i>
                        <h5 class="m-0 p-0 fw-bold text-muted">LEAVE REQUEST</h5>
                    </a>
                     <a href="job.php" class="col-md-5 text-black m-0 p-2 px-3 rounded-2 col-11 navigationsContents mt-2 me-4 AnimationFinalfirst h-auto d-flex h-100 align-items-center">
                        <i class="fa-solid fa-circle me-3" style="color: rgb(7, 207, 7)"></i>
                        <i class="fa-solid fa-users mx-1"></i>
                        <h5 class="m-0 p-0 fw-bold text-muted">JOB & SALARY</h5>
                    </a>
                     <a href="reports.php" class="col-md-5 text-black m-0 p-2 px-3 rounded-2 col-11 navigationsContents mt-2 me-4 AnimationFinalfirst h-auto d-flex h-100 align-items-center">
                        <i class="fa-solid fa-circle me-3" style="color: rgb(7, 207, 7)"></i>
                        <i class="fa-solid fa-users mx-1"></i>
                        <h5 class="m-0 p-0 fw-bold text-muted">REPORTS</h5>
                    </a> -->
                </div>
            </div>
        </div>
    </div>
</main>


<?php
 include '../../templates/Ufooter.php';
?>