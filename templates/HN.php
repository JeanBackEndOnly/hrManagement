<?php function renderHeader() { ?>
<div class="header d-flex header-bg align-items-center justify-content-between px-3 m-0"
    style="height: 60px; min-width: 100%;">
    <div class="logo d-flex align-items-center">
        <!-- <button type="button" onclick="sideNav();"><i class="fa-solid text-white fa-bars fs-4 me-3" style="color: #fff;"></i></button> -->
        <img src="../../assets/image/pueri-logo.png" alt="Logo" style="height: 40px;" class="me-2">
        <h4 class="m-0">ZAMBOANGA PUERICULTURE CENTER</h4>
    </div>

    <div class="usersButton d-flex align-items-center">
        <a href="settings.php"><i class="fa-solid text-white fa-gear btn-confirm" style="color: #fff;"></i></a>
        <button class="me-3" style="background: none; border:none; width: 20px;" onclick="logoutButton()"><i
                class="fa-solid text-white fa-right-from-bracket ms-3" style="color: #fff;"></i></button>
        <button class="align-items-center" type="button" onclick="userButton()">
            <img src="../../assets/image/admin.png" class="rounded-circle me-2 ms-4" style="height: 35px; width: 35px;">
            <span class="fw-bold" style="color: #fff;">ADMIN</span>
        </button>
    </div>
</div>
<script>
document.querySelectorAll('.btn-confirm').forEach(btn => {
    // alert('button clicked');
    btn.addEventListener('click', function () {
        const loader = document.getElementById('loaderOverlay');
        if (loader) {
            loader.style.display = 'flex';
        }
        setTimeout(() => loader.style.display = 'none', 3000);
    });
});
function logoutButton() {
    document.getElementById("logoutDiv").style.display = 'flex';
}

function logoutNo() {
    document.getElementById("logoutDiv").style.display = 'none';
}
</script>
<div class="logout flex-column LogoutAniamtion " id="logoutDiv" class="p-3"
    style="position: fixed; transform: translate(-50%, -50%); top:50%; left:50%; display: none; z-index: 55;">
    <div class="shadow rounded p-0 logoutMediaWidth" style="background-color: #fff !important;">
        <div class="question mb-3 d-flex flex-column h-auto BGGradiant p-3 rounded-top-2">
            <span style="font-family: 'Jomhuria', cursive !important;" class="fs-2 text-white">LOGOUT
                CONFIRMATION</span>
            <span class="text-white">Are you sure you want to logout?</span>
        </div>
        <div class="buttons d-flex flex-row justify-content-evenly w-100 mt-1 pb-4">
            <a href="logout.php" id="logoutYes" class="col-md-5 btn btn-danger btn-sm mt-2 buttonLogoutMedia">Yes</a>
            <button id="logoutNo" class="col-md-5 btn btn-secondary btn-sm mt-2 buttonLogoutMedia"
                onclick="logoutNo()">No</button>
        </div>
    </div>
</div>
<?php } ?>
<?php function renderNav() { ?>
<div class="sideNav px-2 pt-2 BGGradiantNav d-flex flex-column align-items-center h-100 w-auto p-0">
    <div class="navs p-0 m-0  col-md-11 d-flex flex-column align-items-center">
        <li
            class="p-0 p-2 px-2 m-0 h-100 my-2 ms-3 hoverNavs shadow-sm rounded-1 li-width d-flex align-items-center dashboard">
            <a class="d-flex m-0 align-items-center" href="dashboard.php">
                <i id="dashoardi" class="fa-solid text-black fa-house fs-5 me-2 me-side-text2"></i>
                <p class="text-start text-black side-text m-0 text-width text-start pdashboard m-0">Dashboard</p>
            </a>
        </li>
        <li
            class="p-0 p-2 px-2 m-0 h-100 my-2 ms-3 hoverNavs shadow-sm rounded-1 li-width d-flex align-items-center hr">
            <a class="d-flex m-0 align-items-center" href="hrNavigations.php">
                <i class="fa-solid me-2 fa-users text-black hrP me-side-text1"></i>
                <p class="text-start text-black side-text m-0 text-width text-start hrP me-side-text1">MANAGE HR</p>
            </a>
        </li>
        <li
            class="p-0 p-2 px-2 m-0 h-100 my-2 ms-3 hoverNavs shadow-sm rounded-1 w-auto d-flex align-items-center payroll">
            <a class="d-flex m-0 align-items-center" href="payrollNav.php">
                <i class="fa-solid me-2 text-black fa-peso-sign payrollP"></i>
                <p class="text-start text-black side-text m-0 text-width text-start payrollP">MANAGE PAYROLL</p>
            </a>
        </li>
        <li class="p-0 p-2 px-2 m-0 h-100 my-2 ms-3 hoverNavs shadow-sm rounded-1 li-width d-flex align-items-center">
            <a class="d-flex m-0 align-items-center" href="#">
                <i class="fa-solid text-black me-2 fa-clock d-flex align-items-center"></i>
                <p class="text-start text-black side-text m-0 text-width text-start"> ATTENDANCE</p>
            </a>
        </li>
        <li
            class="p-0 p-2 px-2 m-0 h-100 my-2 ms-3 hoverNavs shadow-sm rounded-1 settings d-flex li-width align-items-center">
            <a class="d-flex m-0 align-items-center" href="settings.php">
                <i class="fa-solid text-black me-2 fa-gear d-flex align-items-center settings"></i>
                <p class="text-start text-black side-text m-0 text-width text-start settings">SETTINGS</p>
            </a>
        </li>
    </div>

</div>
<?php } ?>

