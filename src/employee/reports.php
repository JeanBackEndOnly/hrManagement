<?php include '../../templates/Uheader.php';  include '../../templates/HN.php';?>
<?php if (isset($_GET['open_pdf']) && $_GET['open_pdf'] == '1') : ?>
<script>
    window.onload = function () {
        window.open('../admin/pdfGenerator.php?users_id=<?php echo $_GET["users_id"]; ?>&leave_id=<?php echo $_GET["leave_id"]; ?>', '_blank');
    };
</script>
<?php endif;  ?>
<style>
.hr {
    background: linear-gradient(40deg, #E53935, #e53835c2, #e538358f, #e538352f) !important;
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
        <?= renderHeaderEmployee() ?>


        <div class="d-flex w-100 align-items-start" style="height: 91%">
            <?= renderNavEmployee() ?>
            <div class="contents w-100 h-100 d-flex flex-column align-items-center p-0 m-0">
                <div class="header-employee m-0 d-flex flex-row justify-content-start align-items-center col-md-11 flex-wrap" style="height: 5rem !important;">
                    <div class="h1 col-md-4 col-12 m-0">
                        <h3 class="h3-employee m-0">REPORTS</h3>
                    </div>
                </div>
                <div class="container col-md-11 col-11 d-flex justify-content-start align-items-start h-auto m-0 flex-wrap">
                    <?php foreach ($leaveEmployeeResult as $leave) : ?>
                        <?php if ($leave['leaveStatus'] == 'approved') : ?>
                            <div class="reportContainers shadow rounded-2 h-auto col-md-5 col-12 d-flex flex-row justify-content-center align-items-center flex-wrap p-4 m-1">
                                <h5 class="text-start w-100" style="color: green;">Congratiolations! </h5> <p class="text-start w-100 mb-1">your leave have been approved!</p>
                                <p class="m-0 w-100 text-start">You can see the details here: <a href="reports.php?users_id=<?= $leave["users_id"] ?? '' ?>&leave_id=<?= $leave["leave_id"] ?? ''?>&open_pdf=1" class="btn btn-primary">view</a></p>
                            </div>
                        <?php endif ?>
                        <?php if ($leave['leaveStatus'] == 'disapprove') : ?>
                            <div class="reportContainers shadow rounded-2 h-auto col-md-5 col-12 d-flex flex-row justify-content-center align-items-center flex-wrap p-4 m-1">
                                <h5 class="text-start w-100" style="color: red;">We were sorry but, </h5> <p class="text-start w-100 mb-1">your leave have been disapproved!</p>
                                <p class="m-0 w-100 txt-start">You can see the details here: <a href="reports.php?users_id=<?= $leave["users_id"] ?? '' ?>&leave_id=<?= $leave["leave_id"] ?? ''?>&open_pdf=1" class="btn btn-primary">view</a></p>
                            </div>
                         <?php endif ?>
                    <?php endforeach ?>
                </div>
            </div>
        </div>
    </div>
</main>
<?php include '../../templates/Ufooter.php'?>