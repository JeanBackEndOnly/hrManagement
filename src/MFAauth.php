<?php include '../templates/RLheader.php'; ?>
<div class="hehe h-auto w-75 d-flex justify-content-start align-items-start" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
    <div class="heh w-100 h-25 d-flex justify-content-center flex-column align-items-center m-0 p-0 rounded-2"
        style="background-color: #f0f0f0;">
        <form method="POST" action="../auth/authentications.php" class="modal-content">
            <?php isset($_SESSION["csrf_token"]) && $_SESSION["csrf_token"] !== "" ? $csrf = $_SESSION["csrf_token"] : " null "; ?>
            <input type="hidden" name="csrf_token" value="<?php echo $csrf; ?>">
            <input type="hidden" name="loginAuth" value="true">    
            <div class="emailAuth w-100 d-flex flex-column justify-content-start align-items-start m-0 py-3 px-4 shadow"
                style="background-color: #f0f0f0; 
                border-bottom-left-radius: 0 !important;
                border-bottom-right-radius: 0 !important;
                border-top-left-radius: 10px !important;
                border-top-right-radius: 10px !important;
                ">
                <label for="emailLabel" class="m-0 text-center me-1 fs-4">Enter Authentication Code:</label>
                <input type="text" name="mailCode" id="emailLabel" class="form-control w-100" placeholder="Authentication Code" required>
            </div>
            <div class="button w-100 d-flex justify-content-center m-0">
                <button class="btn btn-primary w-100 p-2 m-0"
                style="border-top-left-radius: 0 !important;
                border-top-right-radius: 0 !important;
                border-bottom-right-radius: 5px !important;
                border-bottom-left-radius: 5px !important;
                ">Confirm</button>
            </div>
        </form>
    </div>
</div>
<?php include '../templates/RLfooter.php'; ?>