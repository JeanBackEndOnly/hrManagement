<?php include '../templates/RLheader.php';?>
    <main id="main" class="login-page mb-3 px-0">
        <div class="container px-0 w-100">
            <div class="row">
                    <div class="card h-50 w-100 px-4 rounded-2">
                        <?php
                            loginErros()
                        ?>
                         <div class="body-header mb-1 mt-4 w-100">
                            <h3 class="text-center">ZAMBOANGA PUERICULTURE CENTER</h3>
                        </div>
                        <div class="card-header p-0 w-100 mb-2">
                            <h4 class="fs-4 text-start p-0 ">Login</h4>
                        </div>
                        <div class="card-body w-100 p-0">
                            <form action = "../auth/authentications.php" method = "post">
                                <?php isset($_SESSION["csrf_token"]) && $_SESSION["csrf_token"] !== "" ? $csrf = $_SESSION["csrf_token"] : " null "; ?>
                                <input type="hidden" name="csrf_token" value="<?php echo $csrf; ?>">
                                <input type="hidden" name="loginAuth" value="true">
                                <div class="mb-3">
                                    <input type="text" class="form-control rounded-1"  name="username" placeholder="Username: " required>
                                </div>
                                <div class="mb-3">
                                    <li  class="li-div w-100" style="display: flex; list-style-type: none; align-items: center;">
                                        <input type="password" class="form-control rounded-1"  name="password" placeholder="Password" required id="passwordInput" style="flex: 1;">
                                        
                                        <button type="button" id="showPassword" style="background: none; border: none;  position:fixed; right: 2rem; margin-left: 5px;">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>

                                        <button type="button" id="hidePassword" style="background: none; border: none; position:fixed; right: 2rem; margin-left: 5px; display: none;">
                                            <i class="fa-solid fa-eye-slash"></i>
                                        </button>
                                    </li>
                                </div>
                                <div class="mb-3 text-center w-100">
                                    <button type="submit" class="btn btn-primary w-100 p-2 mb-0">Login</button>
                                </div>
                                <div class="mb-3 text-center">
                                    <a href="register.php" style="color: blue;">Register</a>
                                </div>
                            </form>
                        </div>
                    </div>
            </div>
        </div>
    </main>
<?php include '../templates/RLfooter.php'?>