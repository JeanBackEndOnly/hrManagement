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


        <div class="d-flex w-100 align-items-start" style="height: auto;">
            <?= renderNavEmployee() ?>
            <div class="contents w-100 h-100 d-flex flex-column align-items-center p-0 m-0">
                <div class="header-employee mediaTitleMargin m-0 d-flex flex-row justify-content-start align-items-center col-md-11 flex-wrap" style="height: 5rem !important;">
                    <div class="h1 AnimationFinalfirst">
                        <h3 class="m-0 titleFont">DASHBOARD</h3>
                        <p style="font-size: 17px !important; margin-top: -1rem !important;"><span>Here are your some important features</span></p>
                    </div>
                </div>
                <div class="dashboardContainer d-flex justify-content-start col-md-11 col-11 flex-wrap">
                    <div class="pending BGdashboardContents hoverDashboard AnimationFinalfirst shadow-sm rounded-2 p-2 d-flex flex-column justify-content-center align-items-center bg-white me-3 mt-3 col-md-6 col-12" style="min-height: 100px; text-decoration: none;">
                        <h5 class="w-100 m-0 text-start ms-5 text-muted fw-bold fs-3">Leave Credits left</h5>
                        <p class="w-100 m-0 text-start ms-5 text-muted fw-bold ">Vacation Leave: <span class="fw-bold"> <?php echo $getEmployeeLeaveCounts["VacationBalance"]; ?> </span></p>
                        <p class="w-100 m-0 text-start ms-5 text-muted fw-bold ">Sick Leave: <span class="fw-bold"> <?php echo $getEmployeeLeaveCounts["SickBalance"]; ?> </span></p>
                        <p class="w-100 m-0 text-start ms-5 text-muted fw-bold ">Special Leave: <span class="fw-bold"> <?php echo $getEmployeeLeaveCounts["SpecialBalance"]; ?> </span></p>
                        <p class="w-100 m-0 text-start ms-5 text-muted fw-bold ">Others Leave: <span class="fw-bold"> <?php echo $getEmployeeLeaveCounts["OthersBalance"]; ?> </span></p>
                    </div>
                </div>
                <?= mediaNavEmployee() ?>
            </div>
        </div>
    </div>

</main>
<?php include '../../templates/Ufooter.php'?>