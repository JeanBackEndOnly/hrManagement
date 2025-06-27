<?php
require_once '../../../installer/session.php';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?= $_SESSION['csrf_token'] ?>">
    <title>PUERICULTURE SYSTEM</title>
    <link rel="manifest" href="../../../webApp/manifest.json">
    <link rel="stylesheet" href="../../../assets/css/all.min.css?v=<?php echo time() ?>">
    <link rel="stylesheet" href="../../../assets/css/users.css?v=<?php echo time() ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="../../../assets/js/hr/hrmain.js" defer></script>
    <!-- <base href="http://192.168.1.21/"> -->
    <style>
        body, main {
            font-family: 'Poppins', sans-serif;
        }
    </style>

</head>
<body class="body h-100" style="min-width:100vw;">
