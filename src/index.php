<?php include '../templates/RLheader.php'; ?>
<main id="main" class="login-page mb-3 px-0">
    <div class="container px-0 w-100">
        <div class="row">
            <div class="card h-50 w-100 px-4 rounded-2">
                <?php 
                //loginErros(); ?>
                <div class="body-header mb-1 mt-4 w-100">
                    <h3 class="text-center">ZAMBOANGA PUERICULTURE CENTER</h3>
                </div>
                <div class="card-header p-0 w-100 mb-2">
                    <h4 class="fs-4 text-start p-0">Login</h4>
                </div>
                <?php
                // if($_SESSION["user_id"] !== ''){ ?>
                <div class="card-body w-100 p-0">
                    <form action="../auth/authentications.php" method="post">
                         <?php isset($_SESSION["csrf_token"]) && $_SESSION["csrf_token"] !== "" ? $csrf = $_SESSION["csrf_token"] : " null "; ?>
                        <input type="hidden" name="csrf_token" value="<?php echo $csrf; ?>">
                        <input type="hidden" name="loginAuth" value="true">
                        <div class="mb-3">
                            <input type="text" class="form-control rounded-1" name="username" placeholder="Username: " required>
                        </div>
                        <div class="mb-3">
                            <li class="li-div w-100" style="display: flex; list-style-type: none; align-items: center; position: relative;">
                                <input type="password" class="form-control rounded-1" name="password" placeholder="Password" required id="passwordInputs" style="flex: 1;">
                                <button type="button" id="showPasswords" style="background: none; border: none; position: absolute; right: 1rem;">
                                    <i class="fa-solid fa-eye"></i>
                                </button>
                                <button type="button" id="hidePasswords" style="background: none; border: none; position: absolute; right: 1rem; display: none;">
                                    <i class="fa-solid fa-eye-slash"></i>
                                </button>
                            </li>
                        </div>
                        <div class="mb-3 mt-3 text-center w-100">
                            <button type="submit" class="btn btn-primary w-100 p-2 mb-0">Login</button>
                        </div>
                    </form>
                    <button class="btn btn-sm" style="background: none; box-shadow: none; color: blue;" data-bs-toggle="modal" data-bs-target="#changePassword">Forgot Password?</button>
                    <div class="mb-3 text-center">
                        <a href="register.php" style="color: blue;">Register</a>
                    </div>
                </div>
                <?php 
            // } ?>
            </div>
        </div>
    </div>
</main>

<div class="modal fade" id="changePassword" tabindex="-1" aria-labelledby="passwordModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="../auth/authentications.php" class="modal-content">
             <?php isset($_SESSION["csrf_token"]) && $_SESSION["csrf_token"] !== "" ? $csrf = $_SESSION["csrf_token"] : " null "; ?>
            <input type="hidden" name="csrf_token" value="<?php echo $csrf; ?>">
            <input type="hidden" name="usersForgottenPass" value="true">
            <div class="modal-header bg-success">
                <h5 class="modal-title text-start w-100" id="passwordModalLabel" style="color: #fff;">Enter your username:</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <label for="usernameConfim">Username:</label>
                <input type="text" name="usernameAuth" id="usernameConfim" class="form-control" required>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Confirm</button>
            </div>
        </form>
    </div>
</div>
<script>
  if ('serviceWorker' in navigator) {
    navigator.serviceWorker.register('./service-worker.js')
      .then(reg => console.log('✅ SW registered ➜', reg.scope))
      .catch(err => console.error('ServiceWorker registration failed:', err));
  }
</script>
<script src="../assets/js/hr/login.js"></script>
<?php include '../templates/RLfooter.php'; ?>
