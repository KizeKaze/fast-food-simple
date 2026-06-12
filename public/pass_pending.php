<?php

require_once __DIR__ . '/../php-config/init.php';

$pass_object = new \App\Classes\Password();

$pass_object->pendingEmail();

$email = sanitize($_GET['email']);
include __DIR__ . "/../templates/layout/header.php";
include __DIR__ . "/../templates/layout/nav.php";
include 'src/forms/pass_pending_form.php';
?>