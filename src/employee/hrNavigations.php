<?php include '../../templates/Uheader.php';  include '../../templates/HN.php';?>

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
.hrNavI{
    padding: .5rem;
    border: solid .2rem #fff !important; 
    border-radius: 50%;
}
</style>
<main>
    <div class="main-body w-100 h-100 m-0 p-0">
        <?= renderHeaderEmployee() ?>
        <div class="d-flex w-100 align-items-start" style="height: 91%">
            <?= renderNavEmployee() ?>
            <div class="contents w-100 h-100 d-flex flex-column align-items-center p-0 m-0">
                <div class="header-employee m-0 p-0 mediaTitleMargin d-flex flex-row justify-content-between align-items-center col-md-11 col-11" >
                    <div class="h1 AnimationFinalfirst">
                        <h3 class="m-0 titleFont fontSizeMedia">HR MANAGEMENT</h3>
                        <p style="font-size: 17px !important; margin-top: -1rem !important;" class="m-0 p-0"><span class="fontSizeMediaP m-0 p-0">Hr Navigations</span></p>
                    </div>
                </div>
                <div class="col-md-11 col-11 d-flex flex-wrap m-0 p-0 justify-content-start align-items-center">
                    <a href="leave.php" class="col-md-5 text-black m-0 p-2 px-3 rounded-2 col-11 navigationsContents mt-2 me-4 AnimationFinalfirst h-auto d-flex h-100 align-items-center">
                        <i class="fa-solid fa-circle me-3" style="color: rgb(7, 207, 7)"></i>
                        <i class="fa-solid text-black me-1 d-flex align-items-center fa-file-export"></i>
                        <h5 class="m-0 p-0 fw-bold text-muted">LEAVE REQUEST</h5>
                    </a>
                     <a href="reports.php" class="col-md-5 text-black m-0 p-2 px-3 rounded-2 col-11 navigationsContents mt-2 me-4 AnimationFinalfirst h-auto d-flex h-100 align-items-center">
                        <i class="fa-solid fa-circle me-3" style="color: rgb(7, 207, 7)"></i>
                        <i class="fa-solid text-black me-2 fa-flag"></i>
                        <h5 class="m-0 p-0 fw-bold text-muted">REPORTS</h5>
                    </a>
                     <a href="pds.php" class="col-md-5 text-black m-0 p-2 px-3 rounded-2 col-11 navigationsContents mt-2 me-4 AnimationFinalfirst h-auto d-flex h-100 align-items-center">
                        <i class="fa-solid fa-circle me-3" style="color: rgb(7, 207, 7)"></i>
                        <i class="fa-solid fa-file-word me-2"></i>
                        <h5 class="m-0 p-0 fw-bold text-muted textWidthMedia">PDS</h5>
                    </a>
                </div>
                <?= mediaNavEmployee() ?>
            </div>
        </div>
    </div>
</main>


<?php
 include '../../templates/Ufooter.php';
?>