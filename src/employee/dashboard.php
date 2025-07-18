<?php include '../../templates/Uheader.php';  include '../../templates/HN.php';?>
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
        <?= renderHeaderEmployee() ?>


        <div class="d-flex w-100 align-items-start" style="height: 91%">
            <?= renderNavEmployee() ?>
            <div class="contents w-100 h-100 d-flex flex-column align-items-center p-0 m-0">
                <div class="header-employee m-0 d-flex flex-row justify-content-start align-items-center col-md-11 flex-wrap" style="height: 5rem !important;">
                    <div class="h1 col-md-4 col-12 m-0">
                        <h3 class="h3-employee m-0">DASHBOARD</h3>
                    </div>
                </div>
                <div class="dashboardContainer d-flex justify-content-start col-md-11 col-11 flex-wrap">
                    <div class="leaveCounts col-md-3 rounded-5 col-12 m-0 d-flex flex-column justify-content-start align-items-center shadow p-3 py-4">
                        <h5 class="w-100 m-0 text-start ms-5 mb-3">Leave Credits left</h5>
                        <p class="w-100 m-0 text-start ms-5">Vacation Leave: <span class="fw-bold"> <?php echo $getEmployeeLeaveCounts["VacationBalance"]; ?> </span></p>
                        <p class="w-100 m-0 text-start ms-5">Sick Leave: <span class="fw-bold"> <?php echo $getEmployeeLeaveCounts["SickBalance"]; ?> </span></p>
                        <p class="w-100 m-0 text-start ms-5">Special Leave: <span class="fw-bold"> <?php echo $getEmployeeLeaveCounts["SpecialBalance"]; ?> </span></p>
                        <p class="w-100 m-0 text-start ms-5">Others Leave: <span class="fw-bold"> <?php echo $getEmployeeLeaveCounts["OthersBalance"]; ?> </span></p>
                    </div>
                </div>
                <?php echo mediaNavEmployee() ?>
            </div>
        </div>
    </div>

</main>
<?php include '../../templates/Ufooter.php'?>