<?php include '../templates/RLheader.php'; ?>
    
    <div class="heh w-100 h-25 d-flex justify-content-center flex-column align-items-center m-0 p-0 rounded-2" style="background-color: #f0f0f0;">
     <form method="POST" action="../auth/authentications.php" class="modal-content">
             <?php isset($_SESSION["csrf_token"]) && $_SESSION["csrf_token"] !== "" ? $csrf = $_SESSION["csrf_token"] : " null "; ?>
            <input type="hidden" name="csrf_token" value="<?php echo $csrf; ?>">
            <input type="hidden" name="usersForgottenPass" value="true">    
            <div class="emailAuth w-100 d-flex flex-row justify-content-center align-items-center m-0 p-4" >
                <label for="emailLabel" class="m-0 text-center me-1 fs-5">Get code via Email</label>
                <input type="radio" name="AuthType" value="emailAuth" id="emailLabel">
            </div>
            <div class="phoneAuth w-100 d-flex justify-content-center align-items-center m-0 p-4" >
                <label for="phoneLabel" class="text-center m-0 me-1 fs-5">Get code via SMS</label>
                <input type="radio" name="AuthType" value="phoneAuth" id="phoneLabel">
            </div>
            <div class="button w-100 d-flex justify-content-center">
                <button class="btn btn-primary w-50">Confirm</button>
            </div>
            
        </form>
    </div>

<?php include '../templates/RLfooter.php'; ?>