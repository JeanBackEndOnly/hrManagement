<?php include '../templates/RLheader.php'; ?>
 <style>
     html, main{
        background: linear-gradient(130deg, #E32126 49.9%, #000000 .1%, #ffffff 50%);
    }
 </style>
 <main id="main" class="login-page">
    <?php
        signup_inputs();
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
<!-- <script src="../assets/js/hr/EmpRes.js" defer></script> -->
<?php include '../templates/RLfooter.php'?>