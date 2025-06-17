<?php include '../auth/functions.php'; require_once '../installer/session.php';  require_once '../auth/view.php';  ?>
<?php initInstaller();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?php echo get_option('system_description')?>">
    <title><?php echo get_option('system_title')?></title>
    <?php render_styles()?>
    <link rel="stylesheet" href="../assets/css/hr.css?v=<?php echo time() ?>">
    <link rel="manifest" href="../webApp/manifest.json">
    <script> 
        var base_url = '<?php echo base_url() ?>';
        
    </script>
</head>
    <body class="bg-light-300">