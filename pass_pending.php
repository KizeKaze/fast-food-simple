<?php include "includes/header.php" ?>
<?php include "includes/nav.php"; ?>

<?php
if (!$_GET['email']) {
    $_SESSION['failure'] = "What are you doing..";
    header('Location: enter_email.php');
    exit();
}

$email = sanitize($_GET['email']);

include 'src/forms/pass_pending_form.php';