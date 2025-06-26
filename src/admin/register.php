<?php include '../../templates/Uheader.php'; include '../../templates/regHeader.php';?>
 
 <main id="main" class="login-page">
    <?php
        registerEmployeeAdmin();
    ?>
    <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 9999;">
        <?php if (!empty($_SESSION['errors_login'])): ?>
            <?php foreach ($_SESSION['errors_login'] as $msg): ?>
            <div class="toast align-items-center text-bg-danger border-0 mb-2" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="true" data-bs-delay="5000">
                <div class="d-flex">
                <div class="toast-body"><?= htmlspecialchars($msg) ?></div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            </div>
            <?php endforeach; unset($_SESSION['errors_login']); ?>
        <?php endif; ?>

        <?php if (!empty($_SESSION['signup_errors'])): ?>
            <?php foreach ($_SESSION['signup_errors'] as $msg): ?>
            <div class="toast align-items-center text-bg-danger border-0 mb-2" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="true" data-bs-delay="5000">
                <div class="d-flex">
                <div class="toast-body"><?= htmlspecialchars($msg) ?></div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            </div>
            <?php endforeach; unset($_SESSION['signup_errors']); ?>
        <?php endif; ?>
    </div>
</main>
<script>
function showLoaderThen(callback) {
    const loader = document.getElementById("loading-overlay");
    loader.style.display = "flex";

    setTimeout(() => {
        loader.style.display = "none";
        callback();
    }, 800); 
}       // ←———— immediately-invoked wrapper ends here

</script>
<script src="../../assets/js/hr/adminRes.js"></script>
<?php include '../../templates/Ufooter.php'?>