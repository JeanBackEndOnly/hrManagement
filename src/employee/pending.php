<?php include '../../templates/pendingHeader.php'; ?>
    <main>
    <div class="header d-flex flex-row justify-content-between align-items-center w-100" style="height: 2rem;">
        <div class="logo d-flex flex-row align-items-center">
            <img src="../../assets/image/pueri-logo.png" class="mx-3" style="width: 7%; height: auto;"  alt="">
            <h4>Zamboanga Puericulture Center</h4>
        </div>
        <a href="pendingPDS.php?users_id=<?= $_SESSION["pending_user_id"] ?>" class="btn btn-primary">PDS</a>
        <a href="../logout.php" class="me-3">Logout</a>
    </div>
    <div class="form-group h-100 w-100 d-flex justify-content-center align-items-center flex-column">
        <div class="container w-75 h-50 shadow rounded-2 p-3 d-flex justify-content-center align-items-center flex-column">
            <div class="w-75 d-flex justify-content-center align-items-center m-0 p-0">
                <h3 class="text-center">Waiting for HR admin to accept your account!</h3>
            </div>
            <div class="w-75 d-flex justify-content-center align-items-center m-0 p-0">
                <h3 class="text-center">Please wait patiently and we will email you soon... Thank you!</h3>
            </div>
        </div>
    </div>
</main>

<?php include '../../templates/Ufooter.php'; ?>