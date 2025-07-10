<?php include '../auth/functions.php';
require_once '../installer/session.php';
require_once '../auth/view.php'; 
?>
<?php initInstaller();
    $signup = false;
    $username = false;
    $passwordChange = false;
    $code = false;
    $password = false;
    $passwordLogin = false;
    $usernameLogin = false;
    if(isset($_GET['signup']) && $_GET['signup'] === 'success'){
        $signup = true;
    }elseif(isset($_GET['username']) && $_GET['username'] === 'failed'){
        $username = true;
    }elseif(isset($_GET['passwordChange']) && $_GET['passwordChange'] === 'success'){
        $passwordChange = true;
    }elseif(isset($_GET['code']) && $_GET['code'] === 'notMatch'){
        $code = true;
    }elseif(isset($_GET['password']) && $_GET['password'] === 'notMatch'){
        $password = true;
    }elseif(isset($_GET['passwordLogin']) && $_GET['passwordLogin'] === 'wrong'){
        $passwordLogin = true;
    }elseif(isset($_GET['usernameLogin']) && $_GET['usernameLogin'] === 'wrong'){
        $usernameLogin = true;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN</title>
    <?php render_styles()?>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <script>
        var base_url = '<?php echo base_url(); ?>';
        console.log('Base URL: ' + base_url);
        const signup = <?php echo json_encode($signup); ?>;
        const username = <?php echo json_encode($username); ?>;
        const passwordChange = <?php echo json_encode($passwordChange); ?>;
        const code = <?php echo json_encode($code); ?>;
        const password = <?php echo json_encode($password); ?>;
        const passwordLogin = <?php echo json_encode($passwordLogin); ?>;
        const usernameLogin = <?php echo json_encode($usernameLogin); ?>;
    </script>
    <style>
        body, main, h1, h2, h3, h4, h5{
            font-family: 'Poppins', sans-serif;
        }

    </style>
</head>
    <body class="body w-50">