<!-- =================================== EMPLOYEE AREA ====================================== -->

<?php function renderNavEmployee() { ?>
<div class="sideNav px-2 pt-2 BGGradiantNav d-flex flex-column align-items-center h-100 w-auto p-0">
    <div class="navs p-0 m-0  col-md-11 d-flex flex-column align-items-center">
        <li
            class="p-0 p-2 px-2 m-0 h-100 my-2 ms-3 hoverNavs shadow-sm rounded-1 li-width d-flex align-items-center dashboard">
            <a class="d-flex m-0 align-items-center" href="dashboard.php">
                <i id="dashoardi" class="fa-solid text-black fa-house fs-5 me-2 me-side-text2"></i>
                <p class="text-start text-black side-text m-0 text-width text-start pdashboard m-0">Dashboard</p>
            </a>
        </li>
        <li
            class="p-0 p-2 px-2 m-0 h-100 my-2 ms-3 hoverNavs shadow-sm rounded-1 li-width d-flex align-items-center hr">
            <a class="d-flex m-0 align-items-center" href="hrNavigations.php">
                <i class="fa-solid me-2 fa-users text-black hrP me-side-text1"></i>
                <p class="text-start text-black side-text m-0 text-width text-start hrP me-side-text1">MANAGE HR</p>
            </a>
        </li>
        <li class="p-0 p-2 px-3 m-0 h-100 my-2 ms-3 hoverNavs shadow-sm rounded-1 w-auto d-flex align-items-center">
            <a class="d-flex m-0 align-items-center" href="payrollNav.php">
                <i class="fa-solid me-2 text-black fa-peso-sign"></i>
                <p class="text-start text-black side-text m-0 text-width text-start">MANAGE PAYROLL</p>
            </a>
        </li>
        <li class="p-0 p-2 px-2 m-0 h-100 my-2 ms-3 hoverNavs shadow-sm rounded-1 li-width d-flex align-items-center">
            <a class="d-flex m-0 align-items-center" href="#">
                <i class="fa-solid text-black me-2 fa-clock d-flex align-items-center"></i>
                <p class="text-start text-black side-text m-0 text-width text-start"> ATTENDANCE</p>
            </a>
        </li>
        <li
            class="p-0 p-2 px-2 m-0 h-100 my-2 ms-3 hoverNavs shadow-sm rounded-1 d-flex li-width align-items-center settings">
            <a class="d-flex m-0 align-items-center" href="settings.php">
                <i class="fa-solid text-black me-2 fa-gear d-flex align-items-center settingsp"></i>
                <p class="text-start text-black side-text m-0 text-width text-start settingsp ">SETTINGS</p>
            </a>
        </li>
    </div>
</div>
<?php } ?>


