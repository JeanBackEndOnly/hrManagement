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
    <div class="main-body w-100 h-100 m-0 p-0">
        <?php echo renderHeader() ?>
        <div class="d-flex w-100 align-items-start" style="height: 91%">
            <?php renderNav() ?>
            <div class="contents w-100 h-100 d-flex flex-column align-items-center p-0 m-0">
                <div class="header-employee d-flex flex-row justify-content-between align-items-center "
                    style="height: 7rem; width: 95%;">
                    <div class="h1 AnimationFinalfirst">
                        <h3 class="m-0 titleFont">PAYTOLL MANAGEMENT</h3>
                        <p style="font-size: 17px !important; margin-top: -1rem !important;"><span>payroll
                                Navigations</span></p>
                    </div>
                </div>
                <div class="col-md-11 col-11 d-flex flex-wrap m-0 p-0 justify-content-start align-items-center">
                    <!-- Include Bootstrap and Font Awesome -->
                    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
                        rel="stylesheet">
                    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
                        rel="stylesheet">

                    <style>
                        .payroll-card {
                            transition: transform 0.2s ease, box-shadow 0.2s ease;
                            border-left: 5px solid #0fd36c;
                        }

                        .payroll-card:hover {
                            transform: translateY(-3px);
                            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
                        }

                        .payroll-icon {
                            font-size: 1.8rem;
                            color: #0fd36c;
                        }

                        .payroll-title {
                            font-weight: 600;
                            color: #444;
                        }

                        .payroll-subtitle {
                            font-size: 0.9rem;
                            color: #888;
                        }
                    </style>

                    <div class="container mt-4">
                        <div class="row g-4">

    <!-- Leave & Attendance -->
    <div class="col-md-6 col-lg-4">
        <a href="#Leave_Attendance" class="text-decoration-none" title="Monitor attendance, absences, and overtime">
            <div class="card payroll-card p-3 h-100">
                <div class="d-flex align-items-center">
                    <i class="fa-solid fa-calendar-days payroll-icon me-3"></i>
                    <div>
                        <div class="payroll-title">Leave & Attendance</div>
                        <div class="payroll-subtitle">Track attendance, leaves, and work hours</div>
                    </div>
                </div>
            </div>
        </a>
    </div>

    <!-- Employee Records -->
    <div class="col-md-6 col-lg-4">
        <a href="#Employee_Records" class="text-decoration-none" title="Access and update employee information">
            <div class="card payroll-card p-3 h-100">
                <div class="d-flex align-items-center">
                    <i class="fa-solid fa-id-badge payroll-icon me-3"></i>
                    <div>
                        <div class="payroll-title">Employee Records</div>
                        <div class="payroll-subtitle">Manage personal and job details</div>
                    </div>
                </div>
            </div>
        </a>
    </div>

    <!-- Tax & Government Compliance -->
    <div class="col-md-6 col-lg-4">
        <a href="#Tax_Compliance" class="text-decoration-none" title="Ensure required contributions and forms are filed">
            <div class="card payroll-card p-3 h-100">
                <div class="d-flex align-items-center">
                    <i class="fa-solid fa-file-shield payroll-icon me-3"></i>
                    <div>
                        <div class="payroll-title">Tax & Compliance</div>
                        <div class="payroll-subtitle">BIR, SSS, Pag-IBIG, PhilHealth compliance</div>
                    </div>
                </div>
            </div>
        </a>
    </div>

    <!-- Salary Adjustments -->
    <div class="col-md-6 col-lg-4">
        <a href="#Salary_Adjustments" class="text-decoration-none" title="Handle pay changes due to promotions or corrections">
            <div class="card payroll-card p-3 h-100">
                <div class="d-flex align-items-center">
                    <i class="fa-solid fa-pen-to-square payroll-icon me-3"></i>
                    <div>
                        <div class="payroll-title">Salary Adjustments</div>
                        <div class="payroll-subtitle">Update for promotions or retro pay</div>
                    </div>
                </div>
            </div>
        </a>
    </div>

    <!-- Loan Requests -->
    <div class="col-md-6 col-lg-4">
        <a href="#Loan_Requests" class="text-decoration-none" title="Submit and track employee loan or cash advance requests">
            <div class="card payroll-card p-3 h-100">
                <div class="d-flex align-items-center">
                    <i class="fa-solid fa-money-bill-trend-up payroll-icon me-3"></i>
                    <div>
                        <div class="payroll-title">Loan Requests</div>
                        <div class="payroll-subtitle">Cash advances with approval tracking</div>
                    </div>
                </div>
            </div>
        </a>
    </div>

    <!-- Payroll Calendar -->
    <div class="col-md-6 col-lg-4">
        <a href="#Payroll_Calendar" class="text-decoration-none" title="Stay informed about payroll cutoffs and payment schedules">
            <div class="card payroll-card p-3 h-100">
                <div class="d-flex align-items-center">
                    <i class="fa-solid fa-calendar payroll-icon me-3"></i>
                    <div>
                        <div class="payroll-title">Payroll Calendar</div>
                        <div class="payroll-subtitle">Cutoff dates and salary release schedule</div>
                    </div>
                </div>
            </div>
        </a>
    </div>

    <!-- PhilHealth Integration -->
    <div class="col-md-6 col-lg-4">
        <a href="#PhilHealth" class="text-decoration-none" title="Automated PhilHealth contribution calculations and submissions">
            <div class="card payroll-card p-3 h-100">
                <div class="d-flex align-items-center">
                    <i class="fa-solid fa-heart-circle-check payroll-icon me-3"></i>
                    <div>
                        <div class="payroll-title">PhilHealth</div>
                        <div class="payroll-subtitle">Auto-calculated contributions</div>
                    </div>
                </div>
            </div>
        </a>
    </div>

    <!-- SSS Contribution -->
    <div class="col-md-6 col-lg-4">
        <a href="#SSS" class="text-decoration-none" title="SSS deductions and employer share based on the latest rates">
            <div class="card payroll-card p-3 h-100">
                <div class="d-flex align-items-center">
                    <i class="fa-solid fa-id-card payroll-icon me-3"></i>
                    <div>
                        <div class="payroll-title">SSS Contributions</div>
                        <div class="payroll-subtitle">Real-time SSS table integration</div>
                    </div>
                </div>
            </div>
        </a>
    </div>

    <!-- Pag-IBIG Fund -->
    <div class="col-md-6 col-lg-4">
        <a href="#PagIBIG" class="text-decoration-none" title="Track Pag-IBIG savings and loan contributions">
            <div class="card payroll-card p-3 h-100">
                <div class="d-flex align-items-center">
                    <i class="fa-solid fa-building-columns payroll-icon me-3"></i>
                    <div>
                        <div class="payroll-title">Pag-IBIG</div>
                        <div class="payroll-subtitle">Loan & savings contributions</div>
                    </div>
                </div>
            </div>
        </a>
    </div>

    <!-- BIR Form 2316 -->
    <div class="col-md-6 col-lg-4">
        <a href="#BIR2316" class="text-decoration-none" title="Automatically generate your annual income tax certificate">
            <div class="card payroll-card p-3 h-100">
                <div class="d-flex align-items-center">
                    <i class="fa-solid fa-file-invoice payroll-icon me-3"></i>
                    <div>
                        <div class="payroll-title">BIR Form 2316</div>
                        <div class="payroll-subtitle">Auto-filled tax certificate</div>
                    </div>
                </div>
            </div>
        </a>
    </div>

    <!-- 13th Month Pay -->
    <div class="col-md-6 col-lg-4">
        <a href="#13thMonthPay" class="text-decoration-none" title="Automatic computation and release of 13th month pay">
            <div class="card payroll-card p-3 h-100">
                <div class="d-flex align-items-center">
                    <i class="fa-solid fa-calendar-check payroll-icon me-3"></i>
                    <div>
                        <div class="payroll-title">13th Month Pay</div>
                        <div class="payroll-subtitle">Automated payout & schedule</div>
                    </div>
                </div>
            </div>
        </a>
    </div>

    <!-- DOLE Compliance -->
    <div class="col-md-6 col-lg-4">
        <a href="#DOLE" class="text-decoration-none" title="Ensure compliance with DOLE labor laws and alerts">
            <div class="card payroll-card p-3 h-100">
                <div class="d-flex align-items-center">
                    <i class="fa-solid fa-scale-balanced payroll-icon me-3"></i>
                    <div>
                        <div class="payroll-title">DOLE Compliance</div>
                        <div class="payroll-subtitle">Labor law integration & reminders</div>
                    </div>
                </div>
            </div>
        </a>
    </div>

</div>

                    </div>

                </div>
            </div>
        </div>
    </div>
</main>


<?php
include '../../templates/Ufooter.php';
?>