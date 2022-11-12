<?php include "includes/header.php" ?>
<?php include "includes/nav.php";

$pass_object = new \App\Classes\Password();

$pass_object->pendingEmail();

$email = sanitize($_GET['email']);

include 'src/forms/pass_pending_form.php';