<?php function mediaNavEmployee() { ?>
<?php
        $pdo = db_connection();
        $query = "SELECT * FROM users WHERE id = :id";
        $stmt = $pdo->prepare($query);   
        $stmt->bindParam(":id", $_SESSION["user_id"]);
        $stmt->execute();
        $EmployeeData = $stmt->fetch(PDO::FETCH_ASSOC);
    ?>
<!-- <style>
        .mediaNavEmployee {
            display: none;
        }
    </style> -->
<div class="mediaNavEmployee w-100 header-bg"
    style="display: none; position: absolute; bottom: 0; left:0; height: 3.5rem;">
    <a href="dashboard.php" class="col-md-2 col-2 p-0 d-flex align-items-center justify-content-center"
        style="margin-left: .4rem; margin-right: .4rem;">
        <i id="dashoardi" class="fa-solid text-white fa-house fs-5 me-2 dashboardNavI"></i>
    </a>
    <a href="hrNavigations.php" class="col-md-2 col-2 p-0 d-flex align-items-center justify-content-center"
        style="margin-left: .4rem; margin-right: .4rem;">
        <i class="fa-solid me-2 fa-users text-white hrP hrNavI"></i>
    </a>
    <a href="profile.php" class="profile col-md-2 col-2 p-0 d-flex align-items-center justify-content-center"
        style="height: 2rem; margin-left: .4rem; margin-right: .4rem;">
        <img src="../../assets/image/upload/<?= htmlspecialchars($EmployeeData["user_profile"]) ?>" alt=""
            style="width: 100px !important; height: 100px !important; border-radius: 50%; position: relative; transform: translate(0, -2rem); background-color: #fff !important; border: solid .5rem #fff;"
            class="borderActiveProfile">
    </a>
    <a href="payrollNav.php" class="col-md-2 col-2 p-0 d-flex align-items-center justify-content-center"
        style="margin-left: .4rem; margin-right: .4rem;">
        <i class="fa-solid me-2 text-white fa-peso-sign"></i>
    </a>
    <a href="#" class="col-md-2 col-2 p-0 d-flex align-items-center justify-content-center"
        style="margin-left: .4rem; margin-right: .4rem;">
        <i class="fa-solid text-white me-2 fa-clock d-flex align-items-center"></i>
    </a>
</div>
<?php } ?>


<?php function renderHeaderEmployee() { ?>
<?php
    $pdo = db_connection();
        $query = "SELECT * FROM users 
        INNER JOIN userinformations ON users.id = userinformations.users_id
        WHERE users.id = :id";
        $stmt = $pdo->prepare($query);   
        $stmt->bindParam(":id", $_SESSION["user_id"]);
        $stmt->execute();
        $EmployeeData = $stmt->fetch(PDO::FETCH_ASSOC);
    ?>
<div class="headerFixer w-100 d-flex">
    <div class="header roundedMedia d-flex header-bg align-items-center justify-content-between px-2 m-0 col-md-12 col-11"
        style="height: 60px; max-width: 100%;">
        <div class="logo d-flex align-items-center  col-md-6 col-8">
            <img src="../../assets/image/pueri-logo.png" alt="Logo" style="height: 40px;">
            <h4 class="m-0 textWidthMediaTitle p-0 ">ZAMBOANGA PUERICULTURE CENTER</h4>
        </div>

        <div class="usersButton d-flex align-items-center justify-content-end col-md-6 col-4 m-0 p-0">
            <a href="settings.php" class="d-flex align-items-center"><i
                    class="fa-solid text-white fa-gear settingsNavI fs-5" style="color: #fff;"></i></a>
            <button class="me-4" style="background: none; border:none; width: 20px;" onclick="logoutButton()"><i
                    class="fa-solid text-white fa-right-from-bracket ms-3 me-3 fs-5" style="color: #fff;"></i></button>
            <a href="profile.php?users_id=<?= $EmployeeData["users_id"] ?>" class="m-0 p-0 d-flex align-items-center">
                <img src="../../assets/image/upload/<?= htmlSpecialChars($EmployeeData["user_profile"]) ?>" alt=""
                    style="width: 45px; height: 45px; border-radius: 50%;" class="hideMedia ms-3 me-3">
                <span class="hideMedia me-3 text-white"><?= htmlSpecialChars($EmployeeData["lname"]) ?></span>
            </a>
        </div>
    </div>
    <script>
    function logoutButton() {
        document.getElementById("logoutDiv").style.display = 'flex';
    }

    function logoutNo() {
        document.getElementById("logoutDiv").style.display = 'none';
    }
    </script>
    <div class="logout flex-column LogoutAniamtion " id="logoutDiv" class="p-3"
        style="position: fixed; transform: translate(-50%, -50%); top:50%; left:50%; display: none; z-index: 55;">
        <div class="shadow rounded p-0 logoutMediaWidth" style="background-color: #fff !important;">
            <div class="question mb-3 d-flex flex-column h-auto BGGradiant p-3 rounded-top-2">
                <span style="font-family: 'Jomhuria', cursive !important;" class="fs-2 text-white">LOGOUT
                    CONFIRMATION</span>
                <span class="text-white">Are you sure you want to logout?</span>
            </div>
            <div class="buttons d-flex flex-row justify-content-evenly w-100 mt-1 pb-4">
                <a href="logout.php" id="logoutYes"
                    class="col-md-5 btn btn-danger btn-sm mt-2 buttonLogoutMedia">Yes</a>
                <button id="logoutNo" class="col-md-5 btn btn-secondary btn-sm mt-2 buttonLogoutMedia"
                    onclick="logoutNo()">No</button>
            </div>
        </div>
    </div>
</div>


<?php } ?>