<?php include '../../templates/funcHeader.php';?>

<main class="w-100">
    <div class="main-body w-100 h-100 m-0 p-0 d-flex justify-content-center align-items-center">

        <div class="d-flex w-100 align-items-center justify-content-center" style="height: 91%">
            <div class="contents shadow rounded-2 w-100 h-auto d-flex flex-column align-items-center p-5 justify-content-center p-0 m-0" style="background-color: #f7f7f7;">
                <div class="header-employee d-flex flex-row justify-content-between align-items-center " style="height: 5rem; width: 95%;">
                    <div class="h1">
                        <h3 class="m-0">Change Password</h3>
                    </div> 
                </div>
                <div class="container w-100 p-0" id="changePAsswordID" style="display: flex;">
                    <div class="container  p-0 ">
                        <form class="w-100" method="POST" action="../../auth/authentications.php">
                                <?php isset($_SESSION["csrf_token"]) && $_SESSION["csrf_token"] !== "" ? $csrf = $_SESSION["csrf_token"] : " null "; ?>
                                <input type="hidden" name="csrf_token" value="<?php echo $csrf; ?>">
                                <input type="hidden" name="usersForgottenPass" value="true">
                            <div class="mb-3 col-md-12">
                                <li class="li-div w-100 flex-column" style="display: flex; list-style-type: none; align-items: start;">
                                    <label for="newPassword" class="form-label text-start fw-bold">Mail Code</label>
                                    <input type="text" class="form-control col-12" name="mailCode" placeholder="Mail Code" required id="mailCode" style="flex: 1;">
                                </li>
                            </div>
                            <!-- ==================== MAMAYA NAYUNG EMAIL NAKAKA BUSIT DI MA FIX! ===================== -->
                            <div class="mb-3">
                                <li class="li-div w-100 flex-column" style="display: flex; list-style-type: none; align-items: start;">
                                    <label for="newPassword" class="form-label text-start fw-bold">New Password</label>
                                    <input type="password" class="form-control" name="new_password" placeholder="New Password" required id="passInput" style="flex: 1;">
                                    
                                    <button type="button" id="showPasswords" style="background: none; border: none;  position:fixed; right: 27rem; transform: translateY(2rem); margin-left: 5px;">
                                        <i class="fa-solid fa-eye"></i>
                                    </button>

                                    <button type="button" id="hidePasswords" style="background: none; border: none; position:fixed; right: 27rem; transform: translateY(2rem); margin-left: 5px; display: none;">
                                        <i class="fa-solid fa-eye-slash"></i>
                                    </button>
                                </li>
                            </div>

                            <div class="mb-3">
                                <li class="li-div w-100 flex-column justify-content-start" style="display: flex; list-style-type: none; align-items: start;">
                                    <label for="confirmPassword" class="form-label text-start fw-bold">Confirm New Password</label>
                                    <input type="password" class="form-control" name="confirm_password" placeholder="Confirm Password" required id="chInput" style="flex: 1;">
                                    
                                    <button type="button" id="showConfirmPasswords" style="background: none; border: none;  position:fixed; right: 27rem; transform: translateY(2rem); margin-left: 5px;">
                                        <i class="fa-solid fa-eye"></i>
                                    </button>

                                    <button type="button" id="hideConfirmPasswords" style="background: none; border: none; position:fixed; right: 27rem; transform: translateY(2rem); margin-left: 5px; display: none;">
                                        <i class="fa-solid fa-eye-slash"></i>
                                    </button>
                                </li>
                            </div>
                            <button type="submit" class="btn btn-success">Change Password</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<div id="loadingAnimationSettings" style="display:none;">
    <div class="loading-lines">
        <div class="line"></div>
        <div class="line"></div>
        <div class="line"></div>
    </div>
</div>
<script>
     document.addEventListener('DOMContentLoaded', () => {
        if (code) {
            console.log("Showing updateReq toast");
            Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'error',
            title: 'Mail code not match!, Please try again.',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            customClass: { popup: 'swal2-row-toast' }
            });
            removeUrlParams(['code']);
        }
        function removeUrlParams(params) {
            const url = new URL(window.location);
            params.forEach(param => url.searchParams.delete(param));
            window.history.replaceState({}, document.title, url.toString());
        }
    });
</script>
<script src="../../assets/js/hr/changePass.js"></script>
<?php include '../../templates/funcFooter.php'?>