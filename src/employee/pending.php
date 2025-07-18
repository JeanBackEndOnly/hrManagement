<?php include '../../templates/pendingHeader.php'; ?>
<main class="mediaMain d-flex flex-column align-items-center justify-content-start">
    <div class="headerMedia d-flex flex-row justify-content-between align-items-center col-md-12 col-11 h-auto p-2 headerDesktop">
        <div class="logo d-flex flex-row align-items-center col-md-7 col-10 m-0 p-0">
            <img src="../../assets/image/pueri-logo.png" class="mx-2" style="width: 40px; height: 40px !important;"  alt="">
            <h3 class="m-0 w-100 mediah3">Zamboanga Puericulture Center</h3>
        </div>
        <a href="pendingPDS.php?users_id=<?= $_SESSION["pending_user_id"] ?>" class="btn btn-primary col-md-1 col-2 m-0 p-1">PDS</a>
        <!-- <a href="../logout.php" class="me-3 fw-bold">Logout</a> -->
    </div>
    <div class="form-group h-100 w-100 d-flex justify-content-center align-items-center flex-column">
        <span class="col-md-12 col-12 text-center p-2 fw-bold text-muted">Waiting for admin approval</span>
        <a href="../index.php" class="col-md-3 col-6 text-center h-auto p-2 text-white fw-bold rounded-2" style="background-color: #E32126 !important; ">Back to login</a>
    </div>
</main>

<?php include '../../templates/Ufooter.php'; ?>