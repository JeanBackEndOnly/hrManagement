<?php include '../templates/RLheader.php'; ?>

<main id="main" class="installer-page text-center w-100">
    <div class="container">
        <div class="row">
            <div class="card w-100 px-4 py-4 h-50" id="installCenter">
                <div class="body-header m-2">
                    <h3 class="text-center">ZAMBOANGA PUERICULTURE CENTER</h3>
                </div>
                <div class="body-header m-2 w-100 ">
                    <h4 class="text-start fs-4">Sign-up</h4>
                </div>
                    <div class="card-body w-100 p-0">
                        <form id="install-form">
                            <div class="mb-3 col-md-4 w-100">
                                <input type="text" class="form-control rounded-1" name="email" placeholder="E-mail" required>
                            </div>
                            <div class="mb-3 col-md-4 w-100">
                                <input type="text" class="form-control rounded-1" name="username" placeholder="Username" required>
                            </div>
                            <div class="mb-3">
                                <li class="li-div w-100" style="display: flex; list-style-type: none; align-items: center;">
                                    <input type="password" class="form-control" name="password" placeholder="Password" required id="passwordInput" style="flex: 1;">
                                    
                                    <button type="button" id="showPassword" style="background: none; border: none;  position:fixed; right: 2rem; margin-left: 5px;">
                                        <i class="fa-solid fa-eye"></i>
                                    </button>

                                    <button type="button" id="hidePassword" style="background: none; border: none; position:fixed; right: 2rem; margin-left: 5px; display: none;">
                                        <i class="fa-solid fa-eye-slash"></i>
                                    </button>
                                </li>
                            </div>

                            <div class="mb-3">
                                <li class="li-div w-100" style="display: flex; list-style-type: none; align-items: center;">
                                    <input type="password" class="form-control" name="confirm_password" placeholder="Confirm Password" required id="confirmPasswordInput" style="flex: 1;">
                                    
                                    <button type="button" id="showConfirmPassword" style="background: none; border: none;  position:fixed; right: 2rem; margin-left: 5px;">
                                        <i class="fa-solid fa-eye"></i>
                                    </button>

                                    <button type="button" id="hideConfirmPassword" style="background: none; border: none; position:fixed; right: 2rem; margin-left: 5px; display: none;">
                                        <i class="fa-solid fa-eye-slash"></i>
                                    </button>
                                </li>
                            </div>
                            <div class="text-center w-100" style="height: 47px;">
                                <button type="submit" class="btn btn-secondary w-100 p-0 m-0 h-75 rounded-1 ">INSTALL</button>
                            </div>
                        </form>
                   </div>
                </div>
            </div>
        </div>
    </div>

</main>


<script src="../assets/js/hr/hrmain.js"></script>
<?php include '../templates/RLfooter.php' ?>
<!-- 
<?php echo $_SERVER['SERVER_NAME'] ?> -->