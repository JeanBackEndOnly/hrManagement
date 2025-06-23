<?php include '../../templates/Uheader.php';?>

<main>
    <div class="header d-flex flex-row justify-content-between align-items-center w-100" style="height: 2rem;">
        <div class="logo d-flex flex-row align-items-center">
            <img src="../../assets/image/pueri-logo.png" class="mx-3" style="width: 7%; height: auto;"  alt="">
            <h4>Zamboanga Puericulture Center</h4>
        </div>
        <a href="../logout.php" class="me-3">Logout</a>
    </div>
    <div class="form-group h-100 w-100 d-flex justify-content-center align-items-center flex-column">
        <div class="container w-75 h-50 shadow rounded-2 p-3 d-flex justify-content-center align-items-center flex-column">
            <div class="w-75 d-flex justify-content-center align-items-center m-0 p-0">
                <h3 class="text-center">Your account have been rejected!</h3>
            </div>
            <div class="w-75 d-flex justify-content-center align-items-center m-0 p-0">
                <h3 class="text-center">Please come to the HR office for clarification... Thank you!</h3>
            </div>
        </div>
    </div>
</main>

<script src="../../assets/js/hr/hrmain.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="../../webApp/main.js"></script>
<?php include '../../templates/Ufooter.php'?>