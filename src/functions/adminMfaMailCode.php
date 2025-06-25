<?php include '../../templates/funcHeader.php'; ?>
<div class="hehe h-75 w-100 d-flex justify-content-start align-items-start">
    <div class="heh w-100 h-25 d-flex justify-content-center flex-column align-items-center m-0 p-0 rounded-2" >
        <form method="POST" action="../../auth/authentications.php" class="modal-content">
             <?php isset($_SESSION["csrf_token"]) && $_SESSION["csrf_token"] !== "" ? $csrf = $_SESSION["csrf_token"] : " null "; ?>
            <input type="hidden" name="csrf_token" value="<?php echo $csrf; ?>">
            <input type="hidden" name="loginAuth" value="true">    
            <div class="emailAuth w-100 d-flex flex-column justify-content-start align-items-start m-0 py-3 px-4 rounded-2 shadow" style="background-color: #f0f0f0;">
                <label for="emailLabel" class="m-0 text-center me-1 fs-4">Enter Authentication Code:</label>
                <input type="text" name="AdminMailCode" id="emailLabel" class="form-control w-100" placeholder="Authentication Code" required>
            </div>
            <div class="button w-100 d-flex justify-content-center">
                <button class="btn btn-primary w-100 p-2">Confirm</button>
            </div>
            
        </form>
    </div>
</div>
<!-- <script src="../../assets/js/hr/login.js"></script> -->
<script>
document.addEventListener('DOMContentLoaded', () => {
        if (mfa) {
            console.log("Showing updateReq toast");
            Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'error',
            title: 'Mail code not match, please try again..!.',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            customClass: { popup: 'swal2-row-toast' }
            });
            removeUrlParams(['mfa']);
        }

        function removeUrlParams(params) {
            const url = new URL(window.location);
            params.forEach(param => url.searchParams.delete(param));
            window.history.replaceState({}, document.title, url.toString());
        }
});
</script>
<?php include '../../templates/funcFooter.php'; ?>