
<?php
    if (isset($_GET['image'])) {
        $imagePath = $_GET['image'];
        echo '<img src="../../assets/image/upload/' . $imagePath  .'" alt="Leave Proof">';
    } else {
        echo "No image provided.";
    }
?>
