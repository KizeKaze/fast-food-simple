<?php include "includes/header.php" ?>
<?php include "includes/nav.php"; ?>
<?php

if (isset($_POST['new_password'])) {
    echo "Okay sport you're in here";
}

$token = sanitize($_GET['token']);

include 'src/forms/new_pass_form.php';
