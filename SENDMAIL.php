<?php
$to = 'daligdig.manuel19@gmail.com';
$subject = 'Hello from XAMPP!';
$message = 'This is a test email sent using PHP mail() and Fake Sendmail on XAMPP.';
$headers = "From: pagotaisidromarcojean@gmail.com\r\n";
$headers .= "Reply-To: pagotaisidromarcojean@gmail.com\r\n";
$headers .= "X-Mailer: PHP/" . phpversion();

if (mail($to, $subject, $message, $headers)) {
    echo "SUCCESS: Mail sent.";
} else {
    echo "ERROR: Mail not sent.";
}
?>
